<?php

namespace App\Http\Controllers\Forum;

use App\Models\ForumDiscussion;
use App\Models\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class MainController extends Controller
{
    public function index($slug = ''){

        $pagination_results = config('project.pagination.forum');
    	if($slug != ''){
    		foreach(Category::all() as $category) {
                if(str_slug($category->name, "-") == $slug){
                    $discussions = ForumDiscussion::with(['user', 'post', 'postsCount', 'category'])
                        ->where(function ($query) use($category) {
                            $query->where('category_id', $category->id)
                                ->where('user_id', '!=', Auth::user()->id)
                                ->where('evaluation', '<=', Auth::user()->specs_level($category->id)['level'])
                                ->where('answered', 0);
                        })
                        ->orWhere(function($query) use($category) {
                            $query
                                ->where('category_id', $category->id)
                                ->where('user_id', \Auth::user()->id)
                                ->where('evaluation', 0);
                        })
                        ->orderBy('sticky', 'DESC')
                        ->orderBy('created_at', 'DESC')
                        ->paginate($pagination_results);
                }
            }
    	} else {
            $discussions = ForumDiscussion::with(['user', 'post', 'postsCount', 'category']);
            foreach(Auth::user()->specs_list as $category) {
                $discussions = $discussions->orWhere(function ($query) use($category) {
                    $query = $query->where('category_id', $category->spec_id)
                        ->where('user_id', '!=', $category->user_id)
                        ->where('evaluation', '<=', Auth::user()->specs_level($category->spec_id)['level'])
                        ->where('answered', 0);
                });
            }

            $discussions = $discussions
                ->orWhere(function($query) {
                    $query->where('user_id', \Auth::user()->id)
                        ->where('evaluation', 0);
                })
                ->orderBy('sticky', 'DESC')
                ->orderBy('created_at', 'DESC')
                ->paginate($pagination_results);
        }
    	$categories = Category::all();
    	return view('forum.home', compact('discussions', 'categories'));
    }
}
