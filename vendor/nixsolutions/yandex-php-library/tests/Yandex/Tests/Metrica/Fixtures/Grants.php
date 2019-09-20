<?php

namespace Yandex\Tests\Metrica\Fixtures;

class Grants
{
    public static $grantsFixtures = [
        "grants" => [
            0 => [
                "user_login" => "api-metrika2",
                "perm" => "view",
                "created_at" => "2010-12-08 20:02:01",
                "comment" => ""
            ],
            1 => [
                "user_login" => "",
                "perm" => "public_stat",
                "created_at" => "2010-12-08 20:02:01",
                "comment" => ""
            ]
        ]
    ];

    public static $grantFixtures = [
        "grant" => [
            "user_login" => "api-metrika2",
            "perm" => "view",
            "created_at" => "2010-12-08 20:02:01",
            "comment" => ""
        ]
    ];
    public static $deleteResponseFixtures = [
        'success' => true
    ];
}
