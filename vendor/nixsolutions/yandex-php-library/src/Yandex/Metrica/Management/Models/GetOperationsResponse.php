<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Operations;
use Yandex\Common\Model;

class GetOperationsResponse extends Model
{

    protected $operations = null;

    protected $mappingClasses = [
        'operations' => 'Yandex\Metrica\Management\Models\Operations'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the operations property
     *
     * @return Operations|null
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * Set the operations property
     *
     * @param Operations $operations
     * @return $this
     */
    public function setOperations($operations)
    {
        $this->operations = $operations;
        return $this;
    }
}
