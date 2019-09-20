<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\Model;

class CountersParams extends Model
{

    protected $callback = null;

    protected $favorite = null;

    protected $field = null;

    protected $offset = null;

    protected $perPage = null;

    protected $permission = null;

    protected $searchString = null;

    protected $status = null;

    protected $type = null;

    protected $mappingClasses = [];

    protected $propNameMap = [
        'per_page' => 'perPage',
        'search_string' => 'searchString'
    ];

    /**
     * Retrieve the callback property
     *
     * @return string|null
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Set the callback property
     *
     * @param string $callback
     * @return $this
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * Retrieve the favorite property
     *
     * @return bool|null
     */
    public function getFavorite()
    {
        return $this->favorite;
    }

    /**
     * Set the favorite property
     *
     * @param bool $favorite
     * @return $this
     */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;
        return $this;
    }

    /**
     * Retrieve the field property
     *
     * @return string|null
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set the field property
     *
     * @param string $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * Retrieve the offset property
     *
     * @return int|null
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Set the offset property
     *
     * @param int $offset
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Retrieve the perPage property
     *
     * @return int|null
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Set the perPage property
     *
     * @param int $perPage
     * @return $this
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * Retrieve the permission property
     *
     * @return string|null
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set the permission property
     *
     * @param string $permission
     * @return $this
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
        return $this;
    }

    /**
     * Retrieve the searchString property
     *
     * @return string|null
     */
    public function getSearchString()
    {
        return $this->searchString;
    }

    /**
     * Set the searchString property
     *
     * @param string $searchString
     * @return $this
     */
    public function setSearchString($searchString)
    {
        $this->searchString = $searchString;
        return $this;
    }

    /**
     * Retrieve the status property
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the status property
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

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
}
