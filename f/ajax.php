<?php

namespace f;

// строчки безопасности

if (!defined('IN_NYOS_PROJECT'))
    die('Сработала защита <b>функций MySQL</b> от злостных розовых хакеров.' .
            '<br>Приготовтесь к DOS атаке (6 поколения на ip-' . $_SERVER["REMOTE_ADDR"] . ') в течении 30 минут.');

/**
 * заглушка возврат массива f\end2( array )
 * @param type $html
 * @param type $stat
 * @param type $dop_array
 * @return type
 */
function end3( $html, $stat = true , $dop_array = false ) {
    return end2($html, $stat, array('data' => $dop_array), 'array');
}

/**
 * возврат в конце чего нить
 * @param type $html
 * @param type $status
 *
 * @param type $dop_array
 * @param type $type2
 * array - return / table - die / (default) json - die
 * @return type
 */

function end2($html, $stat = true, $dop_array = false, $type2 = 'json') {

    if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
        global $status;
        $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
    }

    $t = ( $dop_array !== false ) ? $dop_array : array();

    $t['status'] = ( $stat == 'ok' || $stat === true ) ? 'ok' : 'error' ;
    $t['html'] = $html;

    // if ($dop_array !== false)
    // $t = array_merge($t, $dop_array);
    // используется только для отладки
    // debug_print_backtrace();
    if ($type2 == 'array') {

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            $status .= 'html: ' . $t['html']
                    . '<br/>status:' . $t['status']
                    . '<br/>type2:' . $type2
                    . '<br/>line:' . __LINE__
            ;
            foreach ($t as $k => $v) {
                if (isset($v{0}) && is_string($v) )
                    $status .= '<br/>' . $k . ' - ' . $v;
            }
            $status .= '</fieldset>';
        }

        return $t;
    }
    elseif ($type2 == 'table') {

        echo '<table>';
        foreach ($t as $k => $k2) {
            echo '<tr><td>' . $k . '</td><td>' . $k2 . '</td></tr>';
        }
        if ($dop_array !== false) {
            echo '<tr><td>dop array</td><td>+</td></tr>';
            foreach ($dop_array as $k => $k2) {
                echo '<tr><td>' . $k . '</td><td>' . $k2 . '</td></tr>';
            }
        }
        echo '</table>';

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            $status .= 'html: ' . $t['html']
                    . '<br/>status:' . $t['status']
                    . '<br/>type2:' . $type2
                    . '<br/>line:' . __LINE__
            ;
            $status .= '</fieldset>';
        }

        die();
    } else {


        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            $status .= 'html: ' . $t['html']
                    . '<br/>status:' . $t['status']
                    . '<br/>type2:' . $type2
                    . '<br/>line:' . __LINE__;
            foreach ($t as $k => $v) {
                if (isset($v{0}) && is_string($v) )
                $status .= '<br/>' . $k . ' - ' . $v;
            }
            $status .= '</fieldset>';
        }
        die(json_encode($t));
    }
    
}
