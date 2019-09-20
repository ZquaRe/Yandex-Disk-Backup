<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Informer;
use Yandex\Common\Model;

class CodeOptions extends Model
{

    protected $async = null;

    protected $informer = null;

    protected $visor = null;

    protected $ut = null;

    protected $trackHash = null;

    protected $xmlSite = null;

    protected $inOneLine = null;

    protected $mappingClasses = [
        'informer' => 'Yandex\Metrica\Management\Models\Informer'
    ];

    protected $propNameMap = [
        'track_hash' => 'trackHash',
        'xml_site' => 'xmlSite',
        'in_one_line' => 'inOneLine'
    ];

    /**
     * Retrieve the async property
     *
     * @return boolean|null
     */
    public function getAsync()
    {
        return $this->async;
    }

    /**
     * Set the async property
     *
     * @param boolean $async
     * @return $this
     */
    public function setAsync($async)
    {
        $this->async = $async;
        return $this;
    }

    /**
     * Retrieve the informer property
     *
     * @return Informer|null
     */
    public function getInformer()
    {
        return $this->informer;
    }

    /**
     * Set the informer property
     *
     * @param Informer $informer
     * @return $this
     */
    public function setInformer($informer)
    {
        $this->informer = $informer;
        return $this;
    }

    /**
     * Retrieve the visor property
     *
     * @return boolean|null
     */
    public function getVisor()
    {
        return $this->visor;
    }

    /**
     * Set the visor property
     *
     * @param boolean $visor
     * @return $this
     */
    public function setVisor($visor)
    {
        $this->visor = $visor;
        return $this;
    }

    /**
     * Retrieve the ut property
     *
     * @return boolean|null
     */
    public function getUt()
    {
        return $this->ut;
    }

    /**
     * Set the ut property
     *
     * @param boolean $ut
     * @return $this
     */
    public function setUt($ut)
    {
        $this->ut = $ut;
        return $this;
    }

    /**
     * Retrieve the trackHash property
     *
     * @return boolean|null
     */
    public function getTrackHash()
    {
        return $this->trackHash;
    }

    /**
     * Set the trackHash property
     *
     * @param boolean $trackHash
     * @return $this
     */
    public function setTrackHash($trackHash)
    {
        $this->trackHash = $trackHash;
        return $this;
    }

    /**
     * Retrieve the xmlSite property
     *
     * @return boolean|null
     */
    public function getXmlSite()
    {
        return $this->xmlSite;
    }

    /**
     * Set the xmlSite property
     *
     * @param boolean $xmlSite
     * @return $this
     */
    public function setXmlSite($xmlSite)
    {
        $this->xmlSite = $xmlSite;
        return $this;
    }

    /**
     * Retrieve the inOneLine property
     *
     * @return boolean|null
     */
    public function getInOneLine()
    {
        return $this->inOneLine;
    }

    /**
     * Set the inOneLine property
     *
     * @param boolean $inOneLine
     * @return $this
     */
    public function setInOneLine($inOneLine)
    {
        $this->inOneLine = $inOneLine;
        return $this;
    }
}
