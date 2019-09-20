<?php

namespace Yandex\Market\Content\Models;

use Yandex\Market\Content\Models\Base\PagedModel;

class ResponseModelOffersGet extends PagedModel
{
    protected $regionDelimiterPosition = null;

    protected $filters = null;

    protected $metadata = null;

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        parent::__construct($data['offers']);
    }

    protected $mappingClasses = [
        'items' => 'Yandex\Market\Content\Models\Offers',
        'filters' => 'Yandex\Market\Content\Models\Filters'
    ];

    /**
     * Retrieve the $regionDelimiterPosition property
     *
     * @return int|null
     */
    public function getRegionDelimiterPosition()
    {
        return $this->regionDelimiterPosition;
    }

    /**
     * Retrieve the metadata property
     *
     * @return Offers|null
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}
