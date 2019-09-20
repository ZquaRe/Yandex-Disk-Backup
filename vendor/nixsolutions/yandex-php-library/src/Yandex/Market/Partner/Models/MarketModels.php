<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

namespace Yandex\Market\Partner\Models;

use Yandex\Common\ObjectModel;

class MarketModels extends ObjectModel
{
    /**
     * Add model
     *
     * @param array|MarketModel $model
     * @return $this
     */
    public function add($model)
    {
        if (is_array($model)) {
            $this->collection[] = new MarketModel($model);
        } elseif ($model instanceof MarketModel) {
            $this->collection[] = $model;
        }

        return $this;
    }

    /**
     * Get models
     *
     * @return array
     */
    public function getAll()
    {
        return $this->collection;
    }
}
