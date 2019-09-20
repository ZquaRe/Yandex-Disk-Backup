<?php
/**
 * Author: @mrG1K (mr@g1k.ru)
 */

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;
use Yandex\Market\Partner\Models\Settings;

class GetSettingsResponse extends Model
{
    /**
     * @var Settings|null
     */
    protected $settings = null;

    protected $mappingClasses = [
        'settings' => 'Yandex\Market\Partner\Models\Settings'
    ];

    /**
     * @return null|\Yandex\Market\Partner\Models\Settings
     */
    public function getSettings()
    {
        return $this->settings;
    }
}
