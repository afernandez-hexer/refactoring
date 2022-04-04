<?php

namespace App\Repository;

interface UserRepository
{
    /**
     * Devuelve un array de los usuarios que han trabajado en una fecha concreta
     *
     * @return array
     */
    public function findWhoWorkedIn(\DateTime $date) : array;
}