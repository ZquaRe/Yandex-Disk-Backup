<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link      https://github.com/nixsolutions/yandex-php-library
 */

/**
 * @namespace
 */
namespace Yandex\DataSync\Models\Database\Delta;

use Yandex\DataSync\Exception\EmptyRecordFieldValueTypeException;
use Yandex\Common\Model;

/**
 * Class RecordFieldValue
 *
 * @category Yandex
 * @package  DataSync
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  02.03.16 13:16
 */
class RecordFieldValue extends Model
{
    const TYPE_BINARY = 'binary';
    const TYPE_STRING = 'string';
    const TYPE_DOUBLE = 'double';
    /**
     * Array elements. For each item, you must explicitly specify the type.
     */
    const TYPE_LIST = 'list';
    /**
     * Date and time in UTC.
     */
    const TYPE_DATETIME = 'datetime';
    const TYPE_INTEGER = 'integer';
    const TYPE_BOOLEAN = 'boolean';
    /**
     * Is NaN value (floating point number).
     */
    const TYPE_NAN = 'nan';
    /**
     * Is the value of negative infinity.
     */
    const TYPE_NINF = 'ninf';
    /**
     * Is the value of infinity.
     */
    const TYPE_INF = 'inf';
    /**
     * Is NULL.
     */
    const TYPE_NULL = 'null';

    protected $value;

    protected $type;

    /**
     * Get array from object
     *
     * @param array|object $data
     *
     * @return array
     */
    protected function toArrayRecursive($data)
    {
        $type = $data->getType();
        if (is_array($data->getValue())) {
            $result = [
                self::TYPE_LIST => [],
                'type'          => self::TYPE_LIST
            ];
            foreach ($data->getValue() as $key => $value) {
                if ($value instanceof $this) {
                    $result[self::TYPE_LIST][] = $data->toArrayRecursive($value);
                }
            }
            return $result;
        } else {
            return [
                $type  => $data->getValue(),
                'type' => $type,
            ];
        }
    }

    /**
     * Set from array
     *
     * @param array $data
     *
     * @return $this
     */
    public function fromArray($data)
    {
        if (empty($data)) {
            return $this;
        }
        if (isset($data['type']) && $data['type']) {
            $this->setType($data['type']);
        }
        if (isset($data[$this->getType()]) && $data[$this->getType()]) {
            $this->setValue($data[$this->getType()]);
        }
        return $this;
    }

    /**
     * @return string
     * @throws EmptyRecordFieldValueTypeException
     */
    public function getType()
    {
        if (!$this->type) {
            switch (true) {
                case is_int($this->value):
                    $type = self::TYPE_INTEGER;
                    break;
                case is_string($this->value):
                    $type = self::TYPE_STRING;
                    break;
                case is_bool($this->value):
                    $type = self::TYPE_BOOLEAN;
                    break;
                case is_float($this->value):
                    $type = self::TYPE_DOUBLE;
                    break;
                case is_null($this->value):
                    $type = self::TYPE_NULL;
                    break;
                case is_array($this->value):
                    $type = self::TYPE_LIST;
                    break;
                default:
                    throw new EmptyRecordFieldValueTypeException('Type of Record Field Value is empty');
            }
            $this->type = $type;
        }
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed|$this[]
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
