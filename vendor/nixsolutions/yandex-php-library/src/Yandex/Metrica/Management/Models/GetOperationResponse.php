<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Operation;
use Yandex\Common\Model;

class GetOperationResponse extends Model
{

    protected $operation = null;

    protected $mappingClasses = [
        'operation' => 'Yandex\Metrica\Management\Models\Operation'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the operation property
     *
     * @return Operation|null
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set the operation property
     *
     * @param Operation $operation
     * @return $this
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
        return $this;
    }
}
