<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Facts extends Model
{
    protected $pros = null;

    protected $contras = null;

    protected $mappingClasses = [
        'pros' => 'Yandex\Market\Content\Models\Pros',
        'contras' => 'Yandex\Market\Content\Models\Contras'
    ];

    protected $propNameMap = [
        'pro' => 'pros',
        'contra' => 'contras'
    ];

    /**
     * Retrieve the pros property
     *
     * @return Pros|null
     */
    public function getPros()
    {
        return $this->pros;
    }

    /**
     * Retrieve the contras property
     *
     * @return Contras|null
     */
    public function getContras()
    {
        return $this->contras;
    }
}
