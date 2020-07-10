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
    >aaaaaa</a>
<div id="com' + ar['id'] + '" style="display:none;"></div>
