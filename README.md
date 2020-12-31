Russian

====== Установка ========

composer require didrive/base

======= Пример ========

------ конфиг модулей cfg.ini -------

; показывать на верху списка менюшек в дидрайве
up = 1

; добавить кнопу на главную менюшку справой стороны в дидрайв
in-di-menu-1 = da


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


---- удаление по кнопке ------

    <a href="#" 

       class="base__send_to_ajax" 
       style="float:right;" 

       href_to_ajax="/vendor/didrive_mod/items/3/micro-service/delete-items.php" 

       hidethis="da" 
       answer="отменить выплату ?" 

       r_module="075.buh_oplats"
       delete_id='{{ pay.id }}'
       s='{{ creatSecret(pay.id) }}'

       res_to_id="pa{{ pay.id }}" 
       after_click_showid="pa{{ pay.id }}" 
       msg_to_success="<div class='bg-warning'>Выплата отменена</div>" 

       {#// эти строчки для второго запроса // будет отправлен если они есть#}
       {#ajax2_link='/vendor/didrive_mod/items/3/micro-service/delete-items.php'#}
       {#ajax2_vars='r_module=sp_ocenki_job_day&remove[sale_point]={{ sp_now }}&remove[date]={{ date }}'#}

       ><span class="fa fa-remove"></span></a>
    <div id="pa{{ pay.id }}" style="display:none;"></div>
