<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class Buyer extends Model
{

    protected $id = null;

    protected $lastName = null;

    protected $firstName = null;

    protected $middleName = null;

    protected $phone = null;

    protected $email = null;

    protected $mappingClasses = [];

    protected $propNameMap = [];

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
     * Retrieve the lastName property
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Retrieve the firstName property
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Retrieve the middleName property
     *
     * @return string|null
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Retrieve the phone property
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Retrieve the email property
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }
}
