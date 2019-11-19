<?php

/**
  определение функций для TWIG
 */
//creatSecret
// $function = new Twig_SimpleFunction('creatSecret', function ( string $text ) {
//    return \Nyos\Nyos::creatSecret($text);
// });
// $twig->addFunction($function);


$function = new Twig_SimpleFunction('http_build_query', function ( array $ar ) {
    return http_build_query($ar);
});
$twig->addFunction($function);
