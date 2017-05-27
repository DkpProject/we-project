<?php

namespace App\Helpers;

class DealHelper
{
    public static function setStatus($deal, $status) {
        $deal->update(['status' => $status]);
    }
    public static function setState($deal, $state) {
        $deal->update(['state' => $state]);
    }

    public static function toogleItem($deal, $state) {
        $deal->item()->update(['disabled' => $state]);
    }

    public static function close($deal, $by) {
        $deal->update(['closed_by' => $by->id]);
        self::setState($deal, 'canceled');
        self::toogleItem($deal, false);
    }

    public static function detectPerson($deal, $user) {
        if ($deal->seller->id == $user->id) return "seller";
        return "purchaser";
    }

    public static function message($deal, $message, $user = null, $finish = 0, $rating = 0) {
        if (is_null($user)) $author = 0;
        else $author = $user->id;
        $deal->messages()->create([
            'user_id' => $author,
            'comment' => $message,
            'finish' => $finish,
            'rating' => $rating,
        ]);
    }

    public static function statuses($deal, $more = false) {
        switch ($deal->state) {
            case 'initial':
                return "Начальная";
                break;
            case 'inprogress':
                if (!$more) return "В процессе";
                else return self::inProgressStatus($deal);
                break;
            case 'finished':
                return "Завершена";
                break;
            case 'canceled':
                if (!$more) return "Отменена";
                else return 'Отменена <a href="/profile/'.$deal->closed->id.'">'.$deal->closed->firstname.' '.$deal->closed->surname.'</a>';
                break;
        }
    }

    public static function type($deal) {
        switch ($deal->type) {
            case 'buy':
                return "Продажа";
                break;
            case 'rent':
                return "Прокат";
                break;
            case 'service':
                return "Сервис";
                break;
            case 'store':
                return "Хранение";
                break;
            case 'selling':
                return "Реализация";
                break;
        }
    }

    private static function inProgressStatus($deal) {
        $status = self::getStatuses($deal);
        return $status[$deal->status];
    }

    private static function getStatuses($deal) {
        if ($deal->type == "buy") return [
            1 => 'Покупатель получил товар',
            2 => 'Продавец передал товар'
        ];
        if ($deal->type == "rent") return [
            1 => 'Товар находится в эксплуатации'
        ];
        if ($deal->type == "service") return [
            1 => 'Идет оценка стоимости ремонта',
            2 => 'Подтверждение ремонта',
        ];
        if ($deal->type == "store") return [
            1 => 'Товар находится в эксплуатации'
        ];
        if ($deal->type == "selling") return [
            1 => 'Товар находится в эксплуатации'
        ];
    }

    public static function nextStatus($deal, $user, $person) {
        if ($deal->module() == 'catalog') {
            if ($deal->type == 'buy') {
                if ($deal->state == 'initial') {
                    self::setState($deal, 'inprogress');
                    if ($person == 'seller') self::setStatus($deal, 2);
                    else self::setStatus($deal, 1);
                } else {
                    $status = 3;
                    self::setState($deal, 'finished');
                    self::toogleItem($deal, true);
                }

            } elseif ($deal->type == 'rent') {

                if ($deal->state == 'initial') {
                    self::setStatus($deal, 1);
                    self::setState($deal, 'inprogress');
                    self::toogleItem($deal, true);
                } else {
                    self::setStatus($deal, 2);
                    self::setState($deal, 'finished');
                    self::toogleItem($deal, false);
                }

            } elseif ($deal->type == 'service') {
                //TODO: Начать отсюда и доделать статусы
                if ($deal->state == 'initial') {
                    $status = 1;
                    self::setState($deal, 'inprogress');
                    self::toogleItem($deal, true);
                } else {
                    $status = 2;
                    self::setState($deal, 'finished');
                    self::toogleItem($deal, false);
                }

            } elseif ($deal->type == 'store') {

                if ($deal->state == 'initial') {
                    $status = 1;
                    self::setState($deal, 'inprogress');
                    self::toogleItem($deal, true);
                } else {
                    $status = 2;
                    self::setState($deal, 'finished');
                    self::toogleItem($deal, false);
                }

            } elseif ($deal->type == 'selling') {

                if ($deal->state == 'initial') {
                    $status = 1;
                    self::setState($deal, 'inprogress');
                    self::toogleItem($deal, true);
                } else {
                    $status = 2;
                    self::setState($deal, 'finished');
                    self::toogleItem($deal, false);
                }

            }

        } elseif ($deal->module() == 'service') {



        }
    }
}