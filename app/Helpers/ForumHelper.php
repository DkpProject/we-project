<?php
namespace App\Helpers;

use App\Models\ForumDiscussion;

class ForumHelper {
	
	public static function stringToColorCode($str) {
		$code = dechex(crc32($str));
		$code = substr($code, 0, 6);
		return $code;
	}

	public static function getUserLink($user){
		$relative_url = '/profile/{id}';
		if($relative_url){
			$beginning_del = strpos($relative_url, '{');
			$end_del = strpos($relative_url, '}');
			
			$field = substr($relative_url, $beginning_del, ($end_del+1) - $beginning_del);
			$url_without_field = str_replace($field, '', $relative_url);
			
			$field = str_replace('{', '', str_replace('}', '', $field));
			$field_value = $user->{$field};

			return $url_without_field . $field_value;
		} else {
			return '/#_';
		}
	}

	public static function checkSlug($name) {
        $slug = str_slug($name, '-');

        $discussion_exists = ForumDiscussion::where('slug', '=', $slug)->first();
        $incrementer = 1;
        $new_slug = $slug;
        while(isset($discussion_exists->id)){
            $new_slug = $slug . '-' . $incrementer;
            $discussion_exists = ForumDiscussion::where('slug', '=', $new_slug)->first();
            $incrementer += 1;
        }
        if($slug != $new_slug) $slug = $new_slug;

        return $slug;
    }

    public static function evaluationPrice($level) {
        switch($level) {
            case "1":
                $price = 50;
                break;
            case "2":
                $price = 100;
                break;
            case "3":
                $price = 150;
                break;
            case "4":
                $price = 200;
                break;
            case "5":
                $price = 250;
                break;
            default:
                $price = 0;
                break;
        }
        return $price;
    }

    public static function evaluationFinish($posts, $piece) {
	    $max = 0;
	    $min = 0;
        foreach ($posts as $key => $post) {
            Balance::updateBalance($post->user, $piece);
            $max = max($max, $post->price);
            if(!$key) $min = $post->price;
            else $min = min($min, $post->price);
        }
        return array($min, $max);
    }

    public static function setAnswered($discussion, $state) {
        return $discussion->update(['answered' => $state]);
    }

    public static function setThanks($post, $state) {
        return $post->update(['thanks' => $state]);
    }

}