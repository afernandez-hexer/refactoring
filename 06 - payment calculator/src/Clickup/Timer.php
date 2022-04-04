<?php 

namespace App\Clickup;

use App\Entity\User;

class Timer
{
    public function getTimesByUserAndDay(\DateTime $date): array
    {
        //Código ya realizado y testeado
        /**
         * Devuelve un array del tipo
         * [
         *  [
         *     "user_email": rober@domain.com,
         *     "start_date": 2022-01-03 10:03:12,
         *     "end_date": 2022-01-03 10:32:59
         *  ],[
         *     "user_email": rober@domain.com,
         *     "start_date": 2022-01-03 12:12:12,
         *     "end_date": 2022-01-03 14:00:00
         *  ],[
         *     "user_email": amalia@domain.com,
         *     "start_date": 2022-01-03 08:00:00,
         *     "end_date": 2022-01-03 14:00:00
         *  ]
         * ]
         */
    }
}