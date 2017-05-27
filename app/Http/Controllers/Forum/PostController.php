<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Validation\ForumRules;
use App\Models\ForumDiscussion;
use App\Models\ForumPost;
use App\Models\Category;

use App\Helpers\ForumHelper;
use App\Helpers\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Validator;

class PostController extends Controller
{

    public function index(Request $request)
    {
        if($request->total) $total = $request->total;
        else $total = 10;
        if($request->offset) $offset = $request->offset;
        else $offset = 0;
        $posts = ForumPost::with('user')->orderBy('created_at', 'DESC')->take($total)->offset($offset)->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $discussion = ForumDiscussion::find($request->discussion_id);

        if ($discussion->evaluation) {
            if ($discussion->posts->where('user_id', Auth::user()->id)->count())
                return Notify::create('Ваша оценка не будет опубликована, так как вы уже оценили этот товар.', 'danger', back());

            if ($discussion->posts->count() == 4)
                return Notify::create('Ваша оценка не будет опубликована, так как достигнул лимит оценок на один товар.', 'danger', back());
        }

        if($discussion->user_id == Auth::user()->id && $discussion->evaluation)
            return Notify::create('Ваше сообщение не будет опубликовано, так как вы не можете оценивать свой товар.', 'danger', redirect('/forum/discuss/' . str_slug($discussion->category->name, "-") . '/'  . $discussion->slug));

        if($discussion->answered)
            return Notify::create('Ваше сообщение не будет опубликовано, так как обсуждение закрыто.', 'danger', redirect('/forum/discuss/' . str_slug($discussion->category->name, "-") . '/'  . $discussion->slug));

        if(Auth::user()->specs_level($discussion->category->id)['level'] < $discussion->evaluation)
            return Notify::create('У Вас слишком низкий рейтинг специалиста в категории "'.$discussion->category->name.'" для оценки этого товара.', 'danger', redirect( '/forum' ));

        $request->request->add(array('body_notags' => strip_tags($request->body)));

        $valid = ForumRules::createPostRules();
        if ($discussion->evaluation)
            $valid = array_add($valid, 'price', ForumRules::createPostPriceRules());

        Validator::make($request->all(), $valid)->validate();

        if(true)
            if($this->notEnoughTimeBetweenPosts())
                return Notify::create('От вас поступает слишком много сообщений в минуту. Включена защита от спама', 'danger', back());

        if (!is_numeric($request->price))
            $request->price = 0;

        $request->request->add(['user_id' => Auth::user()->id, 'price' => $request->price]);
        $new_post = $discussion->posts()->create($request->all());

        if($new_post->id)
            return Notify::create('Ваше сообщение было успешно размещено в обсуждении', 'success', redirect('/forum/discuss/' . str_slug($discussion->category->name, "-") . '/'  . $discussion->slug));
    }

    public function update(Request $request, $id)
    {
        $post = ForumPost::find($id);

        if($post->discussion->answered)
            return Notify::create('Ваше сообщение не будет отредактировано, так как обсуждение закрыто.', 'danger', redirect('/forum/discuss/' . str_slug($post->discussion->name, "-") . '/'  . $post->discussion->slug));

        $request->request->add(array('body_notags' => strip_tags($request->body)));

        $valid = ForumRules::updatePostRules();
        if ($post->discussion->evaluation)
            $valid = array_add($valid, 'price', ForumRules::updatePostPriceRules());

        Validator::make($request->all(), $valid)->validate();

        if(!Auth::guest() && (Auth::user()->id == $post->user_id)){
            $post->body = $request->body;
            $post->price = $request->price;
            $post->save();

            return Notify::create('Сообщение было успешно обновлено', 'success', redirect('/forum/discuss/' . str_slug($post->discussion->category->name, "-") . '/' . $post->discussion->slug));

        } else
            return Notify::create('Это сообщение не может быть обновлено', 'danger', redirect('/forum/discuss/' . str_slug($post->discussion->category->name, "-") . '/' . $post->discussion->slug));
    }

    private function notEnoughTimeBetweenPosts(){
        $user = Auth::user();
        $past = Carbon::now()->subMinutes(0.3);
        $last_post = ForumPost::where('user_id', '=', $user->id)->where('created_at', '>=', $past)->first();

        if(isset($last_post)) return true;
        return false;
    }

    public function destroy($id)
    {
        $post = ForumPost::find($id);

        if($post->discussion->answered)
            return Notify::create('Ваше сообщение не может быть удалено, так как обсуждение закрыто.', 'danger', redirect('/forum/discuss/' . str_slug($post->discussion->category->name, "-") . '/'  . $post->discussion->slug));

        if(!Auth::guest() && (Auth::user()->id == $post->user_id) && $post->discussion->posts->sortBy('created_at')->first()->id != $id){
            $post->delete();

            $count_post = ForumPost::where('discussion_id',$post->discussion_id)->count();

            if($count_post <= 0) {
                $post->discussion()->delete();
                return Notify::create('Ваше сообщение и обсуждение были успешно удалены', 'success', redirect('/forum' ));
            } else
                return Notify::create('Ваше сообщение было успешно удалено из обсуждения', 'success', redirect('/forum/discuss/' . str_slug($post->discussion->category->name, "-") . '/' . $post->discussion->slug));

        } else
            return Notify::create('Это сообщение не может быть удалено из обсуждения', 'danger', redirect('/forum/discuss/' . str_slug($post->discussion->category->name, "-") . '/' . $post->discussion->slug));
    }

    public function thanks($id)
    {
        $post = ForumPost::findOrFail($id);
        if (!$post->thanks && $post->user->id != Auth::user()->id && $post->discussion->user_id == Auth::user()->id && !$post->discussion->evaluation) {
            ForumHelper::setThanks($post, true);
            return Notify::create('Вы успешно поблагодарили человека.', 'success', back());
        }
        return Notify::create('Вы не пожете поблагодарить этого автора за сообщение.', 'danger', back());
    }
}
