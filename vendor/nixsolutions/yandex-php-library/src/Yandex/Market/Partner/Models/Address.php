<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class Address extends Model
{

    protected $country = null;

    protected $postcode = null;

    protected $city = null;

    protected $subway = null;

    protected $street = null;

    protected $house = null;

    protected $block = null;

    protected $entrance = null;

    protected $entryphone = null;

    protected $floor = null;

    protected $apartment = null;

    protected $recipient = null;

    protected $phone = null;

    protected $mappingClasses = [];

    protected $propNameMap = [];

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
     * Retrieve the postcode property
     *
     * @return string|null
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Retrieve the city property
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Retrieve the subway property
     *
     * @return string|null
     */
    public function getSubway()
    {
        return $this->subway;
    }

    /**
     * Retrieve the street property
     *
     * @return string|null
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Retrieve the house property
     *
     * @return string|null
     */
    public function getHouse()
    {
        return $this->house;
    }

    /**
     * Retrieve the entrance property
     *
     * @return string|null
     */
    public function getEntrance()
    {
        return $this->entrance;
    }

    /**
     * Retrieve the entryphone property
     *
     * @return string|null
     */
    public function getEntryphone()
    {
        return $this->entryphone;
    }

    /**
     * Retrieve the floor property
     *
     * @return string|null
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Retrieve the apartment property
     *
     * @return string|null
     */
    public function getApartment()
    {
        return $this->apartment;
    }

    /**
     * Retrieve the recipient property
     *
     * @return string|null
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Retrieve the phone property
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }
}
