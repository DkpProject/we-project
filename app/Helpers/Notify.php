<?php

namespace App\Helpers;

class Notify
{
    public static function create(string $message, string $type, $route) {
        return $route->with('type', $type)->with('status', $message);
    }

    public static function forbiden($route) {
        return $route->with('type', 'danger')->with('status', 'У Вас нет прав для просмотра этой страницы');
    }

    public static function accessDenied($route) {
        return $route->with('type', 'danger')->with('status', 'Доступ на эту страницу заблокирован');
    }

    public static function actionDenied($route) {
        return $route->with('type', 'danger')->with('status', 'Вы не можете совершать это действие');
    }
}