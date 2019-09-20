<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class OpinionAuthorInfo extends Model
{
    protected $grades = null;

    protected $avatarUrl = null;

    protected $socialProviders = null;

    /**
     * Retrieve the grades property
     *
     * @return int|null
     */
    public function getGrades()
    {
        return $this->grades;
    }

    /**
     * Retrieve the avatarUrl property
     *
     * @return string|null
     */
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    /**
     * Retrieve the socialProviders property
     *
     * @return SocialProviders|null
     */
    public function getSocialProviders()
    {
        return $this->socialProviders;
    }
}
