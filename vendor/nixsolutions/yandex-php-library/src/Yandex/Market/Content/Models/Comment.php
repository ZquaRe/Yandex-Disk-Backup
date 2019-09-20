<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Comment extends Model
{
    protected $id = null;

    protected $rootId = null;

    protected $parentId = null;

    protected $user = null;

    protected $title = null;

    protected $body = null;

    protected $updateTimestamp = null;

    protected $isValid = null;

    protected $isDeleted = null;

    protected $isBlocked = null;

    protected $isSticky = null;

    protected $params = null;

    protected $children = null;

    protected $mappingClasses = [
        'user' => 'Yandex\Market\Content\Models\User',
        'children' => 'Yandex\Market\Content\Models\Comments'
    ];

    protected $propNameMap = [
        'valid' => 'isValid',
        'deleted' => 'isDeleted',
        'blocked' => 'isBlocked',
        'sticky' => 'isSticky'
    ];

    /**
     * Retrieve the id property
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Retrieve the rootId property
     *
     * @return string|null
     */
    public function getRootId()
    {
        return $this->rootId;
    }

    /**
     * Retrieve the parentId property
     *
     * @return string|null
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Retrieve the user property
     *
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Retrieve the title property
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Retrieve the body property
     *
     * @return string|null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Retrieve the updateTimestamp property
     *
     * @return int|null
     */
    public function getUpdateTimestamp()
    {
        return $this->updateTimestamp;
    }

    /**
     * Retrieve the isValid property
     *
     * @return bool|null
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * Retrieve the isDeleted property
     *
     * @return bool|null
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Retrieve the isBlocked property
     *
     * @return bool|null
     */
    public function getIsBlocked()
    {
        return $this->isBlocked;
    }

    /**
     * Retrieve the isSticky property
     *
     * @return bool|null
     */
    public function getIsSticky()
    {
        return $this->isSticky;
    }

    /**
     * Retrieve the params property
     *
     * @return int|null
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Retrieve the children property
     *
     * @return Comments|null
     */
    public function getChildren()
    {
        return $this->children;
    }
}
