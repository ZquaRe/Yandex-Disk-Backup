<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Media extends Model
{
    protected $reviewsCount = null;

    protected $articlesCount = null;

    protected $propNameMap = [
        'reviews' => 'reviewsCount',
        'articles' => 'articlesCount',
    ];

    /**
     * Retrieve the reviewsCount property
     *
     * @return int|null
     */
    public function getReviewsCount()
    {
        return $this->reviewsCount;
    }

    /**
     * Retrieve the articlesCount property
     *
     * @return int|null
     */
    public function getArticlesCount()
    {
        return $this->articlesCount;
    }
}
