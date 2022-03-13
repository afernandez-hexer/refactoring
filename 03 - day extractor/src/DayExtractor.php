<?php

namespace App;

/**
 * Clase encarga de extraer los días entre dos fechas
 */
class DayExtractor
{
    /**
     * Calcula las fechas entre dos
     *
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    public function extract(\DateTime $start, \DateTime $end) : array
    {
        $result = [];

        $limit = clone $start;

        while ($limit <= $end) {
            $result[] = clone $limit;

            $limit->add(new \DateInterval('P1D'));
        };

        return $result;
    }
}