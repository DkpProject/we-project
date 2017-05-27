<?php

namespace App\Helpers;

use App\Models\BalanceLog;
use App\Models\Catalog;
use App\Models\Deal;
use App\Models\User;
use DataStorage;
use Illuminate\Support\Collection;

class Balance
{
    public static function setBalance($user, $value) {
        $value = round($value, 2);
        if ($value < 0) return false;
        $user->balance = $value;
        $user->save();
        return $user->balance;
    }

    public static function updateBalance($user, $value, $balance = false) {
        $value = round($value, 2);
        if ($value < 0 && !self::checkBalance($user, $value)) return false;
        $user->balance += $value;
        $user->save();
        self::setBalanceLog($user, $value);
        if ($balance) return $user->balance;
        else return true;
    }

    public static function moveBalance($from, $to, $value) {
        if ($value <= 0) return false;
        if (self::updateBalance($from, -$value) && self::updateBalance($to, $value)) return true;
        else return false;
    }

    public static function checkBalance($user, $value) {
        if ($value < 0) $value = abs($value);
        return $user->balance >= $value;
    }

    public static function setBalanceLog(User $user, $value) {
        $receive_item = DataStorage::getBalanceLogItem();
        if ($receive_item instanceof Collection) {
            if ($receive_item->all()[0] == $user) $item = $receive_item->all()[1];
            else $item = $receive_item->all()[0];

            if ($value < 0) $action = DataStorage::getBalanceLogMessage().":to";
            else $action = DataStorage::getBalanceLogMessage().":from";
        } else {
            $item = $receive_item;
            $action = DataStorage::getBalanceLogMessage();
        }
        if (is_null($item))
            $item['id'] = 0;
        if(is_null($action))
            $action = "";
        $user->balanceLog()->create([
            'item_id' => $item['id'],
            'value' => $value,
            'action' => $action
        ]);
    }

    public static function getBalanceLog(BalanceLog $log) {
        $message = self::balanceLogAction($log->action, $log->item_id);
        if ($log->value < 0) $phrase = 'С вашего счета списано ';
        else $phrase = 'На ваш лицевой счет зачислено ';
        if ($message != "") $inc_message = ' ( '. $message . ' )';
        else $inc_message = "";
        $abs_value = abs($log->value);
        $money_big = intval($abs_value);
        $money_little = intval($abs_value * 100 % 100);
        if($money_little) $cents = ' '.$money_little.' '.\morphos\Russian\Plurality::pluralize('копейка', $money_little);
        else $cents = "";
        return $phrase.$money_big.' '.\morphos\Russian\Plurality::pluralize('рубль', $money_big) . $cents . $inc_message;
    }

    public static function countPersents($value) {
        $persent[95] = round($value * 0.95, 2);
        $persent[4] = round(($value - $persent[95]) * 0.8, 2);
        $persent[1] = $value - $persent[95] - $persent[4];
        return $persent;
    }

    public static function balanceDKP($value) {
        $dkp = User::find(1);
        return self::updateBalance($dkp, $value, true);
    }

    public static function dealCheckout($deal) {
        $persent = self::countPersents($deal->cost);
        self::updateBalance($deal->seller, $persent[95]);
        if($deal->seller->id != 1) self::updateBalance($deal->seller->invited_by->user, $persent[4]);
        else self::balanceDKP($persent[4]);
        self::balanceDKP($persent[1]);
        return true;
    }

    public static function balanceLogAction($type, $item_id) {
        switch ($type) {
            case "createDeal":
                $item = Deal::find($item_id);
                return 'создание <a href="/deal/'.$item->id.'" target="_blank">сделки</a>';
                break;
            case "cancelDeal":
                $item = Deal::find($item_id);
                return 'отмена <a href="/deal/'.$item->id.'" target="_blank">сделки</a>';
                break;
            case "finishDeal":
                $item = Deal::find($item_id);
                return 'окончание <a href="/deal/'.$item->id.'" target="_blank">сделки</a>';
                break;
            case "receiptDeal":
                $item = Deal::find($item_id);
                return 'оплата дополнительной квитанции <a href="/deal/'.$item->id.'" target="_blank">сделки</a>';
                break;
            case "evaluationCatalog":
                $item = Catalog::find($item_id);
                return 'заказ оценки специалистом <a href="/catalog/'.$item->id.'" target="_blank">товара</a>';
                break;
            case "moneyTransfer:from":
                $item = User::find($item_id);
                return 'получено от <a href="/profile/'.$item->id.'" target="_blank">'.\morphos\Russian\nameCase($item->surname.' '.$item->firstname, 'genetivus').'</a>';
                break;
            case "moneyTransfer:to":
                $item = User::find($item_id);
                return 'перевод <a href="/profile/'.$item->id.'" target="_blank">'.\morphos\Russian\nameCase($item->surname.' '.$item->firstname, 'dativus').'</a>';
                break;
            default:
                return 'пополнение баланса';
                break;
        }
    }
}