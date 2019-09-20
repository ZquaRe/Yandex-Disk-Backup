<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\Model;

class Monitoring extends Model
{

    protected $enableMonitoring = null;

    protected $emails = null;

    protected $smsAllowed = null;

    protected $enableSms = null;

    protected $smsTime = null;

    protected $mappingClasses = [];

    protected $propNameMap = [
        'enable_monitoring' => 'enableMonitoring',
        'sms_allowed' => 'smsAllowed',
        'enable_sms' => 'enableSms',
        'sms_time' => 'smsTime'
    ];

    /**
     * Retrieve the enableMonitoring property
     *
     * @return int|null
     */
    public function getEnableMonitoring()
    {
        return $this->enableMonitoring;
    }

    /**
     * Set the enableMonitoring property
     *
     * @param int $enableMonitoring
     * @return $this
     */
    public function setEnableMonitoring($enableMonitoring)
    {
        $this->enableMonitoring = $enableMonitoring;
        return $this;
    }

    /**
     * Retrieve the emails property
     *
     * @return array|null
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Set the emails property
     *
     * @param array $emails
     * @return $this
     */
    public function setEmails($emails)
    {
        $this->emails = $emails;
        return $this;
    }

    /**
     * Retrieve the smsAllowed property
     *
     * @return int|null
     */
    public function getSmsAllowed()
    {
        return $this->smsAllowed;
    }

    /**
     * Set the smsAllowed property
     *
     * @param int $smsAllowed
     * @return $this
     */
    public function setSmsAllowed($smsAllowed)
    {
        $this->smsAllowed = $smsAllowed;
        return $this;
    }

    /**
     * Retrieve the enableSms property
     *
     * @return int|null
     */
    public function getEnableSms()
    {
        return $this->enableSms;
    }

    /**
     * Set the enableSms property
     *
     * @param int $enableSms
     * @return $this
     */
    public function setEnableSms($enableSms)
    {
        $this->enableSms = $enableSms;
        return $this;
    }

    /**
     * Retrieve the smsTime property
     *
     * @return string|null
     */
    public function getSmsTime()
    {
        return $this->smsTime;
    }

    /**
     * Set the smsTime property
     *
     * @param string $smsTime
     * @return $this
     */
    public function setSmsTime($smsTime)
    {
        $this->smsTime = $smsTime;
        return $this;
    }
}
