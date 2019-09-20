<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class Balance extends Model
{
    protected $balance = null;

    protected $daysLeft = null;

    protected $recommendedPayment = null;

    /**
     * Retrieve the balance property
     *
     * @return float|null
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return  int|null
     */
    public function getDaysLeft()
    {
        return $this->daysLeft;
    }

    /**
     * @return  float|null
     */
    public function getRecommendedPayment()
    {
        return $this->recommendedPayment;
    }
}
