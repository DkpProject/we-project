<?php

namespace App\Http\Controllers\Validation;


class ForumRules
{
    public static function createDiscussionRules() {
        return [
            'title' => 'required|min:5|max:255',
            'body_content' => 'required|min:10',
            'category_id' => 'required',
        ];
    }

    public static function confirmRules() {
        return [
            "posts" => "required|array|min:1",
            "posts.*" => "numeric",
        ];
    }

    public static function createPostRules() {
        return [
            'body_notags' => 'required|min:10'
        ];
    }

    public static function createPostPriceRules() {
        return 'numeric';
    }

    public static function updatePostRules() {
        return [
            'body_notags' => 'required|min:10'
        ];
    }

    public static function updatePostPriceRules() {
        return 'required|numeric';
    }
}