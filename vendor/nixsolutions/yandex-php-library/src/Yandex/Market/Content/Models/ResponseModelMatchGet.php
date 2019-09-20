<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class ResponseModelMatchGet extends Model
{
    protected $time = null;

    protected $models = null;

    protected $mappingClasses = [
        'models' => 'Yandex\Market\Content\Models\Base\Models'
    ];

    protected $propNameMap = [
        'model' => 'models'
    ];

    /**
     * Retrieve the time property
     *
     * @return int|null
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Retrieve the models property
     *
     * @return Models|null
     */
    public function getModels()
    {
        return $this->models;
    }
}
