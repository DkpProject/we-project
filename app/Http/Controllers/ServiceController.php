<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\ServiceCats;
use App\Models\Service;
use App\Models\Image;

use Carbon\Carbon;
use Gate;
use Validator;

class ServiceController extends Controller
{

    /*
     * Отображение списка всех услуг
     */
    public function index()
    {
        return view('service.index', ['service' => Service::where('visible', true)->where('disabled', false)->paginate(config('project.pagination.service'))]);
    }

    /*
     * Отображение списка услуг категории
     */
    public function category($id)
    {
        return view('service.index', ['service' => Service::where('cat_id', $id)->where('visible', true)->where('disabled', false)->paginate(config('project.pagination.service'))]);
    }

    /*
     * Отображение страницы услуги
     */
    public function service($id)
    {
        $service = Service::findOrFail($id);
        if (Gate::allows('access', $service))
            if (Gate::denies('show', $service))
                abort(404);
        $service->views++;
        $service->save();

        return view('service.service', ['service' => $service]);
    }

    /*
     * Отображение формы редактирования услуги
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);

        if (Gate::denies('update', $service))
            return redirect('/service/'.$id);

        return view('service.edit', ['service' => $service, 'cats' => ServiceCats::all()]);
    }

    /*
     * Обновление данных об услуге
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $data = $request->all();

        if (Gate::denies('update', $service))
            return redirect('/service/'.$id);

        Validator::make($data, [
            'cat_id' => 'required|integer|min:1',
            'name' => 'required|max:255',
            'descr' => 'required',
            'visible' => 'boolean',
            'cost' => 'required|numeric|min:1',
            'unphoto' => 'array|max:5',
            'photo' => 'array|max:5',
            'photo.*' => 'image|max:2048',
        ])->validate();

        if (!isset($data['used']))
            $data['used'] = 0;

        if (!isset($data['visible']))
            $data['visible'] = 0;

        $service->update([
            'cat_id' => $data['cat_id'],
            'name' => $data['name'],
            'descr' => $data['descr'],
            'cost' => round($data['cost'], 2),
            'visible' => $data['visible'],
        ]);

        if (isset($data['unphoto'])) {
            foreach ($data['unphoto'] as $key => $photo) {
                $photo = Image::find($photo);
                if ($photo->item_id == $id && $photo->module == 'Service') {
                    unlink(public_path() . '/images/uploads/' . strtolower($photo->module) . '/' . $photo->file);
                    $photo->delete();
                }
            }
        }
        if (isset($data['photo']) && $service->images->count() < 5) {
            foreach ($data['photo'] as $key => $photo) {
                $fotoName = $service->id . '-' . $key . '-' . time() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('images/uploads/service'), $fotoName);
                Image::create([
                    'item_id' => $service->id,
                    'module' => 'Service',
                    'file' => $fotoName,
                ]);
            }
        }
        return redirect('/service/'.$id)->with('type', 'success')->with('status', 'Изменения успешно сохранены');
    }

    /*
     * Отображение страницы удаления услуги
     */
    public function delete($id)
    {
        $service = Service::findOrFail($id);
        if (Gate::denies('delete', $service))
            return redirect()->back();

        return view('service.delete', ['id' => $id]);
    }

    /*
     * Удаление услуги из базы данных
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        if (Gate::denies('delete', $service))
            return redirect()->back();

        foreach($service->images as $image) {
            unlink(public_path('images/uploads/service/'.$image->file));
        }
        $service->images()->delete();
        $service->delete();
        return redirect('/service');
    }

    /*
     * Отображение формы для добавления услуги
     */
    public function add()
    {
        if (!policy(Service::class)->create(\Auth::user()))
            return redirect()->back();

        return view('service.add', ['cats' => ServiceCats::all()]);
    }

    /*
     * Добавление услуги в базу данных
     */
    public function create(Request $request)
    {
        if (!policy(Service::class)->create(\Auth::user()))
            return redirect()->back();

        $data = $request->all();
        Validator::make($data, [
            'cat_id' => 'required|integer|min:1',
            'name' => 'required|max:255',
            'descr' => 'required',
            'cost' => 'required|numeric|min:1',
            'visible' => 'boolean',
            'photo' => 'array|max:5',
            'photo.*' => 'image|max:2048',
            'photo.0' => 'required|image|max:2048',
        ])->validate();

        if (!isset($data['used']))
            $data['used'] = 0;

        if (!isset($data['visible']))
            $data['visible'] = 0;

        $item = Service::create([
            'user_id' => \Auth::user()->id,
            'cat_id' => $data['cat_id'],
            'name' => $data['name'],
            'descr' => $data['descr'],
            'stop_date' => Carbon::now(),
            'visible' => $data['visible'],
            'cost' => round($data['cost'], 2)
        ]);
        foreach($data['photo'] as $key => $photo) {
            $fotoName = $item->id .'-'.$key.'-'. time().'.'.$photo->getClientOriginalExtension();
            $photo->move(public_path('images/uploads/service'), $fotoName);
            Image::create([
                'item_id' => $item->id,
                'module' => 'Service',
                'file' => $fotoName,
            ]);
        }
        return redirect('/service/'.$item->id);
    }

    /*
     * Обработка поисква по услугам
     */
    public function search($query)
    {
        $name = urldecode($query);
        return view('service.index', ['service' => Service::where('name', 'LIKE', '%'.$name.'%')->where('visible', true)->where('disabled', false)->paginate(config('project.pagination.service'))]);
    }

    /*
     * Показ формы создания сделки
     */
    function makeDeal($id) {
        $item = Service::findOrFail($id);
        if (!policy(Service::class)->deal(\Auth::user(), $item))
            return Notify::create('Создание сделки с этим товаром невозможно', 'danger', back());
        return view('deal.make', ['module' => 'service', 'seller' => $item->user, 'item' => $item, 'purchaser' => \Auth::user()]);
    }

    /*
     * Создание сделки
     */
    function createDeal(Request $request, $id)
    {
        $user = \Auth::user();
        $data = $request->all();
        $item = Service::findOrFail($id);
        if (!policy(Service::class)->deal($user, $item))
            return Notify::create('Вы не можете совершить сделку с вашей услугой', 'danger', back());

        // Проверка на наличие средств на балансе
        if (!Balance::checkBalance($user, $item->cost))
            return Notify::create('На вашем балансе недостаточно средств для выполнения данной операции.', 'danger', back());

        $deal = $item->deal()->create([
            'seller_id' => $item->user->id,
            'purchaser_id' => $user->id,
            'cost' => $item->cost,
            'type' => $item->deal_type
        ]);

        Balance::updateBalance($user, -$item->cost);
        return redirect('./deal/'.$deal->id);
    }
}
