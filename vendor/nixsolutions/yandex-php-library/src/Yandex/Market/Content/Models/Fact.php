<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Fact extends Model
{
    protected $fact = null;

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data)
    {
        // fix for opinion pro & contra.
        if (is_string($data)) {
            $data = ['fact'=>$data];
        }

        parent::__construct($data);
    }

    public function __toString()
    {
        return (string) $this->fact;
    }

    /**
     * Retrieve the fact property
     *
     * @return string|null
     */
    public function getFact()
    {
        return $this->fact;
    }
}
