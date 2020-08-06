<?php

ini_set('display_errors', 'On'); // сообщения с ошибками будут показываться
error_reporting(E_ALL); // E_ALL - отображаем ВСЕ ошибки

date_default_timezone_set("Asia/Yekaterinburg");
define('IN_NYOS_PROJECT', true);


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require( $_SERVER['DOCUMENT_ROOT'] . '/all/ajax.start.php' );



//\f\pa($_REQUEST);
//
//\f\pa($_SERVER);
//
//$e = parse_url($_SERVER['REQUEST_URI']);
//\f\pa($e);


        
        $vv['id_app'] = 7171647; //Айди приложения
        $vv['url_script'] = 'https://api.uralweb.info/didrive/aut_vk/--'.$_SERVER['HTTP_HOST'].'--/'; //ссылка на скрипт auth_vk.php
        $vv['vk_api_url'] = '<a href="https://oauth.vk.com/authorize?client_id=' . $vv['id_app'] . '&redirect_uri=' . $vv['url_script'] . '&response_type=code" >Войти через ВК</a></p>';

// после клика по ссылке "войти через вк" отправили запрос и нам пришёл код .. из которого надо достать данные (используем id)

        if (!empty($_GET['code'])) {

            $id_app = $vv['id_app']; //Айди приложения
            $secret_app = 'srJxX0eTaPnGIEnTcCfJ'; // Защищённый ключ. Можно узнать там же где и айди
            $url_script = $vv['url_script']; //ссылка на этот скрипт
            
            $token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id=' . $id_app . '&client_secret=' . $secret_app . '&code=' . $_GET['code'] 
                    . '&redirect_uri=' . $url_script 
                    ), true);
            
            \f\pa($token);
            
            $fields = 'first_name,last_name,photo_200_orig';

            
            
            // $fields = 'photo_id, verified, sex, bdate, city, country, home_town, has_photo, photo_50, photo_100, photo_200_orig, photo_200, photo_400_orig, photo_max, photo_max_orig, online, domain, has_mobile, contacts, site, education, universities, schools, status, last_seen, followers_count, common_count, occupation, nickname, relatives, relation, personal, connections, exports, activities, interests, music, movies, tv, books, games, about, quotes, can_post, can_see_all_posts, can_see_audio, can_write_private_message, can_send_friend_request, is_favorite, is_hidden_from_feed, timezone, screen_name, maiden_name, crop_photo, is_friend, friend_status, career, military, blacklisted, blacklisted_by_me, can_be_invited_group';
            // $fields = 'photo_id, sex, bdate, city, country, home_town, has_photo, photo_50, photo_100, photo_200, contacts, status, followers_count, common_count, occupation, nickname, timezone';

            $uinf = json_decode(file_get_contents('https://api.vk.com/method/users.get?uids=' . $token['user_id'] . '&fields=' . $fields . '&access_token=' . $token['access_token'] . '&v=5.80'), true);

            \f\pa($uinf);
            
            if( !empty( $uinf['response'][0]['id'] ) )
            \f\pa($uinf['response'][0]['id'] );
            
            exit;
            
            // \f\pa($uinf);
//            $_SESSION['name'] = $uinf['response'][0]['first_name'];
//            $_SESSION['name_family'] = $uinf['response'][0]['last_name'];
//            $_SESSION['uid'] = $token['user_id'];
//            $_SESSION['access_token'] = $token['access_token'];

            \Nyos\mod\Lk::$type = 'now_user_di';

            if (!empty($uinf['response'][0]['id'])) {
                $_SESSION[\Nyos\mod\Lk::$type] = \Nyos\Mod\Lk::enter($db, $uinf['response'][0]['id']);

                \nyos\Msg::sendTelegramm('Вход в управление с ВК' . PHP_EOL
                        . implode('+', $uinf['response'][0])
                        , null, 2);

                // если это я
                if ($uinf['response'][0]['id'] == '5903492')
                    $_SESSION[\Nyos\mod\Lk::$type]['access'] = 'admin';
            }

            // die();
//            header("Location: /i.didrive.php");
        }






exit;

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







