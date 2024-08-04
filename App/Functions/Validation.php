<?php

namespace App\Functions;

/**
 * Júlio
 */
class Validation
{
    public static function validate($value)
    {
        $states = [
            "AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", 
            "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", 
            "RS", "RO", "RR", "SC", "SP", "SE", "TO"
        ];

        foreach ($states as $abbreviation) {
            if ($abbreviation == $value) {
                return true;
            }
        }
        return false;
    }
}
