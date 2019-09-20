<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Accounts;
use Yandex\Common\Model;

class GetAccountsResponse extends Model
{

    protected $accounts = null;

    protected $mappingClasses = [
        'accounts' => 'Yandex\Metrica\Management\Models\Accounts'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the accounts property
     *
     * @return Accounts|null
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * Set the accounts property
     *
     * @param Accounts $accounts
     * @return $this
     */
    public function setAccounts($accounts)
    {
        $this->accounts = $accounts;
        return $this;
    }
}
