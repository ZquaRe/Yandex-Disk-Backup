<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class AddressOutlet extends Model
{

    protected $city = null;

    protected $street = null;

    protected $number = null;

    protected $building = null;

    protected $estate = null;

    protected $block = null;

    protected $additional = null;

    protected $km = null;

    /**
     * @return null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return null
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return null
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return null
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @return null
     */
    public function getEstate()
    {
        return $this->estate;
    }

    /**
     * @return null
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @return null
     */
    public function getAdditional()
    {
        return $this->additional;
    }

    /**
     * @return null
     */
    public function getKm()
    {
        return $this->km;
    }
}
