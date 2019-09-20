<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

/**
 * @namespace
 */
namespace Yandex\Common;

/**
 * Class Model
 * @package Yandex\Common
 */
abstract class Model
{
    protected $mappingClasses = [];

    /**
     * Contains property name mappings.
     *
     * [
     *  'data_array_property1' => 'objectProperty1',
     *  'data_array_property2' => 'objectProperty2',
     * ]
     *
     * Data array property uses as keys
     * because there is can be more then one rule per object property
     *
     * f.g. $data['nmodels'] and ['modelsnum'] should map in modelsCount property.
     * Otherwise not unique array keys cause remapping of properties.
     *
     * @var array
     */
    protected $propNameMap = [];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->fromArray($data);
    }

    /**
     * Set from array
     *
     * @param array $data
     * @return $this
     */
    public function fromArray($data)
    {
        foreach ($data as $key => $val) {
            if (is_int($key)) {
                if (method_exists($this, "add")) {
                    $this->add($val);
                }
            }

            $propertyName = $key;
            $ourPropertyName = array_search($propertyName, $this->propNameMap);

            if ($ourPropertyName && isset($data[$ourPropertyName])) {
                $propertyName = $ourPropertyName;
            }

            if (!empty($this->propNameMap)) {
                if (array_key_exists($key, $this->propNameMap)) {
                    $propertyName = $this->propNameMap[$key];
                }
            }

            if (property_exists($this, $propertyName)) {
                if (isset($this->mappingClasses[$propertyName])) {
                    $this->{$propertyName} = new $this->mappingClasses[$propertyName]($val);
                } else {
                    $this->{$propertyName} = $val;
                }
            }
        }
        return $this;
    }

    /**
     * Set from json
     *
     * @param string $json
     * @return $this
     */
    public function fromJson($json)
    {
        $this->fromArray(json_decode($json, true));
        return $this;
    }

    /**
     * Get array from object
     *
     * @return array
     */
    public function toArray()
    {
        return $this->toArrayRecursive($this);
    }

    /**
     * Get array from object
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArrayRecursive($this));
    }

    /**
     * Get array from object
     *
     * @param array|object $data
     * @return array
     */
    protected function toArrayRecursive($data)
    {
        if (is_array($data) || is_object($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                if ($key === "mappingClasses" || $key === "propNameMap") {
                    continue;
                }
                $propNameMap = $key;
                $obj         = $this;
                if (is_object($data)) {
                    $obj = $data;
                }

                if (property_exists($obj, $propNameMap)) {
                    $ourPropertyName = array_search($propNameMap, $obj->propNameMap);

                    if ($ourPropertyName) {
                        $propNameMap = $ourPropertyName;
                    }
                }

                if (is_object($value) && method_exists($value, "getAll")) {
                    if (method_exists($obj, 'toArrayRecursive')) {
                        $result[$propNameMap] = $obj->toArrayRecursive($value->getAll());
                    }
                } elseif ($value !== null) {
                    if (method_exists($obj, 'toArrayRecursive')) {
                        $result[$propNameMap] = $obj->toArrayRecursive($value);
                    }
                }
            }
            return $result;
        }
        return $data;
    }
}
