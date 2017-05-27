<?php

namespace App\Helpers;


class DataProvider
{
    private $balanceLogMessage;
    private $balanceLogItem;

    /**
     * @return mixed
     */
    public function getBalanceLogMessage()
    {
        return $this->balanceLogMessage;
    }

    /**
     * @param mixed $balanceLogMessage
     */
    public function setBalanceLogMessage($balanceLogMessage)
    {
        $this->balanceLogMessage = $balanceLogMessage;
    }

    /**
     * @return mixed
     */
    public function getBalanceLogItem()
    {
        return $this->balanceLogItem;
    }

    /**
     * @param mixed $balanceLogItem
     */
    public function setBalanceLogItem($balanceLogItem)
    {
        $this->balanceLogItem = $balanceLogItem;
    }

}