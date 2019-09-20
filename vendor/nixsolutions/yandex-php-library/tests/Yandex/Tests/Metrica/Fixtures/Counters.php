<?php

namespace Yandex\Tests\Metrica\Fixtures;

class Counters
{
    public static $countersFixtures = [
        "rows" => 2,
        "counters" => [
            [
                "id" => 2215573,
                "owner_login" => "api-metrika",
                "code_status" => "CS_NOT_FOUND",
                "name" => "Демо доступ к API Метрики",
                "site" => "api.yandex.ru",
                "type" => "simple",
                "favorite" => 0,
                "permission" => "own",
                "webvisor" => [
                    "arch_type" => "none",
                    "load_player_type" => "on_your_behalf"
                ],
                "code_options" => [
                    "async" => 1,
                    "informer" => [
                        "enabled" => 1,
                        "type" => "ext",
                        "size" => 3,
                        "indicator" => "pageviews",
                        "color_start" => "FFFFFFFF",
                        "color_end" => "EFEFEFFF",
                        "color_text" => 0,
                        "color_arrow" => 1
                    ],
                    "visor" => 0,
                    "ut" => 0,
                    "track_hash" => 0,
                    "xml_site" => 0,
                    "in_one_line" => 0
                ],
                "partner_id" => 0
            ],
            [
                "id" => 2138128,
                "owner_login" => "help-metrika",
                "code_status" => "CS_NOT_FOUND",
                "name" => "Метрика (help.yandex.ru/metrika/)",
                "site" => "help.yandex.ru",
                "type" => "simple",
                "favorite" => 0,
                "permission" => "view",
                "webvisor" => [
                    "urls" => "",
                    "arch_enabled" => 0,
                    "arch_type" => "none",
                    "load_player_type" => "on_your_behalf"
                ],
                "code_options" => [
                    "async" => 0,
                    "informer" => [
                        "enabled" => 0,
                        "type" => "ext",
                        "size" => 3,
                        "indicator" => "pageviews",
                        "color_start" => "FFFFFFFF",
                        "color_end" => "EFEFEFFF",
                        "color_text" => 0,
                        "color_arrow" => 1
                    ],
                    "visor" => 0,
                    "ut" => 0,
                    "track_hash" => 0,
                    "xml_site" => 0,
                    "in_one_line" => 0
                ],
                "partner_id" => 0
            ]
        ]
    ];
    public static $counterDeleteResponseFixtures = [
        'success' => true
    ];

    public static $counterFixtures = [
        "counter" => [
            "id" => 2215573,
            "owner_login" => "api-metrika",
            "code_status" => "CS_NOT_FOUND",
            "name" => "Демо доступ к API Метрики",
            "site" => "api.yandex.ru",
            "type" => "simple",
            "favorite" => 0,
            "permission" => "own",
            "webvisor" => [
                "arch_type" => "none",
                "load_player_type" => "on_your_behalf"
            ],
            "code_options" => [
                "async" => 1,
                "informer" => [
                    "enabled" => 1,
                    "type" => "ext",
                    "size" => 3,
                    "indicator" => "pageviews",
                    "color_start" => "FFFFFFFF",
                    "color_end" => "EFEFEFFF",
                    "color_text" => 0,
                    "color_arrow" => 1
                ],
                "visor" => 0,
                "ut" => 0,
                "track_hash" => 0,
                "xml_site" => 0,
                "in_one_line" => 0
            ],
            "partner_id" => 0,
            "code" => "<!-- Yandex.Metrika informer -->",
            "monitoring" => [
                "enable_monitoring" => 0,
                "emails" => [
                    ["api-metrika@yandex.ru"]
                ],
                "sms_allowed" => 0,
                "enable_sms" => 0,
                "sms_time" => "9-20;9-20;9-20;9-20;9-20;9-20;9-20"
            ],
            "filter_robots" => 1,
            "time_zone_name" => "Europe/Moscow",
            "visit_threshold" => 1800,
            "max_goals" => 100,
            "max_detailed_goals" => 10,
            "max_retargeting_goals" => 500
        ]
    ];
}
