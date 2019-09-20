<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Market\Partner\Models\Items;
use Yandex\Market\Partner\Models\Delivery;
use Yandex\Market\Partner\Models\Buyer;
use Yandex\Common\Model;

class Order extends Model
{

    protected $id = null;

    protected $status = null;

    protected $substatus = null;

    protected $creationDate = null;

    protected $currency = null;

    protected $itemsTotal = null;

    protected $total = null;

    protected $paymentType = null;

    protected $paymentMethod = null;

    protected $fake = null;

    protected $notes = null;

    protected $items = null;

    protected $delivery = null;

    protected $buyer = null;

    protected $mappingClasses = [
        'items' => 'Yandex\Market\Partner\Models\Items',
        'delivery' => 'Yandex\Market\Partner\Models\Delivery',
        'buyer' => 'Yandex\Market\Partner\Models\Buyer'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the id property
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id property
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Retrieve the status property
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the status property
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Retrieve the substatus property
     *
     * @return string|null
     */
    public function getSubstatus()
    {
        return $this->substatus;
    }

    /**
     * Set the substatus property
     *
     * @param string $substatus
     * @return $this
     */
    public function setSubstatus($substatus)
    {
        $this->substatus = $substatus;
        return $this;
    }

    /**
     * Retrieve the creationDate property
     *
     * @return string|null
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set the creationDate property
     *
     * @param string $creationDate
     * @return $this
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * Retrieve the currency property
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the currency property
     *
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * Retrieve the itemsTotal property
     *
     * @return int|null
     */
    public function getItemsTotal()
    {
        return $this->itemsTotal;
    }

    /**
     * Set the itemsTotal property
     *
     * @param int $itemsTotal
     * @return $this
     */
    public function setItemsTotal($itemsTotal)
    {
        $this->itemsTotal = $itemsTotal;
        return $this;
    }

    /**
     * Retrieve the total property
     *
     * @return int|null
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the total property
     *
     * @param int $total
     * @return $this
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * Retrieve the paymentType property
     *
     * @return string|null
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * Set the paymentType property
     *
     * @param string $paymentType
     * @return $this
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    /**
     * Retrieve the paymentMethod property
     *
     * @return string|null
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set the paymentMethod property
     *
     * @param string $paymentMethod
     * @return $this
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    /**
     * Retrieve the fake property
     *
     * @return boolean|null
     */
    public function getFake()
    {
        return $this->fake;
    }

    /**
     * Set the fake property
     *
     * @param boolean $fake
     * @return $this
     */
    public function setFake($fake)
    {
        $this->fake = $fake;
        return $this;
    }

    /**
     * Retrieve the notes property
     *
     * @return string|null
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set the notes property
     *
     * @param string $notes
     * @return $this
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * Retrieve the items property
     *
     * @return Items|null
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set the items property
     *
     * @param Items $items
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * Retrieve the delivery property
     *
     * @return Delivery|null
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Set the delivery property
     *
     * @param Delivery $delivery
     * @return $this
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;
        return $this;
    }

    /**
     * Retrieve the buyer property
     *
     * @return Buyer|null
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * Set the buyer property
     *
     * @param Buyer $buyer
     * @return $this
     */
    public function setBuyer($buyer)
    {
        $this->buyer = $buyer;
        return $this;
    }
}
