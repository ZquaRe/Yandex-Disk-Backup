<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class ShopOpinion extends Model
{
    protected $id = null;

    protected $agree = null;

    protected $reject = null;

    protected $grade = null;

    protected $anonymous = null;

    protected $authorInfo = null;

    protected $comments = null;

    protected $region = null;

    protected $author = null;

    protected $pro = null;

    protected $text = null;

    protected $visibility = null;

    protected $problem = null;

    protected $contra = null;

    protected $date = null;

    protected $shopOrderId = null;

    protected $delivery = null;

    protected $shop = null;

    protected $mappingClasses = [
        'authorInfo' => 'Yandex\Market\Content\Models\OpinionAuthorInfo',
        'comments' => 'Yandex\Market\Content\Models\Comments',
        'pro' => 'Yandex\Market\Content\Models\Fact',
        'contra' => 'Yandex\Market\Content\Models\Fact',
        'shop' => 'Yandex\Market\Content\Models\Shop'
    ];

    /**
     * Retrieve the grade property
     *
     * @return int|null
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Retrieve the agree property
     *
     * @return int|null
     */
    public function getAgree()
    {
        return $this->agree;
    }

    /**
     * Retrieve the reject property
     *
     * @return int|null
     */
    public function getReject()
    {
        return $this->reject;
    }

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
     * Retrieve the anonymous property
     *
     * @return bool|null
     */
    public function getAnonymous()
    {
        return $this->anonymous;
    }

    /**
     * Retrieve the authorInfo property
     *
     * @return AuthorInfo|null
     */
    public function getAuthorInfo()
    {
        return $this->authorInfo;
    }

    /**
     * Retrieve the comments property
     *
     * @return Comments|null
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Retrieve the date property
     *
     * @return bool|null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Retrieve the author property
     *
     * @return string|null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Retrieve the text property
     *
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Retrieve the contra property
     *
     * @return string|null
     */
    public function getContra()
    {
        return $this->contra;
    }

    /**
     * Retrieve the pro property
     *
     * @return string|null
     */
    public function getPro()
    {
        return $this->pro;
    }

    /**
     * Retrieve the region property
     *
     * @return int|null
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Retrieve the visibility property
     *
     * @return string|null
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Retrieve the problem property
     *
     * @return string|null
     */
    public function getProblem()
    {
        return $this->problem;
    }

    /**
     * Retrieve the shopOrderId property
     *
     * @return int|null
     */
    public function getShopOrderId()
    {
        return $this->shopOrderId;
    }

    /**
     * Retrieve the delivery property
     *
     * @return string|null
     */
    public function getDelivery()
    {
        return $this->delivery;
    }
    /**
     * Retrieve the shop property
     *
     * @return Shop|null
     */
    public function getShop()
    {
        return $this->shop;
    }
}
