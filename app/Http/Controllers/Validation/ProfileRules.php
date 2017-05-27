<?php

namespace App\Http\Controllers\Validation;


class ProfileRules
{
    public static function updatePasswordRules() {
        return [
            'password' => 'required|min:5|confirmed'
        ];
    }

    public static function formRules() {
        return [
            'phone' => 'required|regex:/\++(\d\(?\)?-?){6,11}/',
            'spec' => 'array',
            'spec.*' => 'numeric|min:1',
            'birthday' => 'date_format:d / m / Y',
            'district' => 'required|numeric|min:1',
            'about' => 'max:500',
            'foto' => 'image|max:3072',
        ];
    }

    public static function formEmailRules() {
        return 'required|email|max:255|unique:users';
    }

    public static function transferRules() {
        return [
            'destination' => 'required|numeric|min:1',
            'sum' => 'required|numeric|min:1',
        ];
    }

    public static function requestRules() {
        return [
            'sum' => 'required|numeric|min:1'
        ];
    }

    public static function reportRules() {
        return [
            'message' => 'required|min:5'
        ];
    }

    public static function registerRules() {
        return [
            'key' => 'required|max:30',
            'firstname' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:5|confirmed',
            'district' => 'required|numeric|min:1',
            'phone' => 'required|regex:/\++(\d\s?\(?\)?\s?-?){6,11}/',
            'foto' => 'required|image|max:3072',
        ];
    }
}