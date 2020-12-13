<?php

namespace Nyos;

//if (!defined('IN_NYOS_PROJECT'))
//    die('<center><br><br><br><br><p>Сработала защита <b>c.NYOS</b> от злостных розовых хакеров.</p>
//    <a href="http://www.uralweb.info" target="_blank">Создание, дизайн, вёрстка и программирование сайтов.</a><br />
//    <a href="http://www.nyos.ru" target="_blank">Только отдельные услуги: Дизайн, вёрстка и программирование сайтов.</a>'
//        .'nyos.php');
//}
// echo '<Br/>'.__FILE__ .' ['.__LINE__.']';

class Nyos {

//    public static $logs = '';
    public static $menu = false;
    public static $a_menu = [];
    public static $all_menu = [];
    // массив модулей которые допускаем $access_mod[] = модуль $access_mod[] = модуль
    public static $access_mod = '';
//    public static $folder = '';
//    public static $connecttype = FALSE; // CURL / SOCKET / NONE / FALSE
    public static $folder_now = null;
    public static $folder_all = null;
    
    public static $db_type = '';

    /**
     * строка путь до файла кеша меню
     * @var type 
     */
    public static $cash_file_menu = null;

    /**
     * получаем папку сайта по домену (если не указали домен, то текущий домен)
     * @param type $db
     * @param string $domain0
     * @return string или null
     * @throws \NyosEx
     */
    public static function getFolder(string $domain0 = null) {

        if (empty($domain0)) {

            $now = true;
            $domain = str_replace('www.', '', strtolower($_SERVER['HTTP_HOST']));
        } else {

            $now = false;
            $domain = str_replace('www.', '', strtolower($domain0));
        }


        if (!extension_loaded('PDO')) {
            throw new \Exception(' pdo bd не доступен ');
        }

        if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/sites')) {
            $SqlLiteFile = $_SERVER['DOCUMENT_ROOT'] . '/sites/db.sqllite.sl3';
        } elseif (is_dir($_SERVER['DOCUMENT_ROOT'] . '/site')) {
            $SqlLiteFile = $_SERVER['DOCUMENT_ROOT'] . '/site/db.sqllite.sl3';
        } else {
            throw new \Exception(' не определена папка важная ');
        }

        //echo $SqlLiteFile;

        $db = new \PDO('sqlite:' . $SqlLiteFile, null, null, array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ));
        //$db->exec('PRAGMA journal_mode=WAL;');


        if (isset(self::$folder_all[$domain]))
            return self::$folder_all[$domain];

        if (isset(self::$folder_now) && self::$folder_now !== null && self::$folder_now == '')
            return self::$folder_all[$domain] = '';

        try {

            $ff = $db->prepare('SELECT folder FROM `2domain` WHERE domain = :domain LIMIT 1;');
            $ff->execute(array(':domain' => $domain));

            if ($f = $ff->fetch()) {
                if ($now === true)
                    self::$folder_now = $f['folder'];

                self::$folder_all[$domain] = $f['folder'];
                return !empty($f['folder']) ? $f['folder'] : null;
            } else {

                $ff = $db->prepare('INSERT INTO  `2domain` (domain) VALUES (?)');
                $ff->execute([$domain]);
            }
            unset($ff);
        }
        //
        catch (\PDOException $ex) {

// не найдена таблица, создаём значит её
            if (strpos($ex->getMessage(), 'no such table')) {

// echo '<Br/>ошибка DB:' . $e->getMessage();
                $db->exec('CREATE TABLE `2domain` ( ' .
                        ' `domain` varchar(150) NOT NULL, ' .
                        ' `folder` varchar(150) DEFAULT NULL ' .
                        ' );');

                $ff = $db->prepare('INSERT INTO  `2domain` (domain) VALUES (?)');
                $ff->execute([$domain]);
                unset($ff);
            } else {

                echo '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
                . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
                . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
                . PHP_EOL . $ex->getTraceAsString()
                . '</pre>';

                $msg = 'непонятная ошибка DB (выбираем папку по домену): ' . $ex->getMessage();
                
                \nyos\Msg\sendTelegramm( $msg , null, 2 );
                
                throw new \Exception( $msg );
                // throw new \NyosEx('непонятная ошибка DB (выбираем папку по домену): ' . $ex->getMessage());
                
            }
        }
    }

    public static function defineVars($folder = null, array $cfg_mod_array = []) {

        global $vv;

        //\f\pa($cfg_mod_array);

        if (!defined('IN_NYOS_PROJECT'))
            define('IN_NYOS_PROJECT', TRUE);

        if (!defined('DS'))
            define('DS', DIRECTORY_SEPARATOR);

        $vv['domain'] = str_replace("www.", '', mb_strtolower($_SERVER['HTTP_HOST']));

        if ($folder === null && !empty($vv['folder']))
            $folder = $vv['folder'];

        if (!defined('domain'))
            define('domain', $vv['domain']);

        if ($folder === null && is_dir($_SERVER['DOCUMENT_ROOT'] . DS . 'site' . DS)) {
            $vv['dir_site_file'] = 
            $vv['dir_site'] = $site_dir = DS . 'site' . DS;
        } 
        // если композер сайт, дата на базовом пути /site/ffff/*
        elseif ( !empty($folder) && is_dir($_SERVER['DOCUMENT_ROOT'] . DS . 'vendor' . DS . 'didrive_site' . DS . $folder . DS )) {
            $vv['site_type'] = 'composer';
            $vv['dir_site'] = $site_dir = DS . 'vendor' . DS . 'didrive_site' . DS . $folder . DS ;
            $vv['dir_site_file'] = DS . 'sites' . DS . $folder . DS;
        }
        // если обычный сайт, дата на базовом пути /site/ffff/*
        elseif (is_dir( DR . DS . 'sites' . DS . $folder . DS)) {
            $vv['dir_site_file'] = DS . 'sites' . DS . $folder . DS;
            $vv['dir_site'] = $site_dir = DS . 'sites' . DS . $folder . DS;
        }

        if (empty($site_dir))
            throw new \Exception('Не найдена папка с сайтом');

//echo '<Br/>'.__FILE__.' #'.__LINE__.' '.$vv['folder'].'/'.$folder;
//echo '<Br/>'.__FILE__.' #'.__LINE__.' '.$vv['dir_site'];

        /**
         * корень сайта
         */
        define('DR', $_SERVER['DOCUMENT_ROOT']);
        $vv['DR'] = $_SERVER['DOCUMENT_ROOT'];
        
        // \f\pa($vv['DR']);

        // папка сайта
        define('site_type', $vv['site_type'] ?? null );
        
        /**
         * /папка сайта/
         */
        define('dir_site', $site_dir);

        /**
         * /папка сайта/модули/
         */
        define('dir_site_module', $site_dir . 'module' . DS);
        define('dir_site_module_local', $vv['dir_site_file'] . 'module' . DS);
        
        /**
         * /папка сайта/download/
         * ( возможно композер сайта )
         */
        define('dir_site_sd', $site_dir . 'download' . DS);
        /**
         * /sites/folder/download/
         * ( только базовая папка сайта с содержимым )
         */
        define('dir_site_sd_local', $vv['dir_site_file'] . 'download' . DS);
        //echo $vv['sd'];
        $vv['sd'] = dir_site_sd;
        $vv['sd_local'] = dir_site_sd_local;

        /**
         * /папка сайта/template/
         */
        define('dir_site_tpl', $site_dir . 'template' . DS);

        /**
         * /папка сайта/template.didrive/
         * 2
         */
        define('dir_site_tpldidr', $site_dir . 'template.didrive' . DS);

        /**
         * /didrive/
         * 2
         */
        define('dir_didr', DS . 'vendor' 
                . DS . 'didrive' 
                . DS . 'base' 
                . DS . 'design' 
                . DS . 'design' 
                . DS);

        /**
         * /didrive/module/
         * 2
         */
        define('dir_didr_module', 
                DS . 'vendor' 
                . DS . 'didrive' 
                . DS . 'base' 
                . DS . 'design' 
                . DS . 'module' . DS);
        /**
         * /didrive/tpl/
         * 2
         */
        define('dir_didr_tpl', DS . 'vendor' 
                . DS . 'didrive' 
                . DS . 'base' 
                . DS . 'design' . DS . 'tpl' . DS);

// формируем \Nyos\Nyos::$menu         
        self::getMenu($folder);

        // \f\pa(\Nyos\Nyos::$menu);
        // \f\pa($_GET);
        //
        if (isset($_GET['level']) && isset(\Nyos\Nyos::$menu[$_GET['level']])) {
            $vv['level'] = $_GET['level'];
            $vv['now_level'] = \Nyos\Nyos::$menu[$vv['level']];
            $vv['now_level']['cfg.level'] = $vv['level'];
        }
        //
        else if (isset($_GET['level_di']) && isset(\Nyos\Nyos::$menu['di'][$_GET['level_di']])) {

            $vv['level'] = $_GET['level_di'];
            $vv['now_level'] = \Nyos\Nyos::$menu['di'][$vv['level']];
            $vv['now_level']['cfg.level'] = $vv['level'];
        }
        //
        else {
            $vv['level'] = '000.index';
            // $vv['now_level'] = \Nyos\Nyos::$menu[$vv['level']];
            $vv['now_level']['cfg.level'] = $vv['level'];
        }

//        echo $vv['level'];
//        \f\pa($vv['now_level']);

        if (!isset($vv['now_level']['cfg.level']))
            throw new \Exception('Нет важных данных в данных о текущем модуле');


        /**
         * /папка сайта/модули/--текущий мод--/
         */
        define('dir_site_module_nowlev', dir_site_module . $vv['now_level']['cfg.level'] . DS);

        /**
         * /папка сайта/модули/--текущий мод--/tpl/
         */
        define('dir_site_module_nowlev_tpl', dir_site_module . $vv['now_level']['cfg.level'] . DS . 'tpl' . DS);
        define('dir_site_module_nowlev_tpl_local', dir_site_module_local . $vv['now_level']['cfg.level'] . DS . 'tpl' . DS);

        /**
         * /папка сайта/модули/--текущий мод--/tpl.didrive/
         */
        define('dir_site_module_nowlev_tpldidr', dir_site_module . $vv['now_level']['cfg.level'] . DS . 'tpl.didrive' . DS);

        /**
         * /папка сайта/модули/--текущий мод--/tpl.inf/
         */
        define('dir_site_module_nowlev_tpl_inf', dir_site_module . $vv['now_level']['cfg.level'] . DS . 'tpl.inf' . DS);



        //\f\pa($vv['now_level']);

        /**
         * /модули/
         */
        define('dir_mods', DS . 'vendor' . DS . 'didrive_mod' . DS);


        if (!empty($vv['now_level']['type'])) {
            /**
             * /вендор/модули/текущий модуль (тип)/
             */
            define('dir_mods_mod', DS . 'vendor' . DS . 'didrive_mod' . DS . $vv['now_level']['type'] . DS);
            /**
             * /вендор/модули/текущий модуль (тип)/версия/
             */
            define('dir_mods_mod_vers', DS . 'vendor' . DS . 'didrive_mod' . DS . $vv['now_level']['type'] . DS . $vv['now_level']['version'] . DS);
            /**
             * /вендор/модули/текущий модуль (тип)/версия/tpl/
             */
            define('dir_mods_mod_vers_tpl', DS . 'vendor' . DS . 'didrive_mod' . DS . $vv['now_level']['type'] . DS . $vv['now_level']['version'] . DS . 'tpl' . DS);
            /**
             * /вендор/модули/текущий модуль (тип)/версия/tpl.inf/
             */
            define('dir_mods_mod_vers_tpl_inf', DS . 'vendor' . DS . 'didrive_mod' . DS . $vv['now_level']['type'] . DS . $vv['now_level']['version'] . DS . 'tpl.inf' . DS);
            /**
             * /модули/текущий модуль (тип)/версия/didrive/
             */
            define('dir_mods_mod_vers_didrive', DS . 'vendor' . DS . 'didrive_mod' . DS . $vv['now_level']['type'] . DS . $vv['now_level']['version'] . DS . 'didrive' . DS);

            /**
             * /модули/текущий модуль (тип)/версия/didrive/tpl/
             */
            define('dir_mods_mod_vers_didrive_tpl', DS . 'vendor' . DS . 'didrive_mod' . DS . $vv['now_level']['type'] . DS . $vv['now_level']['version'] . DS . 'didrive' . DS . 'tpl' . DS);
            //define('dir_mods_mod_vers_didrive_tpl', DS . 'vendor' . DS . 'didrive_mod' . DS . $vv['now_level']['type'] . DS . $vv['now_level']['version'] . DS . 'didrive' . DS . 't' . DS);
        }


        //self::$cash_file_menu = DR . dir_site . \f\translit(domain, 'uri2') . '.cash.mnu.json';
        self::$cash_file_menu = DR . dir_site . domain . '.cash.mnu.json';
    }

    /**
     * формируем менюшку сайта или достаём из файла данных
     * @return type
     */
    public static function getSiteModule() {

        if (!empty(self::$a_menu))
            return self::$a_menu;

        //$timer = true;
        if (isset($timer) && $timer === true) {
            \f\timer_start(77);
        }


        $h = scandir(DR . dir_site_module);

        // echo '<Br/>'.__FILE__.' '.__LINE__;
        // \f\pa($_SESSION);

        foreach ($h as $k => $v) {

            /**
             * если чем модератор, то проверяем на что есть доступ и на что нет
             */
//            if (isset($_SESSION['now_user_di']['access']) && $_SESSION['now_user_di']['access'] == 'moder') {
//                if (!empty(\Nyos\Nyos::$access_mod) && isset(\Nyos\Nyos::$access_mod[$v])) {
//                    // echo '<Br/>'.__FILE__.' '.__LINE__;
//                } else {
//                    // echo '<Br/>'.__FILE__.' '.__LINE__;
//                    continue;
//                }
//            }

            if (!empty($v)) {

                // \f\pa(\Nyos\Nyos::$access_mod);

                $file_cfg = DR . dir_site_module . $v . DS . 'cfg.ini';

                if (file_exists($file_cfg)) {

                    $a = parse_ini_file($file_cfg, true);

                    if (!empty($a['type']) && !empty($a['version'])) {

                        $a['cfg.level'] = $v;

                        if (isset($_SESSION['now_user_di']['access']) &&
                                (
                                $_SESSION['now_user_di']['access'] == 'admin' ||
                                (
                                $_SESSION['now_user_di']['access'] == 'moder' && !empty(\Nyos\Nyos::$access_mod) &&
                                (
                                isset(\Nyos\Nyos::$access_mod[$v]) || isset(\Nyos\Nyos::$access_mod['moder'][$v])
                                ) )
                                )
                        ) {
                            self::$a_menu[$v] = $a;
                        }
                        self::$all_menu[$v] = $a;
                    }
                }
            }
        }

        //echo DirSite;
        $h = scandir(DR . dir_didr_module);
        foreach ($h as $k => $v) {
            if (!empty($v)) {
                $file_cfg = DR . dir_didr_module . $v . DS . 'cfg.ini';
                if (file_exists($file_cfg)) {
                    $a = parse_ini_file($file_cfg, true);
                    if (!empty($a['type']) && !empty($a['version'])) {
                        $a['cfg.level'] = $v;

                        if (!empty($_SESSION['now_user_di']['access']) && (
                                $_SESSION['now_user_di']['access'] == 'admin' ||
                                (
                                $_SESSION['now_user_di']['access'] == 'moder' && !empty(\Nyos\Nyos::$access_mod) && (
                                isset(\Nyos\Nyos::$access_mod[$v]) || isset(\Nyos\Nyos::$access_mod['moder'][$v])
                                )
                                )
                                )
                        ) {
                            self::$a_menu['di'][$v] = $a;
                        }

                        self::$all_menu['di'][$v] = $a;
                    }
                }
            }
        }

//        file_put_contents($file_cash, json_encode(['all' => self::$all_menu, 'a' => self::$a_menu]));

        if (isset($timer) && $timer === true) {
            echo '<br/>#' . __LINE__ . ' ' . \f\timer_stop(77);
        }

        return self::$a_menu;
    }

    /**
     * создаём секрет из строчки
     * @param type $text
     * что шифруем
     * @return type
     * на выходе секрет
     */
    public static function creatSecret($text) {
        return md5( filemtime(__FILE__).'wwdv' . $text . date('ymd', $_SERVER['REQUEST_TIME']));
    }

    /**
     * проверяем секрет 
     * @param string $secret
     * секрет
     * @param string $text
     * что шифровали
     * @return boolean
     */
    public static function checkSecret(string $secret, string $text) {
        if ($secret == md5( filemtime(__FILE__).'wwdv' . $text . date('ymd', $_SERVER['REQUEST_TIME']))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * формируем менюшку сайта или достаём из файла данных
     * @param string $folder
     * @return type
     */
    public static function getMenu(string $folder = null, string $domain = null) {

        //echo dir_serv_site;

        if (!defined('dir_site'))
            throw new \Exception('не определена папка сайта при получени менюшки');

        // $file_cash = DirSite . 'module' . DS . '_cash_mnu.' . domain . '.cfg.php';
        $enable_cash = file_exists(DR . dir_site . 'nocreat_cash_module') ? false : true;

// если есть кеш и пользоваться им можно        
        if ($enable_cash === true && self::$cash_file_menu !== null && file_exists(self::$cash_file_menu)) {
            self::$menu = json_decode(file_get_contents(self::$cash_file_menu), true);
        }

// если формируем менюшку заново
        else {

            self::$menu = [];

            if (is_dir(DR . dir_site_module))
                $rf = scandir(DR . dir_site_module);

            if (isset($rf))
                foreach ($rf as $k => $v) {

                    if (!empty($v) && $v != '.' && $v != '..' && file_exists(DR . dir_site_module . $v . DS . 'cfg.ini')) {

                        try {
                            self::$menu[$v] = parse_ini_file(DR . dir_site_module . $v . DS . 'cfg.ini', true);
                            self::$menu[$v]['cfg.level'] = $v;
                        }
                        //
                        catch (\Exception $ex) {
                            self::$menu[$v] = array(
                                'error' => $e->getMessage(),
                                'code' => $e->getCode(),
                                'file' => $e->getFile(),
                                'line' => $e->getLine()
                            );
                        }
                    }
                }

            //echo DirSite;
            if (is_dir(DR . dir_didr_module))
                $h = scandir(DR . dir_didr_module);

            if (!empty($h))
                foreach ($h as $k => $v) {
                    if (!empty($v)) {
                        $file_cfg = DR . dir_didr_module . $v . DS . 'cfg.ini';
                        if (file_exists($file_cfg)) {
                            $a = parse_ini_file($file_cfg, true);
                            if (!empty($a['type']) && !empty($a['version'])) {
                                $a['cfg.level'] = $v;
                                self::$menu['di'][$v] = $a;
                            }
                        }
                    }
                }

            if ($enable_cash === true && !empty(self::$cash_file_menu))
                file_put_contents(self::$cash_file_menu, json_encode(self::$menu));
        }
    }

}
