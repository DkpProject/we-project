<?php

namespace App\Http\Controllers;

use App\Helpers\Balance;
use App\Helpers\DataProvider;
use App\Helpers\DealHelper;
use App\Helpers\Notify;

use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Setting;
use App\Models\User;
use App\Models\Deal;
use App\Models\Catalog;
use App\Models\Service;
use App\Models\DealsMessages;
use Gate;
use Validator;

class DealController extends Controller
{

    /*
     * Показ сделки
     */
    function view(Deal $deal) {
        if (!policy(Deal::class)->view(\Auth::user(), $deal))
            return Notify::create('Сделка с вашим участием не найдена', 'danger', back());

        if (policy(Deal::class)->seller(\Auth::user(), $deal)) $person = 'seller';
        else $person = 'purchaser';

        return view('deal.index', ['deal' => $deal, 'person' => $person]);
    }

    /*
     * Отмена сделки
     */
    function cancel(Deal $deal, DataProvider $storage) {
        if (!policy(Deal::class)->view(\Auth::user(), $deal))
            return Notify::create('Сделка с вашим участием не найдена', 'danger', back());

        if (($deal->status == 0 && policy(Deal::class)->purchaser(\Auth::user(), $deal)) || ($deal->status < 2 && policy(Deal::class)->seller(\Auth::user(), $deal))) {

            $storage->setBalanceLogItem($deal);
            $storage->setBalanceLogMessage('cancelDeal');
            Balance::updateBalance($deal->purchaser, $deal->cost);
            DealHelper::message($deal, 'Сделка была отменена');
            DealHelper::close($deal, \Auth::user());
            return Notify::create('Сделка была успешно закрыта', 'success', back());
        }
        return Notify::create('Сделка не может быть отменена', 'dunger', back());
    }

    /*
     * Завершение сделки
     */
    function finish(Request $request, Deal $deal, $person, DataProvider $storage) {
        $auth = \Auth::user();
        $data = $request->all();

        if ($deal->receipts()->toPay()->count())
            if (DealHelper::detectPerson($deal, $auth) == "purchaser")
                return Notify::create('Для завершения сделки вы должны оплатить все выставленные счета', 'danger', back());
            else
                return Notify::create('Для завершения сделки покупатель должен оплатить все выставленные счета', 'danger', back());

        if (!policy(Deal::class)->view(\Auth::user(), $deal))
            return Notify::create('Сделка с вашим участием не найдена', 'danger', back());

        $person = DealHelper::detectPerson($deal, $auth);

        $require = array('comment' => 'max:500');
        if ($person == 'seller') $data['percent'] = 0;
        else array_add($require, 'percent', array('required', 'regex:/0|25|50|75|100/'));
        Validator::make($data, $require)->validate();

        DealHelper::nextStatus($deal, $auth, $person);

        DealHelper::message($deal, $data['comment'], \Auth::user(), 1, (isset($data['percent']))?$data['percent']:0);

        if ($deal->state == 'finished') {
            $storage->setBalanceLogItem($deal);
            $storage->setBalanceLogMessage('finishDeal');
            Balance::dealCheckout($deal);
            DealHelper::message($deal, 'Сделка была успешно завершена!');
        }
        return back();
    }


    function receiptPayment(Deal $deal, Receipt $receipt, DataProvider $storage) {
        $auth = \Auth::user();
        if ($deal->purchaser->id != $auth->id)
            return Notify::actionDenied(back());
        if ($receipt->paid)
            return Notify::create('Этот счет уже оплачен', 'danger', back());
        $storage->setBalanceLogItem($deal);
        $storage->setBalanceLogMessage('receiptDeal');
        Balance::updateBalance($auth, -$receipt->price);
        Balance::balanceDKP($receipt->price);
        $receipt->update(['paid' => 1]);
        return Notify::create('Вы успешно оплатили счет', 'success', back());
    }

}
