<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\Model;

class Webvisor extends Model
{

    protected $urls = null;

    protected $archEnabled = null;

    protected $archType = null;

    protected $loadPlayerType = null;

    protected $mappingClasses = [];

    protected $propNameMap = [
        'arch_enabled' => 'archEnabled',
        'arch_type' => 'archType',
        'load_player_type' => 'loadPlayerType'
    ];

    /**
     * Retrieve the urls property
     *
     * @return string|null
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * Set the urls property
     *
     * @param string $urls
     * @return $this
     */
    public function setUrls($urls)
    {
        $this->urls = $urls;
        return $this;
    }

    /**
     * Retrieve the archEnabled property
     *
     * @return boolean|null
     */
    public function getArchEnabled()
    {
        return $this->archEnabled;
    }

    /**
     * Set the archEnabled property
     *
     * @param boolean $archEnabled
     * @return $this
     */
    public function setArchEnabled($archEnabled)
    {
        $this->archEnabled = $archEnabled;
        return $this;
    }

    /**
     * Retrieve the archType property
     *
     * @return string|null
     */
    public function getArchType()
    {
        return $this->archType;
    }

    /**
     * Set the archType property
     *
     * @param string $archType
     * @return $this
     */
    public function setArchType($archType)
    {
        $this->archType = $archType;
        return $this;
    }

    /**
     * Retrieve the loadPlayerType property
     *
     * @return string|null
     */
    public function getLoadPlayerType()
    {
        return $this->loadPlayerType;
    }

    /**
     * Set the loadPlayerType property
     *
     * @param string $loadPlayerType
     * @return $this
     */
    public function setLoadPlayerType($loadPlayerType)
    {
        $this->loadPlayerType = $loadPlayerType;
        return $this;
    }
}
