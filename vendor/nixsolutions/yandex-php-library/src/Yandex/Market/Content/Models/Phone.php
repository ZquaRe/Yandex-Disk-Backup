<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Phone extends Model
{
    protected $country = null;

    protected $city = null;

    protected $number = null;

    protected $sanitizedNumber = null;

    protected $call = null;

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
     * Retrieve the city property
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Retrieve the number property
     *
     * @return string|null
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Retrieve the sanitizedNumber property
     *
     * @return string|null
     */
    public function getSanitizedNumber()
    {
        return $this->sanitizedNumber;
    }

    /**
     * Retrieve the call property
     *
     * @return string|null
     */
    public function getCall()
    {
        return $this->call;
    }
}
