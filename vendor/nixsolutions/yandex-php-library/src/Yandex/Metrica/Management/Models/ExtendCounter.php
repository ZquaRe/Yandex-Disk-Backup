<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Webvisor;
use Yandex\Metrica\Management\Models\CodeOptions;
use Yandex\Metrica\Management\Models\Goals;
use Yandex\Metrica\Management\Models\Filters;
use Yandex\Metrica\Management\Models\Operations;
use Yandex\Metrica\Management\Models\Grants;
use Yandex\Metrica\Management\Models\Monitoring;
use Yandex\Common\Model;

class ExtendCounter extends Model
{

    protected $id = null;

    protected $ownerLogin = null;

    protected $codeStatus = null;

    protected $name = null;

    protected $site = null;

    protected $type = null;

    protected $permission = null;

    protected $webvisor = null;

    protected $codeOptions = null;

    protected $mirrors = null;

    protected $goals = null;

    protected $filters = null;

    protected $operations = null;

    protected $grants = null;

    protected $monitoring = null;

    protected $filterRobots = null;

    protected $timeZoneName = null;

    protected $visitThreshoId = null;

    protected $code = null;

    protected $accuracy = null;

    protected $callback = null;

    protected $includeUndefined = null;

    protected $sort = null;

    protected $lang = null;

    protected $mappingClasses = [
        'webvisor' => 'Yandex\Metrica\Management\Models\Webvisor',
        'codeOptions' => 'Yandex\Metrica\Management\Models\CodeOptions',
        'goals' => 'Yandex\Metrica\Management\Models\Goals',
        'filters' => 'Yandex\Metrica\Management\Models\Filters',
        'operations' => 'Yandex\Metrica\Management\Models\Operations',
        'grants' => 'Yandex\Metrica\Management\Models\Grants',
        'monitoring' => 'Yandex\Metrica\Management\Models\Monitoring'
    ];

    protected $propNameMap = [
        'owner_login' => 'ownerLogin',
        'code_status' => 'codeStatus',
        'code_options' => 'codeOptions',
        'filter_robots' => 'filterRobots',
        'time_zone_name' => 'timeZoneName',
        'visit_thresho_id' => 'visitThreshoId',
        'include_undefined' => 'includeUndefined'
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
     * @param array $mirrors
     * @return $this
     */
    public function setMirrors($mirrors)
    {
        $this->mirrors = $mirrors;
        return $this;
    }

    /**
     * Retrieve the goals property
     *
     * @return Goals|null
     */
    public function getGoals()
    {
        return $this->goals;
    }

    /**
     * Set the goals property
     *
     * @param Goals $goals
     * @return $this
     */
    public function setGoals($goals)
    {
        $this->goals = $goals;
        return $this;
    }

    /**
     * Retrieve the filters property
     *
     * @return Filters|null
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set the filters property
     *
     * @param Filters $filters
     * @return $this
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
        return $this;
    }

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

    /**
     * Retrieve the grants property
     *
     * @return Grants|null
     */
    public function getGrants()
    {
        return $this->grants;
    }

    /**
     * Set the grants property
     *
     * @param Grants $grants
     * @return $this
     */
    public function setGrants($grants)
    {
        $this->grants = $grants;
        return $this;
    }

    /**
     * Retrieve the monitoring property
     *
     * @return Monitoring|null
     */
    public function getMonitoring()
    {
        return $this->monitoring;
    }

    /**
     * Set the monitoring property
     *
     * @param Monitoring $monitoring
     * @return $this
     */
    public function setMonitoring($monitoring)
    {
        $this->monitoring = $monitoring;
        return $this;
    }

    /**
     * Retrieve the filterRobots property
     *
     * @return int|null
     */
    public function getFilterRobots()
    {
        return $this->filterRobots;
    }

    /**
     * Set the filterRobots property
     *
     * @param int $filterRobots
     * @return $this
     */
    public function setFilterRobots($filterRobots)
    {
        $this->filterRobots = $filterRobots;
        return $this;
    }

    /**
     * Retrieve the timeZoneName property
     *
     * @return string|null
     */
    public function getTimeZoneName()
    {
        return $this->timeZoneName;
    }

    /**
     * Set the timeZoneName property
     *
     * @param string $timeZoneName
     * @return $this
     */
    public function setTimeZoneName($timeZoneName)
    {
        $this->timeZoneName = $timeZoneName;
        return $this;
    }

    /**
     * Retrieve the visitThreshoId property
     *
     * @return int|null
     */
    public function getVisitThreshoId()
    {
        return $this->visitThreshoId;
    }

    /**
     * Set the visitThreshoId property
     *
     * @param int $visitThreshoId
     * @return $this
     */
    public function setVisitThreshoId($visitThreshoId)
    {
        $this->visitThreshoId = $visitThreshoId;
        return $this;
    }

    /**
     * Retrieve the code property
     *
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the code property
     *
     * @param string $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Retrieve the accuracy property
     *
     * @return string|null
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * Set the accuracy property
     *
     * @param string $accuracy
     * @return $this
     */
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;
        return $this;
    }

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
     * Retrieve the includeUndefined property
     *
     * @return bool|null
     */
    public function getIncludeUndefined()
    {
        return $this->includeUndefined;
    }

    /**
     * Set the includeUndefined property
     *
     * @param bool $includeUndefined
     * @return $this
     */
    public function setIncludeUndefined($includeUndefined)
    {
        $this->includeUndefined = $includeUndefined;
        return $this;
    }

    /**
     * Retrieve the sort property
     *
     * @return string|null
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set the sort property
     *
     * @param string $sort
     * @return $this
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * Retrieve the lang property
     *
     * @return string|null
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set the lang property
     *
     * @param string $lang
     * @return $this
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }
}
