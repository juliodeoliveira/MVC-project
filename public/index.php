<?php
// TODO: Para esse projeto, como ele não especificou nenhum tema, vou criar uma concessionária, onde vende apenas carros da ficção
// TODO: ou loja de planetas.
// Até agora, nenhuma api, carro ou planetas, fornece imagens, então vou usar uma api do google imagens para pesquisar
// api google imagens: https://www.searchapi.io/docs/google-images (filtrar por tamanho é possível aqui)
// api de planetas: https://api-ninjas.com/api/planets
// api de carros: https://www.carqueryapi.com/, https://deividfortuna.github.io/fipe/, https://docs.carsxe.com/vehicle-images
// api 
//
//
//
//
//
//
//
//
//
//
//
//

require "../bootstrap.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use core\Controller;
use core\Method;
use core\Parameters;

try {
    $controller = new Controller;
    $controller = $controller -> load();
    // dd($controller);
    
    $method = new Method;
    $method = $method->load($controller);

    $parameters = new Parameters;
    $parameters = $parameters->load();

    $controller -> $method($parameters);

} catch (\Exception $e) {
    dd($e -> getMessage());
}


// $method = new Method;
// $method = $method -> getMethod();

// $parameters = new Parameters;
// $parameters -> getParamethers();

// $controller -> $method($parameters);