<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class ResponseOfferGet extends Model
{
    protected $offer = null;

    protected $mappingClasses = [
        'offer' => 'Yandex\Market\Content\Models\Offer'
    ];

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
