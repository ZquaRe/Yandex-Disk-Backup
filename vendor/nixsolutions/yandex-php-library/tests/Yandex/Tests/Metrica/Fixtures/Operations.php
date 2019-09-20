<?php

namespace Yandex\Tests\Metrica\Fixtures;

class Operations
{
    public static $operationsFixtures = [
        "operations" => [
            0 => [
                "id" => 66955,
                "action" => "cut_parameter",
                "attr" => "url",
                "value" => "debug",
                "status" => "active"
            ],
            1 => [
                "id" => 66958,
                "action" => "merge_https_and_http",
                "attr" => "url",
                "value" => "",
                "status" => "active"
            ]
        ]
    ];

    public static $operationFixtures = [
        "operation" => [
            "id" => 66955,
            "action" => "cut_parameter",
            "attr" => "url",
            "value" => "debug",
            "status" => "active"
        ]
    ];
    public static $deleteResponseFixtures = [
        'success' => true
    ];
}
