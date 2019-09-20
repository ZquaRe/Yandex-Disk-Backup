<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class ModelOpinion extends Model
{
    protected $grade = null;

    protected $agree = null;

    protected $reject = null;

    protected $id = null;

    protected $anonymous = null;

    protected $authorInfo = null;

    protected $date = null;

    protected $author = null;

    protected $text = null;

    protected $contra = null;

    protected $pro = null;

    protected $region = null;

    protected $visibility = null;

    protected $usageTime = null;

    protected $priceGrade = null;

    protected $convenienceGrade = null;

    protected $qualityGrade = null;

    protected $mappingClasses = [
        'authorInfo' => 'Yandex\Market\Content\Models\OpinionAuthorInfo',
        'pro' => 'Yandex\Market\Content\Models\Fact',
        'contra' => 'Yandex\Market\Content\Models\Fact'
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
     * Retrieve the usageTime property
     *
     * @return string|null
     */
    public function getUsageTime()
    {
        return $this->usageTime;
    }

    /**
     * Retrieve the priceGrade property
     *
     * @return int|null
     */
    public function getPriceGrade()
    {
        return $this->priceGrade;
    }

    /**
     * Retrieve the convenienceGrade property
     *
     * @return int|null
     */
    public function getConvenienceGrade()
    {
        return $this->convenienceGrade;
    }

    /**
     * Retrieve the qualityGrade property
     *
     * @return int|null
     */
    public function getQualityGrade()
    {
        return $this->qualityGrade;
    }
}
