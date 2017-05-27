<?php

namespace App\Http\Controllers\Validation;


class CatalogRules
{
    public static function updateRules() {
        return [
            'cat_id' => 'required|integer|min:1',
            'name' => 'required|max:255',
            'descr' => 'required',
            'cost' => 'required_if:deal_type,buy,rent|numeric|min:1',
            'used' => 'boolean',
            'visible' => 'boolean',
            'limitations' => 'required|integer|min:0|max:1',
            'flaw' => 'max:5000',
            'deal_type' => array('required', 'regex:/buy|rent|service|store|selling/'),
            'unphoto' => 'array|max:5',
            'photo' => 'array|max:1',
            'photo.*' => 'image|max:3072',
        ];
    }

    public static function createRules() {
        return [
            'cat_id' => 'required|integer|min:1',
            'name' => 'required|max:255',
            'descr' => 'required',
            'cost' => 'required_if:deal_type,buy,rent|numeric|min:1',
            'evaluation' => 'required|numeric|min:0|max:5',
            'used' => 'boolean',
            'visible' => 'boolean',
            'limitations' => 'required|integer|min:0|max:1',
            'flaw' => 'max:5000',
            'deal_type' => array('required', 'regex:/buy|rent|service|store|selling/'),
            'photo' => 'array|max:5',
            'photo.*' => 'image|max:3072',
            'photo.0' => 'required|image|max:3072',
            'address' => 'required_if:deal_type,rent,service,store,selling|min:5',
            'datetime' => 'required_if:deal_type,rent,service,store,selling|date_format:"d / m / Y H:i"',
        ];
    }

    public static function createDealRules() {
        return [
            'address' => 'required|min:5',
            'datetime' => 'required|date_format:"d / m / Y H:i"',
            'days' => 'required|numeric|min:1',
        ];
    }

    public static function reportRules() {
        return [
            'message' => 'required|min:5'
        ];
    }
}