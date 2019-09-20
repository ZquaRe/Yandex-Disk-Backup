<?php
namespace Yandex\Tests\Metrica\Fixtures;

class Filters
{
    public static $filtersFixtures = [
        "filters" => [
            0 => [
                "id" => 66928,
                "attr" => "title",
                "type" => "start",
                "value" => "Администрирование::",
                "action" => "exclude",
                "status" => "active"
            ],
            1 => [
                "id" => 66940,
                "attr" => "uniq_id",
                "type" => "me",
                "value" => "",
                "action" => "exclude",
                "status" => "active"
            ]
        ]
    ];

    public static $filterFixtures = [
        "filter" => [
            "id" => 66943,
            "attr" => "client_ip",
            "type" => "interval",
            "value" => "192.168.0.0/24",
            "action" => "exclude",
            "status" => "active",
            "start_ip" => "192.168.0.0",
            "end_ip" => "192.168.0.255"
        ]
    ];
    public static $deleteResponseFixtures = [
        'success' => true
    ];
}
