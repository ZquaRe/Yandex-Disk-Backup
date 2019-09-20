<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\Model;

class Informer extends Model
{

    protected $enabled = null;

    protected $type = null;

    protected $size = null;

    protected $indicator = null;

    protected $colorStart = null;

    protected $colorEnd = null;

    protected $colorText = null;

    protected $colorArrow = null;

    protected $mappingClasses = [];

    protected $propNameMap = [
        'color_start' => 'colorStart',
        'color_end' => 'colorEnd',
        'color_text' => 'colorText',
        'color_arrow' => 'colorArrow'
    ];

    /**
     * Retrieve the enabled property
     *
     * @return boolean|null
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set the enabled property
     *
     * @param boolean $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
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
     * Retrieve the size property
     *
     * @return string|null
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the size property
     *
     * @param string $size
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Retrieve the indicator property
     *
     * @return string|null
     */
    public function getIndicator()
    {
        return $this->indicator;
    }

    /**
     * Set the indicator property
     *
     * @param string $indicator
     * @return $this
     */
    public function setIndicator($indicator)
    {
        $this->indicator = $indicator;
        return $this;
    }

    /**
     * Retrieve the colorStart property
     *
     * @return string|null
     */
    public function getColorStart()
    {
        return $this->colorStart;
    }

    /**
     * Set the colorStart property
     *
     * @param string $colorStart
     * @return $this
     */
    public function setColorStart($colorStart)
    {
        $this->colorStart = $colorStart;
        return $this;
    }

    /**
     * Retrieve the colorEnd property
     *
     * @return string|null
     */
    public function getColorEnd()
    {
        return $this->colorEnd;
    }

    /**
     * Set the colorEnd property
     *
     * @param string $colorEnd
     * @return $this
     */
    public function setColorEnd($colorEnd)
    {
        $this->colorEnd = $colorEnd;
        return $this;
    }

    /**
     * Retrieve the colorText property
     *
     * @return int|null
     */
    public function getColorText()
    {
        return $this->colorText;
    }

    /**
     * Set the colorText property
     *
     * @param int $colorText
     * @return $this
     */
    public function setColorText($colorText)
    {
        $this->colorText = $colorText;
        return $this;
    }

    /**
     * Retrieve the colorArrow property
     *
     * @return int|null
     */
    public function getColorArrow()
    {
        return $this->colorArrow;
    }

    /**
     * Set the colorArrow property
     *
     * @param int $colorArrow
     * @return $this
     */
    public function setColorArrow($colorArrow)
    {
        $this->colorArrow = $colorArrow;
        return $this;
    }
}
