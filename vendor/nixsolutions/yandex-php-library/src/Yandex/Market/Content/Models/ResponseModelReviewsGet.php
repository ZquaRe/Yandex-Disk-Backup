<?php

namespace Yandex\Market\Content\Models;

use Yandex\Market\Content\Models\Base\PagedModel;

class ResponseModelReviewsGet extends PagedModel
{
    protected $mappingClasses = [
        'items' => 'Yandex\Market\Content\Models\Reviews'
    ];

    protected $propNameMap = [
        'reviews' => 'items'
    ];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        parent::__construct($data['modelReviews']);
    }
}
