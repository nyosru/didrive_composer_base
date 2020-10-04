Russian

====== Установка ========

composer require didrive/base

======= Пример ========

----- по ссылке отправляем аякс запрос и получаем ответ -----

<a href="#" 

    class="base__send_to_ajax" 
    style="float:right;" 

    href_to_ajax="/vendor/didrive_mod/items/1/ajax.php" 

    hidethis="da" 
    answer="удалить комментарий ?" 

    action="remove_item" 
    aj_id="' + ar['id'] + '" 
    aj_s="' + ar['s'] + '" 

    res_to_id="com' + ar['id'] + '" 
    after_click_showid="com' + ar['id'] + '" 
    msg_to_success="Комментарий удалён" 

    // эти строчки для второго запроса // будет отправлен если они есть
    ajax2_link='/vendor/didrive_mod/items/3/micro-service/delete-items.php'
    ajax2_vars='r_module=sp_ocenki_job_day&remove[sale_point]={{ sp_now }}&remove[date]={{ date }}'

    >aaaaaa</a>
<div id="com' + ar['id'] + '" style="display:none;"></div>
