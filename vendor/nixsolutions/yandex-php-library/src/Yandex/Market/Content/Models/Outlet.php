<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Outlet extends Model
{
    protected $id = null;

    protected $type = null;

    protected $name = null;

    protected $description = null;

    protected $shopId = null;

    protected $shopName = null;

    protected $phone = null;

    protected $schedules = null;

    protected $contactsPage = null;

    protected $geo = null;

    protected $country = null;

    protected $localityName = null;

    protected $thoroughfareName = null;

    protected $premiseNumber = null;

    protected $building = null;

    protected $block = null;

    protected $officeNumber = null;

    // @? !!!
    protected $offer = null;

    protected $mappingClasses = [
        'phone' => 'Yandex\Market\Content\Models\Phone',
        'schedules' => 'Yandex\Market\Content\Models\Schedules',
        'geo' => 'Yandex\Market\Content\Models\Geo',
        'offer' => 'Yandex\Market\Content\Models\Offer'
    ];

    protected $propNameMap = [
        'pointId' => 'id',
        'pointType' => 'type',
        'pointName' => 'name',
        'pointDescription' => 'description',
        'schedule' => 'schedules'
    ];

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
     * Retrieve the type property
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Retrieve the name property
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Retrieve the description property
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Retrieve the shopId property
     *
     * @return int|null
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * Retrieve the shopName property
     *
     * @return string|null
     */
    public function getShopName()
    {
        return $this->shopName;
    }

    /**
     * Retrieve the phone property
     *
     * @return Phone|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Retrieve the schedules property
     *
     * @return Schedules|null
     */
    public function getSchedules()
    {
        return $this->schedules;
    }

    /**
     * Retrieve the contactsPage property
     *
     * @return string|null
     */
    public function getContactsPage()
    {
        return $this->contactsPage;
    }

    /**
     * Retrieve the geo property
     *
     * @return Geo|null
     */
    public function getGeo()
    {
        return $this->geo;
    }

    /**
     * Retrieve the country property
     *
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Retrieve the localityName property
     *
     * @return string|null
     */
    public function getLocalityName()
    {
        return $this->localityName;
    }

    /**
     * Retrieve the thoroughfareName property
     *
     * @return string|null
     */
    public function getThoroughfareName()
    {
        return $this->thoroughfareName;
    }

    /**
     * Retrieve the premiseNumber property
     *
     * @return string|null
     */
    public function getPremiseNumber()
    {
        return $this->premiseNumber;
    }

    /**
     * Retrieve the building property
     *
     * @return string|null
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Retrieve the block property
     *
     * @return string|null
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * Retrieve the officeNumber property
     *
     * @return string|null
     */
    public function getOfficeNumber()
    {
        return $this->officeNumber;
    }

    /**
     * Retrieve the offer property
     *
     * @return Offer|null
     */
    public function getOffer()
    {
        return $this->offer;
    }
}
