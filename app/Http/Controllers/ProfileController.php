<?php

namespace App\Http\Controllers;

use App\Helpers\DataProvider;
use App\Http\Controllers\Validation\ProfileRules;
use App\Models\CatalogCats;
use App\Models\District;
use App\Models\Message;
use App\Models\Specialty;
use App\Models\User;
use App\Models\Invite;
use App\Models\Image;

use App\Helpers\Balance;
use App\Helpers\MyTeam;
use App\Helpers\Notify;

use App\Http\Requests;
use App\Notifications\Slack\ReportFromUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Gate;
use Carbon\Carbon;

class ProfileController extends Controller
{

    public function index() {
        $auth = Auth::user();

        return view('profile.index', [
		    'user' => $auth,
		    'images' => $auth->images->first()
		]);
    }

    public function user(User $user) {
		if (Auth::id() == $user->id)
			return redirect('/profile');

        return view('profile.index', [
            'user' => $user,
            'images' => $user->images->first()
        ]);
    }

    public function edit_password() {
        return view('profile.password');
    }

    public function create_invite() {
        $auth = Auth::user();
        if ($auth->can(':actionCreateInvite', $auth))
            return Notify::actionDenied(redirect('/profile/team'));

        if ($auth->cannot('createInvite', $auth))
            return Notify::create('Вы превысили лимит ваших приглашений', 'danger', redirect('/profile/team'));

        $auth->invites()->create([
            "key" => MyTeam::generate_key(30),
            "used_by" => 0,
        ]);
		return Notify::create('Приглашение успешно создано', 'success', redirect('/profile/team'));
    }

    public function update_password(Request $request)
    {
        $auth = Auth::user();
		if ($request->has('password')) {
			$validator = Validator::make($request->all(), ProfileRules::updatePasswordRules())->validate();
            $auth->update([
				'password' => bcrypt($request->input('password')),
			]);
			return Notify::create('Пароль был успешно изменен', 'success', redirect('/profile'));
		}
		return redirect('/profile');
    }

    public function user_confirm(User $user) {
		if ($user->confirmed)
            return Notify::create('Профиль пользователя уже активирован', 'success', redirect('/profile/team'));

        if (Auth::user()->can('confirm', $user)) {
            $user->update(['confirmed' => true]);
            return Notify::create('Профиль пользователя успешно активирован', 'success', redirect('/profile/team'));
        }
		return Notify::create('У Вас нет прав на это действие', 'danger', redirect('/profile/team'));
    }

    public function form() {
        return view('profile.form', ['user' => Auth::user(), 'cats' => CatalogCats::ordered()->get(), 'districts' => District::all()]);
    }

    public function form_update(Request $request) {
        $auth = Auth::user();
        $data = $request->all();
        $valid = ProfileRules::formRules();
        if($request->input('email') != $auth->email)
            $valid = array_add($valid, 'email', ProfileRules::formEmailRules());
        $validator = Validator::make($data, $valid)->validate();

        if($data['birthday'] != "") $data['birthday'] = Carbon::createFromFormat('d / m / Y', $data['birthday'])->toDateString();

        $auth->update([
            'phone' => $data['phone'],
            'email' => $data['email'],
            'district' => $data['district'],
            'birthday' => $data['birthday'],
            'about' => $data['about'],
        ]);
        if (isset($data['foto'])) {
            $fotoName = $auth->id . '-' . time() . '.' . $data['foto']->getClientOriginalExtension();
            $data['foto']->move(public_path('images/uploads/user'), $fotoName);
            $auth->images()->delete();
            $auth->images()->create([
                'file' => $fotoName,
            ]);
        }
        Specialty::where('user_id', $auth->id)->delete();
        if (isset($data['spec']))
            foreach($data['spec'] as $spec)
                if ($spec)
                    $auth->specs_list()->create([
                        'spec_id' => $spec
                    ]);
		return Notify::create('Анкета успешно сохранена', 'success', redirect('/profile'));
    }

    public function transfer() {
        return view('profile.transfer', ['user' => Auth::user()]);
    }

    public function transferDo(Request $request, DataProvider $storage) {
        $auth = Auth::user();
        $data = $request->all();

        if(!MyTeam::inMyTeam(Auth::user(), $data['destination']))
            return Notify::create('Выбран неправильный адресат', 'danger', back());

        $destination = User::findOrFail($data['destination']);

        if (!Balance::checkBalance($auth, $data['sum']))
            return Notify::create('У Вас недостаточно средств для перевода данной суммы', 'danger', back());

        $validator = Validator::make($data, ProfileRules::transferRules())->validate();

        if ($request->method() == "GET")
            Message::where('from', $data['destination'])->where('type', 1)->delete();

        $storage->setBalanceLogItem(collect([$auth, $destination]));
        $storage->setBalanceLogMessage('moneyTransfer');
        Balance::moveBalance($auth, $destination, $data['sum']);

		return Notify::create('Сумма была успешно отправлена '.\morphos\Russian\nameCase($destination->surname.' '.$destination->firstname,'dativus'), 'success', redirect('/profile'));
    }

    public function request() {
        return view('profile.request', ['user' => Auth::user()]);
    }

    public function requestSend(Request $request) {
        $auth = Auth::user();
        $data = $request->all();

        $validator = Validator::make($data, ProfileRules::requestRules())->validate();

        foreach(MyTeam::getMyTeam($auth) as $member)
            Message::create([
                'to' => $member->id,
                'from' => $auth->id,
                'text' => 'Этот пользователь просит перевести ему '.$data['sum'].' '. \morphos\Russian\Plurality::pluralize('рубль', $data['sum']),
                'type' => 1,
                'variable' => $data['sum'],
            ]);

        return Notify::create('Запрос был успешно отправлен вашей команде', 'success', redirect('/profile'));
    }

    public function team() {
        $auth = Auth::user();
        $confirming = array();
        //not confirmed users
        foreach($auth->invited_users->where('confirmed', 1) as $invited)
            foreach($invited->invited_users->where('confirmed', 0) as $person)
                if (Carbon::now()->diffInMinutes($person->created_at->addDays(7), false) > 0) $confirming[] = $person;
                else {
                    $person->invited_by()->update(['used_by' => 0]);
                    foreach($person->images as $image)
                        @unlink(public_path('images/uploads/user/'.$image->file));
                    $person->images()->delete();
                    $person->delete();
                }
        return view('profile.myteam', ['user' => $auth, 'confirming' => $confirming]);
    }

    public function goods() {
        return view('profile.goods', ['user' => Auth::user()]);
    }

    public function services() {
        return view('profile.services', ['user' => Auth::user()]);
    }

    public function report(User $user, Request $request) {
        $auth = Auth::user();
        if ($user->id == $auth->id)
            Notify::create('Вы не можете отправить жалобу на этого пользователя!', 'danger', back());

        Validator::make($request->all(), ProfileRules::reportRules())->validate();

        $auth->notify(new ReportFromUserNotification($user, $request->input('message')));
        return Notify::create('Ваша жалоба была успешно зарегистрирована.', 'success', back());
    }
}
