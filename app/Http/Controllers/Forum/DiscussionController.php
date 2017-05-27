<?php

namespace App\Http\Controllers\Forum;

use App\Helpers\ForumHelper;
use App\Helpers\Notify;

use App\Http\Controllers\Validation\ForumRules;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Post;
use App\Models\Catalog;
use App\Models\ForumDiscussion;
use App\Models\ForumPost;
use Auth;
use Carbon\Carbon;
use Validator;

class DiscussionController extends Controller
{

    public function index(Request $request)
    {
        if($request->total) $total = $request->total;
        else $total = 10;
        if($request->offset) $offset = $request->offset;
        else $offset = 0;
        $discussions = ForumDiscussion::with(['user', 'post', 'postsCount', 'category'])
                                        ->orderBy('created_at', 'ASC')
                                        ->take($total)
                                        ->offset($offset)
                                        ->get();
        return response()->json($discussions);
    }

    public function create()
    {
        $categories = Category::all();
    	return view('forum.discussion.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->request->add(array('body_content' => strip_tags($request->body)));

        Validator::make($request->all(), ForumRules::createDiscussionRules())->validate();

        $user_id = Auth::user()->id;

        if(true) //limit_time_between_posts
            if($this->notEnoughTimeBetweenDiscussion())
                return Notify::create('От вас поступает слишком много сообщений в минуту. Активирована защита от спама.', 'danger', redirect('/forum'));

        $slug = ForumHelper::checkSlug($request->title);

        $category = Category::find($request->category_id);
        $discussion = ForumDiscussion::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'user_id' => $user_id,
            'slug' => $slug
        ]);

        $discussion->posts()->create([
            'user_id' => $user_id,
            'body' => $request->body
        ]);
        return Notify::create('Ваше обсуждение было успешно создано.', 'success', redirect('/forum/discuss/' . str_slug($category->name, "-") . '/' . $slug));

    }

    private function notEnoughTimeBetweenDiscussion(){
        $user = Auth::user();

        $past = Carbon::now()->subMinutes(0.3);

        $last_discussion = ForumDiscussion::where('user_id', '=', $user->id)->where('created_at', '>=', $past)->first();

        if(isset($last_discussion)){
            return true;
        }

        return false;
    }

    public function show($category, $slug = null)
    {
        if(!isset($category) || !isset($slug)) return redirect( '/forum' );

        $discussion = ForumDiscussion::where('slug', '=', $slug)->first();
        if($category != str_slug($discussion->category->name, "-"))
            return redirect( '/forum/discuss/' . str_slug($discussion->category->name, "-") . '/' . $discussion->slug );

        if($discussion->evaluation && Auth::user()->specs_level($discussion->category->id)['level'] < $discussion->evaluation)
            return Notify::create('У Вас слишком низкий рейтинг специалиста в категории "'.$discussion->category->name.'" для оценки этого товара.', 'danger', redirect( '/forum' ));

        $posts = ForumPost::with('user')->where('discussion_id', '=', $discussion->id)->orderBy('created_at', 'ASC')->paginate(10);
        return view('forum.discussion', compact('discussion', 'posts'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function confirm(Request $request, $id)
    {
        $discussion = ForumDiscussion::findOrFail($id);
        $permission = Auth::user()->specs_level($discussion->category_id);
        if($permission['level'] <= $discussion->evaluation || $permission['select'] == "")
            return Notify::create('Вы не имеете право подтверждать оценки специалистов в данной категории', 'danger', back());
        if($discussion->evaluation == 0 || $discussion->evaluation_item == 0)
            return Notify::create('Это обсуждение не является оценочным', 'danger', back());
        $data = $request->all();
        $posts = ForumPost::whereIn('id', $data['posts'])->get();
        Validator::make($data, ForumRules::confirmRules())->validate();

        $price = ForumHelper::evaluationPrice($discussion->evaluation);
        $piece = floor($price / count($posts));

        $evaluation = ForumHelper::evaluationFinish($posts,$piece);

        ForumHelper::setAnswered($discussion, true);
        $discussion->item()->update(['evaluation' => $evaluation[0]."-".$evaluation[1]]);

        return Notify::create('Вы успешно подтвердили оценки экспертов. Обсуждение закрыто.', 'success', redirect('/forum/discuss/' . str_slug($discussion->category->name, "-") . '/' . $discussion->slug));
    }

    public function close($id)
    {
        $discussion = ForumDiscussion::findOrFail($id);
        if (!$discussion->answered && Auth::user()->id == $discussion->user_id && !$discussion->evaluation) {
            ForumHelper::setAnswered($discussion, true);
            return Notify::create('Вы успешно закрыли данное обсуждение. Надеемся наши эксперты смогли вам помочь!', 'success', redirect('/forum/discuss/' . str_slug($discussion->category->name, "-") . '/' . $discussion->slug));
        }
        return Notify::create('Вы не имеете право закрывать данное обсуждение, так как не являетесь его автором.', 'danger', redirect('/forum/discuss/' . str_slug($discussion->category->name, "-") . '/' . $discussion->slug));
    }

    /*private function sanitizeContent($content){
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();

        $doc->loadHTML($content);

        $this->removeElementsByTagName('script', $doc);
        $this->removeElementsByTagName('style', $doc);
        $this->removeElementsByTagName('link', $doc);

        return $doc->saveHtml();
    }

    private function removeElementsByTagName($tagName, $document) {
      $nodeList = $document->getElementsByTagName($tagName);
      for ($nodeIdx = $nodeList->length; --$nodeIdx >= 0; ) {
        $node = $nodeList->item($nodeIdx);
        $node->parentNode->removeChild($node);
      }
    }*/

}
