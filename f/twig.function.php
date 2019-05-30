<?php
  

/**
 * работа с секретами
 */

//creatSecret
$function = new Twig_SimpleFunction('creatSecret', function ( string $text ) {
    
    return \Nyos\Nyos::creatSecret($text);
    
        //return md5('wwdv' . $text . date('ymd', $_SERVER['REQUEST_TIME']));
        
    });
$twig->addFunction($function);

//checkSecret
$function = new Twig_SimpleFunction('checkSecret', function ( string $secret, string $text) {
    
        return \Nyos\Nyos::checkSecret($secret, $text);
    
//        if ($secret == md5('wwdv' . $text . date('ymd', $_SERVER['REQUEST_TIME']))) {
//            return true;
//        } else {
//            return false;
//        }

    });
$twig->addFunction($function);


/**
 * Пример использования
 */
/*
    {% set ss = creatSecret(123456) %}
    <br/>
    {{ ss }}
    <br/>
    {% if checkSecret(ss,123456) == true %}
    111
    {% else %}
    222
    {% endif %}
*/