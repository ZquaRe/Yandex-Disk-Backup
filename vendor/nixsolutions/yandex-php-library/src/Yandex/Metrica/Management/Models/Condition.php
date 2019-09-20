<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\Model;

class Condition extends Model
{

    protected $type = null;

    protected $url = null;

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Retrieve the type property
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type property
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
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
     * Set the url property
     *
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
}
