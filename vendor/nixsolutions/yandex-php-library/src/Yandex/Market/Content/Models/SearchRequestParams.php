<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class SearchRequestParams extends Model
{
    protected $text = null;

    protected $actualText = null;

    protected $checkSpelling = null;

    /**
     * Retrieve the text property
     *
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Retrieve the actualText property
     *
     * @return string|null
     */
    public function getActualText()
    {
        return $this->actualText;
    }

    /**
     * Retrieve the checkSpelling property
     *
     * @return bool|null
     */
    public function getCheckSpelling()
    {
        return $this->checkSpelling;
    }
}
