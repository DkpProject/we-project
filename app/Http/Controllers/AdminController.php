<?php

namespace App\Http\Controllers;

use App\Helpers\Balance;
use App\Helpers\DataProvider;
use App\Helpers\Notify;
use App\Models\Category;
use App\Models\User;
use App\Models\Wish;
use App\Notifications\Slack\WishesFromUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AdminController extends Controller
{
    public function specialties()
    {
        if (Auth::user()->id == 2 || Auth::user()->id == 5) {
            return view('specialties', ['cats' => Category::ordered()]);
        }
        abort(404);
    }

    public function specialtiesCreate(Request $request)
    {
        if (Auth::user()->id == 2 || Auth::user()->id == 5) {
            Validator::make($request->all(), [
                'parent' => 'required|numeric|min:0',
                'name' => 'required|min:3',
            ])->validate();
            Category::create([
                'parent_id' => $request->input('parent'),
                'name' => $request->input('name'),
            ]);
            return Notify::create('Категория успешно добавлена', 'success', back());
        }
        abort(404);
    }

    public function specialtiesDelete(Category $cat)
    {
        if (Auth::user()->id == 2 || Auth::user()->id == 5) {
            if (!$cat->parent_id)
                $cat->childs()->delete();
            $cat->delete();
            return Notify::create('Категория успешно удалена', 'success', back());
        }
        abort(404);
    }

    public function makeWish(Request $request)
    {
        Validator::make($request->all(), [
            'wishes' => 'required|min:5',
        ])->validate();
        $user = Auth::user();
        $user->wishes()->create([
            'text' => $request->input('wishes')
        ]);
        $user->notify(new WishesFromUser($request->input('wishes')));
        return Notify::create('Спасибо за ваше сообщение. Ваши пожелания будут учтены!', 'success', back());
    }

    public function deleteWish(Wish $wish)
    {
        if($wish->user_id == Auth::id())
            $wish->update(['active' => false]);

        return Notify::create('Ваше желание было успешно удалено!', 'success', back());
    }

    public function balance()
    {
        if (\Auth::user()->id == 1 || \Auth::user()->isAdmin())
            return view('balance', ['users' => User::all()]);
        abort(404);
    }

    public function updateBalance(Request $request, DataProvider $storage)
    {
        if (Auth::user()->id == 1 || Auth::user()->isAdmin()) {
            Validator::make($request->all(), [
                'newbalance' => 'required|integer|min:0',
                'user' => 'required|integer|min:1',
            ])->validate();
            $user = User::findOrFail($request->input('user'));
            Balance::updateBalance($user, $request->input('newbalance'));
            return Notify::create('Баланс пользователя успешно обновлен!', 'success', back());
        }
        return redirect('/');
    }
}
