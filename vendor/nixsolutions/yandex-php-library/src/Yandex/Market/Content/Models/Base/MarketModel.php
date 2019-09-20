<?php

namespace Yandex\Market\Content\Models\Base;

use Yandex\Common\Model;
use Yandex\Market\Content\Models\ModelSingle;
use Yandex\Market\Content\Models\ModelChild;
use Yandex\Market\Content\Models\ModelParent;
use Yandex\Market\Content\Models\ModelVisual;
use Yandex\Market\Content\Models\ModelInfo;

/**
 * Class MarketModel
 *
 * @package Yandex\Market\Content\Models\Base
 *
 * @author  Oleg Scherbakov <holdmann@yandex.ru>
 * @created 03.01.16 04:23
 *
 *
 *
 *
    ----------------------------------Instance--------------------------------------
    |  | ModelSingle      | ModelParent     | ModelChildren     | ModelVisual
    --------------------------------------------------------------------------------
    |  | offersCount      | offersCount        | offersCount       | offersCount
    --------------------------------------------------------------------------------
    |  | rating           | rating            | rating            | -
    --------------------------------------------------------------------------------
    |  | reviewsCount     | reviewsCount    | reviewsCount      | -
    --------------------------------------------------------------------------------
    |  | articlesCount      | articlesCount    | articlesCount     | -
    --------------------------------------------------------------------------------
    |  | isNew            | isNew            | isNew             | -
    --------------------------------------------------------------------------------
     P | vendorId         | vendorId        | vendorId            | vendorId
    --------------------------------------------------------------------------------
     R | gradeCount          | gradeCount        | gradeCount        | -
    --------------------------------------------------------------------------------
     O | categoryId       | categoryId        | categoryId        | categoryId
    --------------------------------------------------------------------------------
     P | id                  | id                | id                | id
    --------------------------------------------------------------------------------
     E | photos              | photos            | photos            | photos
    --------------------------------------------------------------------------------
     R | link              | link            | link                | link
    --------------------------------------------------------------------------------
     T | isGroup          | isGroup            | isGroup           | -
    --------------------------------------------------------------------------------
     I | vendor              | vendor            | vendor            | vendorName
    --------------------------------------------------------------------------------
     E | name              | name            | name                | name
    --------------------------------------------------------------------------------
     S | prices              | prices            | prices            | prices
    --------------------------------------------------------------------------------
    |  | description      | description        | description        | description
    --------------------------------------------------------------------------------
    |  | facts              | facts            | facts             | -
    --------------------------------------------------------------------------------
    |  | mainPhoto          | mainPhoto        | mainPhoto         | -
    --------------------------------------------------------------------------------
    |  | -                | children        | parentModel       | -
    --------------------------------------------------------------------------------
    |  | -                  | -               | -                 | previewPhotos
    --------------------------------------------------------------------------------
    |  | -                  | -               | -                 | filters
    --------------------------------------------------------------------------------
    |  | -                  | -               | -                 | offers
 */
class MarketModel extends Model
{
    /**
     * Return instance of model according to array structure.
     *
     * @param  array $data
     * @return ModelChild|ModelParent|ModelSingle|ModelVisual|ModelInfo
     */
    public static function getInstance($data = array())
    {
        $className = self::getInstanceClassName($data);

        return new $className($data);
    }

    public static function getInstanceClassName($data = array())
    {
        if (isset($data['children'])|| isset($data['modificationsCount'])) {
            return 'Yandex\Market\Content\Models\ModelParent';
        }

        if (isset($data['parentModel'])) {
            return 'Yandex\Market\Content\Models\ModelChild';
        }

        if (isset($data['offers'])) {
            return 'Yandex\Market\Content\Models\ModelVisual';
        }

        if (isset($data['offerCount']) || isset($data['type'])) {
            return 'Yandex\Market\Content\Models\ModelInfo';
        }

        return 'Yandex\Market\Content\Models\ModelSingle';
    }
}
