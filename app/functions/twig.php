<?php
use Twig\TwigFunction;
$this->functions[] = $this->functionsToView('user', function(){
    return "user data";
});

$this->functions[] = $this->functionsToView('teste', function(){
    return "Isso é um teste!";
});