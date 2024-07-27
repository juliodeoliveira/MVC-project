<?php

namespace App\Functions;

class DatabaseTreat {
    public static function fieldName($fieldName, $fieldValue): string | null
    {
        $fields = [
            "phone_number" => "Número de telefone: ",
            "cep" => "CEP: ",
            "street" => "Rua: ",
            "house_number" => "Nº da casa: ", 
            "complement " => "Complemento: ",
            "neighborhood" => "Bairro: ",
            "city" => "Cidade: ",
            "state" => "Estado: ",
            "created_at" => "Criado em: "
        ];

        if ($fieldName == "id") {
            return null;
        }
        elseif ($fieldName == "enterprise_name") {
            return "<h1>Nome da empresa: $fieldValue</h1>";
        }
        elseif($fieldName == "email"){
            return "<h1>E-mail da empresa: $fieldValue</h1>";
        }
        elseif(empty($fieldValue)) {
            return "<li>N/A";
        }else {
            return "<li>$fields[$fieldName] $fieldValue";
        }
    }
}
