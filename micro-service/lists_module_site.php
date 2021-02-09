<?php

// если в запросе $_REQUEST['return'] == 'array' то смотрим массив для чела норм
// если в запросе $_REQUEST['return'] == 'end_small' то json и норм вывод таблицы / модуль - версия
// иначе возврат json

try {

    if (isset($skip_start) && $skip_start === true) {
        
    } else {
        require_once '0start.php';
    }

    ob_start('ob_gzhandler');

    $d = DR . dir_site . 'module' . DS;
    $return = [];
    $dir0 = scandir($d);

    foreach ($dir0 as $v) {

        if ($v == '.' || $v == '..')
            continue;

        if (file_exists($d . $v . DS . 'cfg.ini')) {
            $arr = parse_ini_file($d . $v . DS . 'cfg.ini', true);
            //\f\pa($arr);
            $return[$v] = $arr;
        }
    }

    $r = ob_get_contents();
    ob_end_clean();


    if (isset($_REQUEST['return']) && $_REQUEST['return'] == 'end_small') {

        // require_once '0start.php';

        $table = '<table class="table" ><thead><tr><th>модуль</th><th>версия</th><th>uri</th><th>название</th></tr></thead><tbody>';
        foreach ($return as $k => $v) {
            $table .= '<tr><td>' . $v['type'] . '</td><td>' . $v['version'] . '</td><td>' . $k . '</td><td>' . $v['name'] . '</td></tr>';
        }
        $table .= '</tbody></table>';
        die(json_encode(['html' => $table . $r, 'status' => 'ok']));
    } elseif (isset($_REQUEST['return']) && $_REQUEST['return'] == 'array') {
        echo '<pre>';
        print_r($return);
        echo '</pre>' . $r;
        die();
    } else {
        die(json_encode($return));
    }
} catch (\PDOException $exc) {

    // require_once '0start.php';
    // \f\pa($exc);
    echo '<pre>';
    print_r($exc);
    echo '</pre>';
    // \f\end2('не окей', false, $exc);
    // echo $exc->getTraceAsString();
}

// require_once '0start.php';

// \f\end2('сто то пошло не так #' . __LINE__, false);
