<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Validation\CatalogRules;
use App\Models\Deal;
use App\Models\DeliveryAddress;
use App\Models\ForumDiscussion;
use App\Models\ForumPost;
use App\Models\CatalogCats;
use App\Models\Catalog;
use App\Models\Image;

use App\Helpers\Balance;
use App\Helpers\ForumHelper;
use App\Helpers\Notify;
use App\Helpers\DataProvider;

use App\Notifications\Slack\ReportFromUserNotification;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class CatalogController extends Controller
{

    public function index()
    {
        return view('catalog.index', ['catalog' => Catalog::where(['visible' => true, 'disabled' => false])
                                                            ->paginate(config('project.pagination.catalog'))]);
    }

    public function category($id)
    {
        return view('catalog.index', ['catalog' => Catalog::where(['cat_id' => $id, 'visible' => true, 'disabled' => false])
                                                            ->paginate(config('project.pagination.catalog'))]);
    }

    public function good(Catalog $good)
    {
        if (Gate::allows('access', $good))
            if (Gate::denies('show', $good))
                abort(404);
        $good->views++;
        $good->save();

        return view('catalog.good', ['good' => $good]);
    }

    public function edit(Catalog $good)
    {
        if (Gate::denies('update', $good))
            return redirect('/catalog/'.$good->id);

        return view('catalog.edit', ['good' => $good, 'cats' => CatalogCats::ordered()->get()]);
    }

    public function update(Request $request, Catalog $good)
    {
        $data = $request->all();

        if (Gate::denies('update', $good))
            return redirect('/catalog/'.$good->id);

        if($good->deal()->where('state', 'inprogress')->count() && $data['deal_type'] != $good->deal_type)
            return Notify::create('Вы не можете изменять тип сделки товара, если с ним имеются незавершенные сделки', 'danger', back());

        Validator::make($data, CatalogRules::updateRules())->validate();

        if (!isset($data['used'])) $data['used'] = 0;
        if (!isset($data['visible'])) $data['visible'] = 0;

        if ($good->deal_type != $data['deal_type'] && ($data['deal_type'] == "service" || $data['deal_type'] == "store" || $data['deal_type'] == "selling")) {
            $good->deal()->where('state', 'initial')->delete();
            $good->update(['disabled' => true]);
            $good->deal()->create([
                'seller_id' => $good->user->id,
                'purchaser_id' => 1,
                'cost' => 0,
                'type' => $data['deal_type'],
                'status' => 0,
                'state' => 'initial',
            ]);
        }

        $good->update([
            'cat_id' => $data['cat_id'],
            'name' => $data['name'],
            'descr' => $data['descr'],
            'cost' => round($data['cost'], 2),
            'used' => $data['used'],
            'visible' => $data['visible'],
            'deal_type' => $data['deal_type'],
            'limitations' => $data['limitations'],
            'flaw' => $data['flaw'],
        ]);

        if (isset($data['unphoto'])) {
            foreach ($data['unphoto'] as $key => $photo) {
                $photo = $good->images()->find($photo);
                unlink(public_path() . '/images/uploads/catalog/' . $photo->file);
                $photo->delete();
            }
        }

        if (isset($data['photo']) && $good->images->count() < 5) {
            foreach ($data['photo'] as $key => $photo) {
                $fotoName = $good->id . '-' . $key . '-' . time() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('images/uploads/catalog'), $fotoName);
                $good->images()->create([
                    'file' => $fotoName,
                ]);
            }
        }
        return Notify::create('Изменения успешно сохранены', 'success', redirect('/catalog/'.$good->id));
    }

    public function delete(Catalog $good)
    {
        if (Gate::denies('delete', $good))
            return redirect()->back();

        return view('catalog.delete', ['id' => $good->id]);
    }

    public function destroy(Catalog $good)
    {
        if (Gate::denies('delete', $good))
            return redirect()->back();

        if($good->deal()->where('state', 'inprogress')->count())
            return Notify::create('Вы не можете удалить товар, если с ним имеются незавершенные сделки', 'danger', back());

        foreach($good->images as $image)
            unlink(public_path('images/uploads/catalog/'.$image->file));

        $good->images()->delete();
        $good->deal()->delete();
        if($good->discussion()->count()) {
            $good->discussion->posts()->delete();
            $good->discussion()->delete();
        }
        $good->delete();
        return Notify::create('Товар был успешно удален!', 'success', redirect('/catalog'));
    }

    public function add()
    {
        if (!policy(Catalog::class)->create(\Auth::user()))
            return Notify::create('Для добавления товара ваш профиль должен быть активирован!', 'danger', back());

        return view('catalog.add', ['cats' => CatalogCats::ordered()->get()]);
    }

    public function create(Request $request, DataProvider $storage)
    {
        if (!policy(Catalog::class)->create(\Auth::user()))
            return redirect()->back();

		$data = $request->all();
		Validator::make($data, CatalogRules::createRules())->validate();

		$price = ForumHelper::evaluationPrice($data['evaluation']);

		if(!Balance::checkBalance(\Auth::user(), $price))
            return Notify::create('На вашем балансе не хватает средств для оплаты оценки специалистом. Пополните баланс или выберите более дешевый уровень оценки.', 'danger', back());
		
		if (!isset($data['used'])) $data['used'] = 0;
		if (!isset($data['visible'])) $data['visible'] = 0;
		
		$item = Catalog::create([
            'user_id' => \Auth::user()->id,
            'cat_id' => $data['cat_id'],
            'name' => $data['name'],
            'descr' => $data['descr'],
            'stop_date' => Carbon::now(),
            'used' => $data['used'],
            'visible' => $data['visible'],
            'disabled' => false,
            'deal_type' => $data['deal_type'],
            'limitations' => $data['limitations'],
            'flaw' => $data['flaw'],
            'cost' => round($data['cost'], 2),
            'evaluation' => 1
        ]);

        foreach($data['photo'] as $key => $photo) {
            $fotoName = $item->id .'-'.$key.'-'. time().'.'.$photo->getClientOriginalExtension();
            $photo->move(public_path('images/uploads/catalog'), $fotoName);
            $item->images()->create([
                'file' => $fotoName
            ]);
        }

		if ($item->deal_type == "service" || $item->deal_type == "store" || $item->deal_type == "selling" || $item->deal_type == "rent") {
            $data['datetime'] = Carbon::createFromFormat('d / m / Y H:i', $data['datetime'])->toDateTimeString();
            $item->update(['disabled' => true]);
            $deal = $item->deal()->create([
                'seller_id' => $item->user->id,
                'purchaser_id' => 1,
                'cost' => 0,
                'type' => $item->deal_type,
                'status' => 0,
                'state' => 'initial',
            ]);
            $deal->addresses()->create([
                'address' => $data['address'],
                'datetime' => $data['datetime'],
            ]);
        }

		if ($data['evaluation'] && ($item->deal_type == "buy" || $item->deal_type == "rent")) {
		    $slug = ForumHelper::checkSlug($data['name']);
            $storage->setBalanceLogItem($item);
            $storage->setBalanceLogMessage('evaluationCatalog');
            Balance::updateBalance(\Auth::user(), -$price);

            $discuss = ForumDiscussion::create([
                'title' => $data['name'],
                'category_id' => $data['cat_id'],
                'user_id' => \Auth::user()->id,
                'slug' => $slug,
                'sticky' => 1,
                'evaluation' => $data['evaluation'],
                'evaluation_item' => $item->id,
            ]);

            $post_body = view('forum.evaluationPost', ['data' => $data])->render();
            $discuss->posts()->create([
                'category_id' => $data['cat_id'],
                'user_id' => \Auth::user()->id,
                'body' => $post_body,
                'first' => 1,
                'price' => 0,
            ]);
        }

		return redirect('/catalog/'.$item->id);
    }

    public function search($query)
    {
        $name = urldecode($query);
        return view('catalog.index', ['catalog' => Catalog::where('name', 'LIKE', '%'.$name.'%')
                                                            ->where(['visible' => true, 'disabled' => false])
                                                            ->paginate(config('project.pagination.catalog'))]);
    }

    function makeDeal(Catalog $good) {
        $dealExists = \Auth::user()->activeDeals()->where('item_id', $good->id)->where('item_type', 'App\Models\Catalog');
        if (count($dealExists->get()))
            return redirect('/deal/'.$dealExists->first()->id);
        if (!policy(Catalog::class)->deal(\Auth::user(), $good))
            return Notify::create('Создание сделки с этим товаром невозможно', 'danger', back());
        return view('deal.make', ['module' => 'catalog', 'seller' => $good->user, 'item' => $good, 'purchaser' => \Auth::user()]);
    }

    function createDeal(Request $request, Catalog $good, DataProvider $storage)
    {
        $user = \Auth::user();
        $data = $request->all();
        $dealExists = \Auth::user()->activeDeals()->where('item_id', $good->id)->where('item_type', 'App\Models\Catalog');
        if (count($dealExists->get()))
            return redirect('/deal/'.$dealExists->first()->id);
        if (!policy(Catalog::class)->deal($user, $good))
            return Notify::create('Вы не можете совершить сделку с вашим товаром', 'danger', back());


        if ($good->deal_type == "rent") {
            if (!Balance::checkBalance($user, $good->cost*$data['days']))
                return Notify::create('На вашем балансе недостаточно средств для выполнения данной операции.', 'danger', back());
            $cost = $good->cost * $data['days'];
            Validator::make($data, CatalogRules::createDealRules())->validate();
        } else {
            if (!Balance::checkBalance($user, $good->cost))
                return Notify::create('На вашем балансе недостаточно средств для выполнения данной операции.', 'danger', back());
            $cost = $good->cost;
        }

        $deal = $good->deal()->create([
            'seller_id' => $good->user->id,
            'purchaser_id' => $user->id,
            'cost' => $cost,
            'type' => $good->deal_type
        ]);

        if ($good->deal_type == "rent") {
            $data['datetime'] = Carbon::createFromFormat('d / m / Y H:i', $data['datetime'])->toDateTimeString();
            $address = $deal->addresses()->create([
                'address' => $data['address'],
                'datetime' => $data['datetime']
            ]);
        }

        $storage->setBalanceLogItem($deal);
        $storage->setBalanceLogMessage('createDeal');
        Balance::updateBalance($user, -$cost);
        return redirect('./deal/'.$deal->id);
    }

    function report(Catalog $good, Request $request) {
        $auth = Auth::user();
        if ($good->user->id == $auth->id)
            Notify::create('Вы не можете отправить жалобу на этот товар!', 'danger', back());

        Validator::make($request->all(), CatalogRules::reportRules())->validate();

        $auth->notify(new ReportFromUserNotification($good, $request->input('message')));
        return Notify::create('Ваша жалоба была успешно зарегистрирована.', 'success', back());
    }
}
