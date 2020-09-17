<?php

// если в запросе $_REQUEST['return'] == 'array' то смотрим массив для чела норм
// если в запросе $_REQUEST['return'] == 'end_small' то json и норм вывод таблицы / модуль - версия
// иначе возврат json

try {

    $d = $_SERVER['DOCUMENT_ROOT'] . '/vendor/';
    $dir0 = scandir($d);
    // \f\pa($dir0);
    // echo '<pre>'; print_r($dir0); echo '</pre>';

    $return = [];

    foreach ($dir0 as $v) {

        if ($v == '.' || $v == '..')
            continue;

        $dir1 = scandir($d . $v);
        // \f\pa($dir0);
        // echo '<pre>'; print_r($dir1); echo '</pre>';

        foreach ($dir1 as $v1) {

            if ($v1 == '.' || $v1 == '..')
                continue;

            // echo '<pre>'; print_r($v1); echo '</pre>';




            $dir2 = scandir($d . $v . '/' . $v1);
            // \f\pa($dir0);
//            echo '<pre>';
//            print_r($dir2);
//            echo '</pre>';
//            foreach ($dir2 as $v2) {
//
//                if ($v2 == '.' || $v2 == '..')
//                    continue;
            // echo '<pre>'; print_r($v2); echo '</pre>';
            $file = $d . $v . '/' . $v1 . '/composer.json';
            if (file_exists($file)) {

                try {
                    $a = json_decode(file_get_contents($file), true);
                    // echo '<pre>'; print_r($a); echo '</pre>';

                    if (isset($a['name']) && isset($a['version'])) {
                        $return[] = $a;
                    }
                } catch (\Exception $ex) {
//                        echo '<pre>';
//                        print_r($ex);
//                        echo '</pre>';
                }
//                }
            }
        }
    }

    if (isset($_REQUEST['return']) && $_REQUEST['return'] == 'end_small') {

        // require_once '0start.php';
        
        $table = '<table class="table" ><thead><tr><th>модуль</th><th>версия</th></tr></thead><tbody>';
        foreach ($return as $v) {
            $table .= '<tr><td>' . $v['name'] . '</td><td>' . $v['version'] . '</td></tr>';
        }
        $table .= '</tbody></table>';
        die( json_encode( ['html' => $table , 'status' => 'ok' ] ) );
        
    } elseif (isset($_REQUEST['return']) && $_REQUEST['return'] == 'array') {
        echo '<pre>';
        print_r($return);
        echo '</pre>';
        die();
    } else {
        die(json_encode($return));
    }
} catch (\PDOException $exc) {

    // require_once '0start.php';
    
    // \f\pa($exc);
    echo '<pre>'; print_r($exc); echo '</pre>';
    // \f\end2('не окей', false, $exc);
    // echo $exc->getTraceAsString();
}

// require_once '0start.php';

// \f\end2('сто то пошло не так #' . __LINE__, false);
