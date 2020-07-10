<?php

/**
  определение функций для TWIG
 */
//creatSecret
// $function = new Twig_SimpleFunction('creatSecret', function ( string $text ) {
//    return \Nyos\Nyos::creatSecret($text);
// });
// $twig->addFunction($function);

$function = new Twig_SimpleFunction('di__sort_sort', function ( $ar ) {
    usort($ar, "\\f\\sort_ar_sort");
    return $ar;
});
$twig->addFunction($function);

