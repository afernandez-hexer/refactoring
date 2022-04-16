<?php

namespace App\Tests\Clickup;

use App\Clickup\Timer;

class FakeTimer extends Timer
{
    private $periods = [];

    public function getTimesByUserAndDay(\DateTime $date): array
    {
        return isset($this->periods[$date->format('Y-m-d')])
            ? $this->periods[$date->format('Y-m-d')]
            : []
        ;
    }

    public function __construct()
    {
        $this->periods['2022-01-01'] = [
            [
                "user_email" => "rober@domain.com",
                "start_date" => "2022-01-01 08:03:12",
                "end_date" => "2022-01-01 14:06:59",
            ],[
                "user_email" => "amalia@domain.com",
                "start_date" => "2022-01-01 07:00:12",
                "end_date" => "2022-01-01 15:00:00",
            ]
        ];

        $this->periods['2022-01-02'] = [
            [
                "user_email" => "rober@domain.com",
                "start_date" => "2022-01-02 08:03:12",
                "end_date" => "2022-01-02 14:06:59",
            ],[
                "user_email" => "amalia@domain.com",
                "start_date" => "2022-01-02 07:00:12",
                "end_date" => "2022-01-02 15:00:00",
            ]
        ];

        $this->periods['2022-01-03'] = [
            [
                "user_email" => "rober@domain.com",
                "start_date" => "2022-01-03 10:03:12",
                "end_date" => "2022-01-03 10:32:59",
            ],[
                "user_email" => "rober@domain.com",
                "start_date" => "2022-01-03 12:12:12",
                "end_date" => "2022-01-03 14:00:00",
            ],[
                "user_email" => "amalia@domain.com",
                "start_date" => "2022-01-03 08:00:00",
                "end_date" => "2022-01-03 14:00:00",
            ],[
                "user_email" => "amalia@domain.com",
                "start_date" => "2022-01-03 16:00:00",
                "end_date" => "2022-01-03 22:00:00",
            ]
        ];
    }
}