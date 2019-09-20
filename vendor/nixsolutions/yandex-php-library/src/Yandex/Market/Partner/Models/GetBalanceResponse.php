<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;
use Yandex\Market\Partner\Models\Balance;

class GetBalanceResponse extends Model
{
    /**
     * @var Balance|null
     */
    protected $balance = null;

    protected $mappingClasses = [
        'balance' => 'Yandex\Market\Partner\Models\Balance'
    ];

    /**
     * @return Balance|null
     */
    public function getBalance()
    {
        return $this->balance;
    }
}
