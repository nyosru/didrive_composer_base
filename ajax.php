<?php

ini_set('display_errors', 'On'); // сообщения с ошибками будут показываться
error_reporting(E_ALL); // E_ALL - отображаем ВСЕ ошибки

date_default_timezone_set("Asia/Yekaterinburg");
define('IN_NYOS_PROJECT', true);

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require( $_SERVER['DOCUMENT_ROOT'] . '/all/ajax.start.php' );

// \f\pa($_REQUEST);


// проверяем секрет
if (
// $_REQUEST['action'] == 'edit_items_dop' 
        (
        isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit_items_dop' 
        && !empty($_REQUEST['item_id']) && !empty($_REQUEST['dop_pole']) && !empty($_REQUEST['s']) 
        && \Nyos\Nyos::checkSecret( $_REQUEST['s'], $_REQUEST['item_id'] . $_REQUEST['dop_pole'] ) !== false
        )
        
) { }
//
else {
    \f\end2('Произошла неописуемая ситуация #' . __LINE__ . ' обратитесь к администратору ' // . $_REQUEST['id'] . ' && ' . $_REQUEST['secret']
            , false );
}

// изменяем доп параметр в items
if( isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit_items_dop' ){
    
    \Nyos\mod\items::saveNewDop($db, [ $_REQUEST['item_id'] => [ $_REQUEST['dop_pole'] => $_REQUEST['val'] ] ] );
    
    \f\end2( 'Изменения сохранены' , true );
}

\f\end2( 'The end' , false );







