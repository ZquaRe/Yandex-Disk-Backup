<?php
/**
 * Author: @mrG1K (mr@g1k.ru)
 */

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class Settings extends Model
{
    /**
     * @var string|null
     */
    protected $shopName = null;

    /**
     * @var int|null
     */
    protected $countryRegion = null;

    /**
     * @var boolean|null
     */
    protected $isOnline = null;

    /**
     * @var boolean|null
     */
    protected $showInContext = null;

    /**
     * @var boolean|null
     */
    protected $showInSnippets = null;

    /**
     * @var boolean|null
     */
    protected $showInPremium = null;

    /**
     * @var boolean|null
     */
    protected $useOpenStat = null;

    /**
     * @return null|string
     */
    public function getShopName()
    {
        return $this->shopName;
    }

    /**
     * @return null|int
     */
    public function getCountryRegion()
    {
        return $this->countryRegion;
    }

    /**
     * @return bool|null
     */
    public function getIsOnline()
    {
        return $this->isOnline;
    }

    /**
     * @return bool|null
     */
    public function getShowInContext()
    {
        return $this->showInContext;
    }

    /**
     * @return bool|null
     */
    public function getShowInSnippets()
    {
        return $this->showInSnippets;
    }

    /**
     * @return bool|null
     */
    public function getShowInPremium()
    {
        return $this->showInPremium;
    }

    /**
     * @return bool|null
     */
    public function getUseOpenStat()
    {
        return $this->useOpenStat;
    }
}
