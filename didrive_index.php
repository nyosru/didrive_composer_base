<?php

// через этот файл идут все обращения в дидрайв http

if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
    $sm = 0;
}

if ($_SERVER['HTTP_HOST'] == 'photo.uralweb.info' || $_SERVER['HTTP_HOST'] == 'adomik.dev.uralweb.info' || $_SERVER['HTTP_HOST'] == 'yapdomik.uralweb.info' || $_SERVER['HTTP_HOST'] == 'a2.uralweb.info' || $_SERVER['HTTP_HOST'] == 'adomik.uralweb.info'
) {
    date_default_timezone_set("Asia/Omsk");
} else {
    date_default_timezone_set("Asia/Yekaterinburg");
}

if (
        strpos($_SERVER['HTTP_HOST'], 'dev.') !== false ||
        $_SERVER['HTTP_HOST'] == 'yapdomik.uralweb.info' ||
        $_SERVER['HTTP_HOST'] == 'adomik.uralweb.info'
) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}




define('IN_NYOS_PROJECT', TRUE);
define('DS', DIRECTORY_SEPARATOR);

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php'))
    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';





try {

    ob_start('ob_gzhandler');

    /**
     * корень сервера /all/
     */
    define('DirAll', $_SERVER['DOCUMENT_ROOT'] . DS . 'all' . DS);

// массив с переменными
    $vv = array(
        // 'sdd' => '/didrive/design/',
        'sdd' => '/vendor/didrive/base/design/design/',
        'body_end' => '',
        'folder' => '',
        'warn' => '',
        'host' => $_SERVER['HTTP_HOST'],
//        'get' => $_GET,
//        'server' => $_SERVER,
//        'post' => $_POST,
        'rand' => rand(1000, 9999)
    );

// \f\timer_start(78);

    require_once($_SERVER['DOCUMENT_ROOT'] . '/all/0.start.php');

// \f\pa(\f\timer_stop(78));


    $vv['db'] = $db;

    if (file_exists(DR . dir_site . 'config.php'))
        require( DR . dir_site . 'config.php');

    if (isset($_SESSION['now_user_di']['soc_web_id']{1}) && !isset($_SESSION['now_user_di']['uid'])) {
        $_SESSION['now_user_di']['uid'] = $_SESSION['now_user_di']['soc_web_id'];
    }

    \Nyos\Nyos::getFolder();

    $loader = new Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT']);

// инициализируем Twig
    $twig = new Twig_Environment($loader, array(
        'cache' => $_SERVER['DOCUMENT_ROOT'] . '/templates_c',
        //'cache' => false,
        'auto_reload' => true
//        ,
//        'debug' => true
    ));

// только для отладки
    if (strpos($_SERVER['HTTP_HOST'], 'dev') !== false) {
        $twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    /**
     * если нет входа то показываем ошибку или страницу входа
     * если есть то проходим дальше без редиректа
     */
    $enter_didrive = \Didrive\AUT::enterDidrive($db);

    // если входа не произведено
    if (empty($_SESSION['now_user_di']['id'])) {
        if (isset($enter_didrive['status']) && $enter_didrive['status'] === 'error') {

            $vv['id_app'] = \Didrive\AUT::$vk_app_id;
            $vv['url_script'] = 'https://' . $_SERVER['HTTP_HOST'] . '/i.didrive.php'; //ссылка на скрипт auth_vk.php
            $vv['vk_api_url'] = '<a href="https://oauth.vk.com/authorize?client_id=' . \Didrive\AUT::$vk_app_id . '&redirect_uri=' . $vv['url_script'] . '&response_type=code" >Войти через ВК</a></p>';

            $ttwig = $twig->loadTemplate(\f\like_tpl('enter', $vv['sdd'] . '../tpl/', dir_site_tpldidr, DR));
            die($ttwig->render($vv));
        }
        die('что то пошло не так, обновите страницу и попробуйте ещё раз');
    }






    $twig->addGlobal('session', $_SESSION);
    $twig->addGlobal('server', $_SERVER);
    $twig->addGlobal('post', $_POST);
    $twig->addGlobal('get', $_GET);

    
    


    

    // если зашли

    try {

        require_once __DIR__.'/didrive_enter.php';

//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                // $sm = 0;
//                $sm2 = 0;
//                $sm2 = memory_get_usage();
//                echo '<br/>xxx' . __LINE__ . ' - ' . round(( $sm2 - $sm ) / 1024 / 1024, 2);
//                // \f\timer::start(99);
//                //echo '<br/>timer '.\f\timer::stop('str', 99);
//
//                \f\pa($_SESSION);
//
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }
    } catch (\NyosEx $ex) {

//\f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => $ex->getMessage() ));
        $vv['warn'] = 'Произошла ошибка <pre> '
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString() . '</pre>';
    } catch (\PDOException $ex) {

//\f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => $ex->getMessage() ));
        $vv['warn'] = 'Произошла ошибка PDO <pre> '
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString() . '</pre>';

        if (strpos($ex->getMessage(), 'no such table: gm_user_di_mod') !== false) {
            $vv['warn'] .= PHP_EOL . 'создаём таблицу gm_user_di_mod';
            \Nyos\Mod\lk::creatTable($db, 'gm_user_di_mod');
        }
    } catch (\Exception $ex) {

//\f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => $ex->getMessage() ));
        $vv['warn'] = 'Произошла ошибка <pre> '
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString() . '</pre>';
    } catch (\ErrorException $ex) {

//\f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => $ex->getMessage() ));
        $vv['warn'] = 'Произошла ошибка <pre> '
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString() . '</pre>';
    } catch (\Error $ex) {

//\f\redirect('/', 'i.didrive.php', array('rand' => rand(0, 100), 'warn' => $ex->getMessage() ));
        $vv['warn'] = 'Произошла ошибка <pre> '
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString() . '</pre>';
    }






    if (file_exists(DR . DS . 'vendor' . DS . 'didrive' . DS . 'base' . DS . 'js.js')) {
// $vv['in_body_end'][] = '<script src="' . DS . 'vendor' . DS . 'didrive' . DS . 'base' . DS . 'js.js"></script>';
        if (empty($vv['in_body_end'])) {
            $vv['in_body_end'][] = '<script src="' . DS . 'vendor' . DS . 'didrive' . DS . 'base' . DS . 'js.js"></script>';
        } else {
            array_unshift($vv['in_body_end'], '<script src="' . DS . 'vendor' . DS . 'didrive' . DS . 'base' . DS . 'js.js"></script>');
        }
    }

    if (file_exists(DR . DS . 'vendor' . DS . 'didrive' . DS . 'base' . DS . 'design' . DS . 'js.js')) {
// $vv['in_body_end'][] = '<script src="/didrive/js.js"></script>';
        array_unshift($vv['in_body_end'], '<script src="/vendor/didrive/base/design/js.js"></script>');
    }

//$vv['in_body_end'][] = '<script src="' . DS . 'vendor' . DS . 'didrive' . DS . 'base' . DS . 'js.js"></script>';
// \f\pa( $vv['in_body_end'] );

    /**
     * обработка шаблона и вывод
     */
//foreach ($vv as $k => $v) {
//    $smarty->assign($k, $v);
//}
// $t = \f\like_tpl('didrive', $_SERVER['DOCUMENT_ROOT'] . '/didrive/tpl/', $_SERVER['DOCUMENT_ROOT'] . $vv['sdd']);
// $smarty->display($t);
//if (strpos($_SERVER['HTTP_HOST'], 'acms') || strpos($_SERVER['HTTP_HOST'], '.a2') || strpos($_SERVER['HTTP_HOST'], '.aa')) {
//    require( $_SERVER['DOCUMENT_ROOT'] . '/0.all/inf.post.php' );
//}

    if (1 == 1 && isset($vv['ckeditor_in']) && sizeof($vv['ckeditor_in']) > 0) {

// \f\pa($vv['ckeditor_in']);
        $vv['in_body_end']['/js/ckeditor.4.5.11/ckeditor.js'] = '<script type="text/javascript" charset="utf-8" src="/js/ckeditor.4.5.11/ckeditor.js"></script>';

        foreach ($vv['ckeditor_in'] as $k => $v) {
            if (isset($v['type']) && $v['type'] == 'mini') {
                $vv['in_body_end'][] = '<script  type="text/javascript" charset="utf-8"  >'
                        . ' CKEDITOR.replace(\'' . addslashes($k) . '\', { toolbar: [ '
                        . ' { name: "clipboard", groups: [ "clipboard", "undo" ], items: [ "Cut", "Copy", "PasteText", "-", "Undo", "Redo" ] }, '
                        . ' { name: "colors", items: [ "TextColor", "BGColor" ] }, '
                        . ' { name: "basicstyles", groups: [ "basicstyles", "cleanup" ], items: [ "Bold", "Italic", "Underline", "-", "RemoveFormat" ] }, '
                        . ' { name: "paragraph", groups: [ "list", "indent", "align" ], items: [ "NumberedList", "BulletedList" ] } '
                        . ' ] } ); </script>';
            } elseif (isset($v['type']) && $v['type'] == 'mini.img') {
                $vv['in_body_end'][] = '<script  type="text/javascript" charset="utf-8"  >'
                        . ' CKEDITOR.replace(\'' . addslashes($k) . '\', { toolbar: [ '
                        . ' { name: "clipboard", groups: [ "clipboard", "undo" ], items: [ "Cut", "Copy", "PasteText", "-", "Undo", "Redo" ] }, '
                        . ' { name: "colors", items: [ "TextColor", "BGColor" ] }, '
                        . ' { name: "basicstyles", groups: [ "basicstyles", "cleanup" ], items: [ "Bold", "Italic", "Underline", "-", "RemoveFormat" ] }, '
                        . ' { name: "paragraph", groups: [ "list", "indent", "align" ], items: [ "NumberedList", "BulletedList" ] }, '
                        . ' { name: "insert", items: [ "Image", "Flash", "Table", "HorizontalRule", "Smiley", "SpecialChar", "PageBreak", "Iframe" ] } '
                        . ' ] } ); </script>';
// } elseif (isset($v['type']) && $v['type'] == 'full') {
            } else {
                $vv['in_body_end'][] = '<script  type="text/javascript" charset="utf-8"  >'
                        . ' CKEDITOR.replace(\'' . addslashes($k) . '\', { toolbar: [ '
                        . ' { name: "document", groups: ["mode", "document", "doctools"], items: [\'Source\', \'Maximize\', \'ShowBlocks\', \'Templates\'] }, '
                        . ' { name: "clipboard", groups: ["clipboard", "undo"], items: [\'Cut\', \'Copy\', \'Paste\', \'PasteText\', \'PasteFromWord\', \'-\', \'Undo\', \'Redo\'] }, '
                        . ' { name: "clipboard", groups: [ "clipboard", "undo" ], items: [ "Cut", "Copy", "PasteText", "-", "Undo", "Redo" ] }, '
                        . ' { name: \'editing\', groups: [\'find\', \'selection\', \'spellchecker\'], items: [\'Find\', \'Replace\', \'-\', \'SelectAll\', \'-\', \'Scayt\'] }, '
                        . ' { name: "colors", items: [ "TextColor", "BGColor" ] }, '
                        . ' { name: "basicstyles", groups: [ "basicstyles", "cleanup" ], items: [ "Bold", "Italic", "Underline", "Strike", "Subscript", "Superscript", "-", "RemoveFormat" ] }, '
                        . ' { name: "basicstyles", groups: [ "basicstyles", "cleanup" ], items: [ "Bold", "Italic", "Underline", "-", "RemoveFormat" ] }, '
                        . ' { name: "paragraph", groups: [ "list", "indent", "blocks", "align", "bidi" ], items: [ "NumberedList", "BulletedList", "-", "Outdent", "Indent", "-", "Blockquote", "CreateDiv", "-", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock" ] }, '
                        . ' { name: "paragraph", groups: [ "list", "indent", "align" ], items: [ "NumberedList", "BulletedList" ] }, '
                        . ' { name: "links", items: [ "Link", "Unlink" ] }, '
                        . ' { name: "insert", items: [ "Image", "Flash", "Table", "HorizontalRule", "Smiley", "SpecialChar", "PageBreak", "Iframe" ] }, '
                        . ' { name: "styles", items: [ "Styles", "Format", "Font", "FontSize" ] } '
                        . ' ] } ); </script>';
            }
        }
    }

// $ttwig = $twig->loadTemplate( 'module/' . $vv['level'] . '/tpl/page.txt.data.htm');
// $ttwig = $twig->loadTemplate( 'module/' . $vv['level'] . '/tpl/sqlmod.item.htm');
//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                // $sm = 0;
//                $sm2 = 0;
//                $sm2 = memory_get_usage();
//                echo '<br/>xxx' . __LINE__ . ' - ' . round(( $sm2 - $sm ) / 1024 / 1024, 2);
//                // \f\timer::start(99);
//                // echo '<br/>timer '.\f\timer::stop('str', 99);
//                // \f\pa($_SESSION);
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }




    require DR . '/all/twig.function.php';

    $vv['a_menu'] = \Nyos\Nyos::$a_menu;
//\f\pa($vv['a_menu']);


//    $twig->addGlobal('session', $_SESSION);
//    $twig->addGlobal('server', $_SERVER);
//    $twig->addGlobal('post', $_POST);
//    $twig->addGlobal('get', $_GET);


//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                // $sm = 0;
//                $sm2 = 0;
//                $sm2 = memory_get_usage();
//                echo '<br/>xxx' . __LINE__ . ' - ' . round(( $sm2 - $sm ) / 1024 / 1024, 2);
//                // \f\timer::start(99);
//                // echo '<br/>timer '.\f\timer::stop('str', 99);
//                // \f\pa($_SESSION);
//                // die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }

    $ttwig = $twig->loadTemplate($tpl_print_end ?? 'vendor/didrive/base/design/tpl/didrive.htm');


// \f\timer_start(331);
    echo $ttwig->render($vv);
// \f\pa( 'печать в твиг '.\f\timer_stop(331));
//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                // $sm = 0;
//                $sm2 = 0;
//                $sm2 = memory_get_usage();
//                echo '<br/>xxx' . __LINE__ . ' - ' . round(( $sm2 - $sm ) / 1024 / 1024, 2);
//                // \f\timer::start(99);
//                // echo '<br/>timer '.\f\timer::stop('str', 99);
//                // \f\pa($_SESSION);
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }
//echo '<br/>'.__FILE__.' ['.__LINE__.']';

    $r = ob_get_contents();
    ob_end_clean();


// \f\timer_start(781);
//            if ($_SERVER['HTTP_HOST'] == 'adomik.uralweb.info') {
//                // $sm = 0;
//                $sm2 = 0;
//                $sm2 = memory_get_usage();
//                echo '<br/>xxx' . __LINE__ . ' - ' . round(( $sm2 - $sm ) / 1024 / 1024, 2);
//                // \f\timer::start(99);
//                // echo '<br/>timer '.\f\timer::stop('str', 99);
//                // \f\pa($_SESSION);
//                die('<br/>' . __FILE__ . ' ' . __LINE__);
//            }

    $r22 = $r23 = array();

// \f\pa($vv['in_body_end'],'','','in_body_end');
//                $r22 = $r23 = array();

    $body_end_str = $body_start_str = '';

    if (isset($vv['dihead']{3})) {
        $body_start_str .= $vv['dihead'];
    }

    if (isset($body_start_str{1})) {
        $r22[] = '</head>';
        $r23[] = $body_start_str . '</head>';
    }



    if (isset($vv['in_body_end']) && sizeof($vv['in_body_end']) > 0) {

        $t = '';

        foreach ($vv['in_body_end'] as $k => $v) {
            $t .= $v;
        }

        $r22[] = '</body>';
        $r23[] = $t . '</body>';
    }

    $startMemory = 0;
    $startMemory = memory_get_usage();
    $r22[] = ' =memory_usage= ';
    $r23[] = round($startMemory / 1024 / 1024, 2);
// echo '<br/>xxx'.__LINE__.' - '.round($startMemory/1024/1024,2);
// \f\timer_start(33);

    if (!empty($r22))
        $r = str_replace($r22, $r23, $r);

// \f\pa( 'замена в body '.\f\timer_stop(33));
// \f\pa(\f\timer_stop(781));


    die($r);

//    require_once( $_SERVER['DOCUMENT_ROOT'] . '/all/inf.post.php' );
//    die($r);
//    exit;
}
//
catch (\NyosEx $ex) {

    $text1 = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . '</pre>';

    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';

    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text1, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/template/body_error.htm')));
}
//
catch (\EngineException $ex) {

    $text1 = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . '</pre>';
    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';
// echo __FILE__;
    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text1, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/template/body_error.htm')));
}
//
catch (\PDOException $ex) {


    $text1 = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . '</pre>';
    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';
// echo __FILE__;
    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text1, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/template/body_error.htm')));
}
//
catch (\Exception $ex) {

    $text1 = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . '</pre>';
    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';
// echo __FILE__;
    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text1, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/template/body_error.htm')));
}
//
catch (\Throwable $ex) {

    $text = '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
            . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
            . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
            . PHP_EOL . $ex->getTraceAsString()
            . '</pre>';

    if (class_exists('\nyos\Msg'))
        \nyos\Msg::sendTelegramm($text, null, 1);

    die(str_replace('{text}', $text, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/template/body_error.htm')));
}