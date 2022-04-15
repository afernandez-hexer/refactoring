<?php

namespace App;

class AvailabilityStringToArray
{
    private const HOURS = [
        '8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30',
        '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30',
        '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', 
        '23:00', '23:30'
    ];

    public function transform(string $availability) : array
    {
        $this->throwExceptionIfNotValid($availability);

        $numericArray = $this->transformStringToArrayOfNumbers($availability);

        $result = $this->numericToAvailabilityArray($numericArray);

        return $result;
    }

    private function throwExceptionIfNotValid(string $availability)
    {
        $this->throwExceptionIfHasWrongSize($availability);
        $this->throwExceptionIfHasAnyNotNumberValue($availability);
    }

    private function throwExceptionIfHasWrongSize(string $availability)
    {
        if (strlen($availability) != count(self::HOURS)) {
            $message = sprintf('La cadena de entrada debe tener al menos %s posiciones', count(self::HOURS));

            throw new \RuntimeException($message);
        }
    }

    private function throwExceptionIfHasAnyNotNumberValue(string $availability)
    {
        for ($i=0; $i<strlen($availability); $i++) {
            $character = $availability[$i];

            if (!is_numeric($character)) {
                $message = sprintf('La cadena de entrada debe contener solo números: %s', $character);

                throw new \RuntimeException($message);
            }
        }
    }

    private function transformStringToArrayOfNumbers(string $availability) : array
    {
        $result = [];

        for ($i=0; $i<strlen($availability); $i++) {
            $result[] = (int) $availability[$i];
        }

        return $result;
    }

    private function numericToAvailabilityArray(array $numericArray) : array
    {
        return \array_combine(self::HOURS, $numericArray);
    } 
}