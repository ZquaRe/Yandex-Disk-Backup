<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Webvisor;
use Yandex\Metrica\Management\Models\CodeOptions;
use Yandex\Common\Model;

class CounterItem extends Model
{

    protected $id = null;

    protected $ownerLogin = null;

    protected $codeStatus = null;

    protected $name = null;

    protected $site = null;

    protected $type = null;

    protected $favorite = null;

    protected $permission = null;

    protected $webvisor = null;

    protected $codeOptions = null;

    protected $partnerId = null;

    protected $mirrors = null;

    protected $mappingClasses = [
        'webvisor' => 'Yandex\Metrica\Management\Models\Webvisor',
        'codeOptions' => 'Yandex\Metrica\Management\Models\CodeOptions'
    ];

    protected $propNameMap = [
        'owner_login' => 'ownerLogin',
        'code_status' => 'codeStatus',
        'code_options' => 'codeOptions',
        'partner_id' => 'partnerId'
    ];

    /**
     * Retrieve the id property
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id property
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Retrieve the ownerLogin property
     *
     * @return string|null
     */
    public function getOwnerLogin()
    {
        return $this->ownerLogin;
    }

    /**
     * Set the ownerLogin property
     *
     * @param string $ownerLogin
     * @return $this
     */
    public function setOwnerLogin($ownerLogin)
    {
        $this->ownerLogin = $ownerLogin;
        return $this;
    }

    /**
     * Retrieve the codeStatus property
     *
     * @return string|null
     */
    public function getCodeStatus()
    {
        return $this->codeStatus;
    }

    /**
     * Set the codeStatus property
     *
     * @param string $codeStatus
     * @return $this
     */
    public function setCodeStatus($codeStatus)
    {
        $this->codeStatus = $codeStatus;
        return $this;
    }

    /**
     * Retrieve the name property
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name property
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Retrieve the site property
     *
     * @return string|null
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set the site property
     *
     * @param string $site
     * @return $this
     */
    public function setSite($site)
    {
        $this->site = $site;
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

    /**
     * Retrieve the favorite property
     *
     * @return int|null
     */
    public function getFavorite()
    {
        return $this->favorite;
    }

    /**
     * Set the favorite property
     *
     * @param int $favorite
     * @return $this
     */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;
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
     * Retrieve the webvisor property
     *
     * @return Webvisor|null
     */
    public function getWebvisor()
    {
        return $this->webvisor;
    }

    /**
     * Set the webvisor property
     *
     * @param Webvisor $webvisor
     * @return $this
     */
    public function setWebvisor($webvisor)
    {
        $this->webvisor = $webvisor;
        return $this;
    }

    /**
     * Retrieve the codeOptions property
     *
     * @return CodeOptions|null
     */
    public function getCodeOptions()
    {
        return $this->codeOptions;
    }

    /**
     * Set the codeOptions property
     *
     * @param CodeOptions $codeOptions
     * @return $this
     */
    public function setCodeOptions($codeOptions)
    {
        $this->codeOptions = $codeOptions;
        return $this;
    }

    /**
     * Retrieve the partnerId property
     *
     * @return int|null
     */
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    /**
     * Set the partnerId property
     *
     * @param int $partnerId
     * @return $this
     */
    public function setPartnerId($partnerId)
    {
        $this->partnerId = $partnerId;
        return $this;
    }

    /**
     * Retrieve the mirrors property
     *
     * @return array|null
     */
    public function getMirrors()
    {
        return $this->mirrors;
    }

    /**
     * Set the mirrors property
     *
     * @param int $mirrors
     * @return $this
     */
    public function setMirrors($mirrors)
    {
        $this->mirrors = $mirrors;
        return $this;
    }
}
