<?php

// echo '<pre>'; print_r( $_REQUEST ); echo '</pre>'; exit;

date_default_timezone_set("Asia/Yekaterinburg");
// header("Cache-control: public");
$status = '';

require($_SERVER['DOCUMENT_ROOT'] . '/0.site/0.start.php');

//
if (isset($_REQUEST['uri']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $_REQUEST['uri'])) {

    //$e = parse_url($_REQUEST['uri']);
    $e = pathinfo($_REQUEST['uri']);

    // echo '<pre>'; print_r($e); echo '</pre>'; exit;
    // $_dir1 = '9.site/' . $now['folder'] . '/download/';
    $_dir1 = substr($e['dirname'], 1, 500) . '/';
    $_file1 = $e['basename'];
}

//
else {

//echo '<pre>'; print_r($now); echo '</pre>';
//echo $status;
// echo DirSite.'template'.DS.'body.htm';
// если определена папка
    if (isset($now['folder']{0}) && is_dir(DirSite)) {
//echo '<pre>'; print_r($_REQUEST); echo '</pre>'; // exit;
//echo '<pre>'; print_r($now); echo '</pre>'; exit;
// require_once($_SERVER['DOCUMENT_ROOT'].'/index.cfg.start.php');
//echo '<pre>'; print_r($_glob); echo '</pre>';
//define( 'DirSite', Dir.'9.site/'.$_glob['login'].'/'.$_glob['folder'].'/' );
// на выходе $domen_info
//	if( is_file($_SERVER['DOCUMENT_ROOT'].'/index.cfg.php') )
//	include($_SERVER['DOCUMENT_ROOT'].'/index.cfg.php');

        $_dir1 = '9.site/' . $now['folder'] . '/download/';
        $_file1 = str_replace('\\', '/', $_GET['uri']);

//    $a1 = $a2 = array();
//    $a1[] = '/';
//    $a2 = '';
//    $a1[] = '\\';
//    $a2 = '';
//
//    $_file2 = str_replace($a1, $a2, $_file1);
        $_file2 = $_file1;

        if( !defined('DirSite') ){
        define('DirSite', $_SERVER['DOCUMENT_ROOT'] . '/9.site/' . $now['folder']);
        }
        
        if( !defined('DS') ){
        define('DS', DIRECTORY_SEPARATOR);
        }
        
    }
}

if (strpos($_REQUEST['uri'], '.jpg')) {
    header("Content-type: image/jpeg");
}



//echo 'dir1 > '.$_dir1.' file1 - '.$_file1; exit;

if (1 == 1) {

// если есть картинка по ссылке
    if (isset($_dir1) && isset($_file1) &&
            file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $_dir1 . $_file1)) {

//echo __FILE__.'['.__LINE__.']';
// режем квадрат из изображения с определённой длинной стороны
        if (isset($_GET['type']) && $_GET['type'] == 'q' &&
                isset($_GET['w']{0}) && is_numeric($_GET['w'])) {

// папска с созданными файлами
            $cash_dir1 = DirSite . 'download/didra-nyos';

            if (!is_dir($cash_dir1))
                mkdir($cash_dir1, 0755);

            $cash_dir = $cash_dir1 . DS . 'q-' . $_GET['w'];

            if (!is_dir($cash_dir))
                mkdir($cash_dir, 0755);


            $list_dir = explode('/', $_file1);
// echo $_SERVER['DOCUMENT_ROOT'];
// f\pa($list_dir); exit;

            if (isset($list_dir[0]) && isset($list_dir[1]) && !isset($list_dir[2])) {

                $cash_dir2 = $cash_dir . DS . $list_dir[0];

                if (!is_dir($cash_dir2))
                    mkdir($cash_dir2, 0755);
            }
            elseif (isset($list_dir[0]) && isset($list_dir[1]) && isset($list_dir[2]) && !isset($list_dir[3])) {

                $cash_dir2 = $cash_dir . DS . $list_dir[0];

                if (!is_dir($cash_dir2))
                    mkdir($cash_dir2, 0755);

                $cash_dir2 = $cash_dir . DS . $list_dir[0] . DS . $list_dir[1];

                if (!is_dir($cash_dir2))
                    mkdir($cash_dir2, 0755);
            }


            require_once($_SERVER['DOCUMENT_ROOT'] . '/0.all/class/nyos_image.php');

// die('22222');

            if (file_exists($cash_dir . DS . $_file2) && isset($_REQUEST['rewrite']) && $_REQUEST['rewrite'] == 1)
                unlink($cash_dir . DS . $_file2);

// если есть ранее созданный, то показываем его
            if (file_exists($cash_dir . DS . $_file2))
                Nyos\nyos_image::showImage($cash_dir . DS . $_file2);

// die('11111');
// echo $_SERVER['DOCUMENT_ROOT'] . '/' . $_dir1 . $_file1;

            Nyos\nyos_image::new_image($_SERVER['DOCUMENT_ROOT'] . '/' . $_dir1 . $_file1);
            Nyos\nyos_image::creatThumbnailKvadrat($_GET['w']);
            Nyos\nyos_image::saveImage($cash_dir . DS . $_file2, false, true);

//$ny_image->creat_thumbnail( $_GET['w'], $_GET['w'] );
//$ny_image->save( $cash_dir . '/', $_file1, 'jpg', false, 90 );

            Nyos\nyos_image::showImage($cash_dir . '/' . $_file2 . $rr);
        }

// изменение размеров и качества картинки
        elseif (isset($_GET['q']) && is_numeric($_GET['q']) &&
                isset($_GET['w']) && is_numeric($_GET['w'])) {

            if (file_exists(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . $_file1))
                die(file_get_contents(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . $_file1));

//$expires = 60*60*4;
//header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . 'GMT');
// создаём исходное изображение на основе исходного файла и опеределяем его размеры
            if (strpos(strtolower($_file1), '.gif') !== false) {
                $src = imagecreatefromgif($_SERVER['DOCUMENT_ROOT'] . '/' . $_dir1 . $_file1);
            } elseif (strpos(strtolower($_file1), '.png') !== false) {
                $src = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . '/' . $_dir1 . $_file1);
            } else {
                $src = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . '/' . $_dir1 . $_file1);
            }

// размеры реального изображения
            $ww = $w_src = imagesx($src);
            $hh = $h_src = imagesy($src);

// размеры будующего изображения
            $new_w = $_GET['w'];

            $pr1w = round($ww / 100, 2);
            $pr1h = round($hh / 100, 2);

            if ($ww > $hh) {
                $w_dest = $new_w;
                $h_dest = round($pr1h * ($new_w / $pr1w));
            } else {
                $h_dest = round($new_w / ($ww / 100) * $pr1h);
                $w_dest = round($new_w / ($ww / 100) * $pr1w);
            }

// создаём пустую картинку
            $dest = imagecreatetruecolor($w_dest, $h_dest); // важно именно truecolor!, иначе будем иметь 8-битный результат

            imagecopyresized($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

// уничтожаем оригинал в памяти
            imagedestroy($src);



            if (!is_dir(DirSite . DS . 'download/didra-nyos'))
                mkdir(DirSite . DS . 'download/didra-nyos', 0755);

            if (!is_dir(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w']))
                mkdir(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'], 0755);

//$_file1 = '231/232/333/444/123.jpg';
            $ttr = explode('/', $_file1);
//echo '<pre>'; print_r($ttr); echo'</pre>';
            $ur = sizeof($ttr);

// выстраиваем дерево каталогов
            if ($ur > 1) {
                $ur_dop = '';
                foreach ($ttr as $k => $v) {
                    if ($k <= $ur - 2) {
                        if (!is_dir(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . ( isset($ur_dop{1}) ? $ur_dop : '' ) . '/' . $v))
                            mkdir(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . ( isset($ur_dop{1}) ? $ur_dop : '' ) . '/' . $v, 0755);

//echo $_SERVER['DOCUMENT_ROOT'].'/9.site/'.$domen_info['login'].'/'.$domen_info['folder'].'/download/didra-nyos/'.$_GET['q'].'-'.$_GET['w'].'/'.( isset($ur_dop{1}) ? $ur_dop : '' ).'/'.$v.'<br/>';
                        $ur_dop .= '/' . $v;
                    }
                }
            }

// вывод картинки и очистка памяти

            if (strpos(strtolower($_file1), '.gif') !== false) {
                imagegif($dest, DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . $_file1, $_GET['q']);
//imagegif($dest,'',$_GET['q']);
            }
//            elseif( strpos(strtolower($_file1),'.png') !== false )
//            {
//            imagejpeg($dest,
//                DirSite.DS.'download/didra-nyos/'.$_GET['q'].'-'.$_GET['w'].'/'.$_file1,
//                $_GET['q']);
//            }
            else {
                imagejpeg($dest, DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . $_file1, $_GET['q']);
            }

            imagedestroy($dest);

            if (strpos(strtolower($_file1), '.gif') !== false) {
                header("Content-type: image/gif");
            }
//        elseif( strpos(strtolower($_file1),'.png') !== false )
//        {
//        header("Content-type: image/gif");
//        //header("Content-type: image/png");
//        }
            else {
                header("Content-type: image/jpeg");
            }

            header("Cache-Control: public");
            header("Pragma: cache");

            $expires = 60 * 60 * 4;
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . 'GMT');


            die(file_get_contents(DirSite . DS . 'download/didra-nyos/' . $_GET['q'] . '-' . $_GET['w'] . '/' . $_file1));
//exit();
        }

// что то не сходится, просто показываем картинку
        else {

            if (strpos(strtolower($_file1), '.gif') !== false) {
                header("Content-type: image/gif");
            }
//        elseif( strpos(strtolower($_file1),'.png') !== false )
//        {
//        header("Content-type: image/gif");
//        //header("Content-type: image/png");
//        }
            else {
                header("Content-type: image/jpeg");
            }

            header("Cache-Control: public");
            header("Pragma: cache");

            $expires = 60 * 60 * 4;
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . 'GMT');


//	file_load( './'.$_dir1.$_file1, $search_ext );

            header("Content-Length: " . filesize('./' . $_dir1 . $_file1));
//header("Location: http://".$_SERVER['HTTP_HOST']."/uralweb.redir/1".$DiUser."/2".$DiFold."--".$_file1);
//echo './'.$_dir1.$_file1; exit();

            readfile($_SERVER['DOCUMENT_ROOT'] . '/' . $_dir1 . $_file1);
//header("Location: http://".$_SERVER['HTTP_HOST']."/look/1".$domen_info['login']."/2".$domen_info['folder']."/3".$_file1);
//header("Content-type: ".$search_ext);
//echo readfile($file_in);
//$rf = filez_get_contents($file_in); echo $rf;
            exit();
        }
    }
// если нет картинки по ссылке
    else {
        header('Content-Type: image/jpeg');
        die(file_get_contents($_SERVER['DOCUMENT_ROOT'] . DS . 'image' . DS . 'poloski.jpg'));
    }
}

