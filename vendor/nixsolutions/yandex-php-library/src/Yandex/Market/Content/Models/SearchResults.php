<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;
use Yandex\Market\Content\Models\Base\MarketModel;

class SearchResults extends ObjectModel
{
    /**
     * Add category to collection
     *
     * @param ModelParent|ModelChild|ModelVisual|ModelSingle|ModelInfo|Offer|array $searchResult
     *
     * @return SearchResults
     */
    public function add($searchResult)
    {
        if (is_array($searchResult)) {
            if (isset($searchResult['model'])) {
                $this->collection[] = MarketModel::getInstance($searchResult['model']);
            }

            if (isset($searchResult['offer'])) {
                $this->collection[] = new Offer($searchResult['offer']);
            }
        } elseif (is_object($searchResult) && ($searchResult instanceof MarketModel || $searchResult instanceof Offer)
        ) {
            $this->collection[] = $searchResult;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return SearchResults|null
     */
    public function getAll()
    {
        return $this->collection;
    }
}
