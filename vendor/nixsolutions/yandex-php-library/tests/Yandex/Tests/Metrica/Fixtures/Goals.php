<?php

namespace Yandex\Tests\Metrica\Fixtures;

class Goals
{
    public static $goalsFixtures = [
        "goals" => [
            0 => [
                "id" => 334420,
                "name" => "Хорошо просмотрел сайт",
                "type" => "number",
                "depth" => 8,
                "class" => 1
            ],
            1 => [
                "id" => 334423,
                "name" => "Корзина",
                "type" => "url",
                "flag" => "basket",
                "conditions" => [
                    0 => [
                        "type" => "contain",
                        "url" => "/basket.php?add"
                    ]
                ],
                "class" => 1
            ]
        ]
    ];

    public static $goalFixtures = [
        "goal" => [
            "id" => 334423,
            "name" => "Корзина",
            "type" => "url",
            "flag" => "basket",
            "conditions" => [
                0 => [
                    "type" => "contain",
                    "url" => "/basket.php?add"
                ]
            ],
            "class" => 1
        ]
    ];
    public static $deleteResponseFixtures = [
        'success' => true
    ];
}
