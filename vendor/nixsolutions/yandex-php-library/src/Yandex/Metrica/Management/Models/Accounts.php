<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\ObjectModel;

class Accounts extends ObjectModel
{

    protected $collection = [];

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Add item
     * @param Account $account
     *
     * @return $this
     */
    public function add($account)
    {
        if (is_array($account)) {
            $this->collection[] = new Account($account);
        } elseif (is_object($account) && $account instanceof Account) {
            $this->collection[] = $account;
        }

        return $this;
    }

    /**
     * Get items
     * @return Account[]
     */
    public function getAll()
    {
        return $this->collection;
    }
}
