<?php

namespace App\Functions;

/**
 * Júlio
 */
class StateValidation
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

    public static function replaceState($state): string 
    {
        $states = [
            "AC" => "Acre - AC",
            "AL" => "Alagoas - AL",
            "AP" => "Amapá - AP",
            "AM" => "Amazonas - AM",
            "BA" => "Bahia - BA",
            "CE" => "Ceará - CE",
            "ES" => "Espírito Santo - ES",
            "GO" => "Goiânia - GO",
            "MA" => "Maranhão - MA",
            "MT" => "Mato Grosso - MT",
            "MS" => "Mato Grosso do Sul - MS",
            "MG" => "Minas Gerais - MG",
            "PA" => "Pará - PA",
            "PE" => "Pernambuco - PE",
            "PI" => "Piauí - PI",
            "RJ" => "Rio de Janeiro - RJ",
            "RN" => "Rio Grande do Norte - RN",
            "RS" => "Rio Grande do Sul - RS",
            "RO" => "Rondônia - RO",
            "RR" => "Roraima - RR",
            "SC" => "Santa Catarina - SC",
            "SP" => "São Paulo - SP",
            "SE" => "Sergipe - SE",
            "TO" => "Tocantins - TO",
            "" => "Selecione um estado"
        ];
        return $states[$state];
    }
}
