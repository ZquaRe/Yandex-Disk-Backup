<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

// @note: Merge between Shop & ShopInfo?

class ShopInfo extends Model
{
    protected $id = null;

    protected $name = null;

    protected $shopName = null;

    protected $url = null;

    protected $gradeTotal = null;

    protected $rating = null;

    protected $factAddress = null;

    protected $juridicalAddress = null;

    protected $status = null;

    protected $ogrn = null;

    protected $yamoney = null;

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
     * Retrieve the name property
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
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
     * Retrieve the url property
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Retrieve the gradeTotal property
     *
     * @return int|null
     */
    public function getGradeTotal()
    {
        return $this->gradeTotal;
    }

    /**
     * Retrieve the rating property
     *
     * @return float|null
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Retrieve the factAddress property
     *
     * @return string|null
     */
    public function getFactAddress()
    {
        return $this->factAddress;
    }

    /**
     * Retrieve the juridicalAddress property
     *
     * @return string|null
     */
    public function getJuridicalAddress()
    {
        return $this->juridicalAddress;
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
     * Retrieve the ogrn property
     *
     * @return string|null
     */
    public function getOgrn()
    {
        return $this->ogrn;
    }

    /**
     * Retrieve the yamoney property
     *
     * @return string|null
     */
    public function getYamoney()
    {
        return $this->yamoney;
    }
}
