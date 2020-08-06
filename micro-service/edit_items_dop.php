<?php

try {

    require_once '0start.php';

    $in = $_REQUEST;

    $in_sql = '';
    $in_sql_val = [];

    for ($i = 1; $i <= 10; $i++) {
        if (isset($in['in_edit' . $i]) && isset($in['in_edit' . $i . 'val'])) {
            $in_sql .= ' AND `' . $in['in_edit' . $i] . '` = :v' . $i . ' ';
            $in_sql_val[':v' . $i] = $in['in_edit' . $i . 'val'];
        }
    }

    $sql = 'SELECT * FROM `mod_' . \f\translit($_REQUEST['in_module'], 'uri2') . '` WHERE `status` != \'delete\' ' . $in_sql . ' ;';
    $ff = $db->prepare($sql);
    $ff->execute($in_sql_val);

    $res = $ff->fetch();

    if (!empty($res['id'])) {

        $in_sql_val = [
            ':id' => $res['id'],
            ':in' => $in['new_val']
        ];

        $sql = 'UPDATE `mod_' . \f\translit($_REQUEST['in_module'], 'uri2') . '` SET `' . $in['in_pole_edit_name'] . '` = :in WHERE `id` = :id ;';
        $ff = $db->prepare($sql);
        $ff->execute($in_sql_val);

        \f\end2('окей', true, ['id' => $res['id']]);
    }
    // если нет записи, добавляем
    else {

        $var_array = [$in['in_pole_edit_name'] => $in['new_val']];

        for ($i = 1; $i <= 10; $i++) {
            if (isset($in['in_edit' . $i]) && isset($in['in_edit' . $i . 'val'])) {
                $var_array[$in['in_edit' . $i]] = $in['in_edit' . $i . 'val'];
            }
        }

        \f\db\db2_insert($db, 'mod_' . \f\translit($_REQUEST['in_module'], 'uri2'), $var_array, true);

        \f\end2('окей добавил');
    }
} catch (\PDOException $exc) {

    // \f\pa($exc);
    \f\end2('не окей', false, $exc);
    // echo $exc->getTraceAsString();
}

\f\end2('сто то пошло не так #' . __LINE__, false);
