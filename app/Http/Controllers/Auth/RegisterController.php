<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Validation\ProfileRules;
use App\Models\User;
use App\Models\Invite;
use App\Models\Image;
use App\Models\District;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
	
	
    public function showRegistrationForm(Request $request, $key)
    {
		if ($key !== null) {
			$invite = Invite::where('key', $key)->where('used_by', 0)->get();
			if ($invite->count()) {
				$invited = User::where('id', $invite->first()->user_id)->get()->first();
				return view('auth.register', ['invited' => $invited, 'key' => $invite->first()->key, 'districts' => District::all()]);
			} else {
				return redirect($this->redirectTo)->with('status', 'Такого инвайта не найдено');
			}
		} else {
			return redirect($this->redirectTo);
		}
    }

//  Раскомментировать для запрета входа для неподтвержденных пользователей
//    public function register(Request $request)
//    {
//        $this->validator($request->all())->validate();
//
//		$this->create($request->all());
//
//        return redirect('/login')->with('status', 'Ваш профиль был успешно зарегистрирован и будет доступен для входа после активации');
//    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, ProfileRules::registerRules());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $invite = Invite::where('key', $data['key'])->first();
        $create = array(
            'firstname' => $data['firstname'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'district' => $data['district'],
            'phone' => $data['phone']
        );
        if ($invite->user_id == 1)
            $create = array_add($create, 'confirmed', 1);

		$user = User::create($create);
        $invite->update(['used_by' => $user->id]);
		$fotoName = $user->id .'-'. time().'.'.$data['foto']->getClientOriginalExtension();
        $data['foto']->move(public_path('images/uploads/user'), $fotoName);
        $user->images()->create([
            'file' => $fotoName,
        ]);
		return $user;
    }
}
