<?php

try {

//    $date = $in['date'] ?? $_REQUEST['date'] ?? null;
//
//    if (empty($date))
//        throw new \Exception('нет даты');

    require_once '0start.php';

    \f\pa($_REQUEST);

    echo '<h3>удаляем все удалённые строчки</h3>';

    $sql = 'DELETE FROM `mitems` WHERE `status` = \'delete\' ;';
    \f\pa($sql);
    $ff = $db->prepare($sql);
    $ff->execute();

    $sql = 'OPTIMIZE TABLE `mitems` ;';
    \f\pa($sql);
    $ff = $db->prepare($sql);
    $ff->execute();

    $sql = 'DELETE FROM `mitems-dops` WHERE `status` = \'delete\' ;';
    \f\pa($sql);
    $ff = $db->prepare($sql);
    $ff->execute();

    $sql = 'OPTIMIZE TABLE `mitems-dops` ;';
    \f\pa($sql);
    $ff = $db->prepare($sql);
    $ff->execute();

    die('готово');
    
} catch (Exception $exc) {

    echo '<pre>';
    print_r($exc);
    echo '</pre>';
    // echo $exc->getTraceAsString();
}