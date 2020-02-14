$().ready(function () {


    /**
     * jobdesc удаление оценки дня если есть параметры
     * var $delete_ocenka_day = $(this).attr('delete_ocenka_day');
     * var $delete_ocenka_sp = $(this).attr('delete_ocenka_sp');
     * @param {type} $sp
     * @param {type} $date
     * @returns {Boolean}
     */
    function didrive__jobdesc__delete_day_ocenka($sp, $date, $s) {

        // alert( $sp + ' = ' + $date + ' = ' + $s );

        $.ajax({

            type: 'POST',
            url: '/vendor/didrive_mod/jobdesc/1/didrive/ajax.php',
            dataType: 'json',
            data: "action=delete_ocenka&sp=" + $sp + "&date=" + $date + "&s=" + $s,

            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                // $div_res.html('<img src="/img/load.gif" alt="" border="" />');
                // $this.css({"border": "2px solid orange"});
            },
            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($data) {

//                // eсли oбрaбoтчик вeрнул oшибку
                if ($data['status'] == 'error')
                {
                    console.log('не удаляем оценку дня - ошибка');
//
//                    // alert($data['error']); // пoкaжeм eё тeкст
//                    //$div_res.html('<div class="warn warn">' + $data['html'] + '</div>');
//                    $this.css({"border": "2px solid red"});
//
                }
//                // eсли всe прoшлo oк
                else
                {
                    console.log('не удаляем оценку дня - норм');
//
//                    // $div_res.html('<div class="warn good">' + $data['html'] + '</div>');
//                    $this.css({"border": "2px solid green"});
//                    $a_pole_price_id.html($a_text_in_pole_price_id);
//
                }

            }
            ,
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                // пoкaжeм oтвeт сeрвeрa
                alert(xhr.status + ' ' + thrownError); // и тeкст oшибки
            }

// сoбытиe пoслe любoгo исхoдa
// ,complete: function ($data) {
// в любoм случae включим кнoпку oбрaтнo
// $form.find('input[type="submit"]').prop('disabled', false);
// }

        }); // ajax-


        return true;
    }

    /**
     * редактируем доп поле
     * @param {type} e
     * @returns {Boolean}
     */
    var didrive__edit_items_dop_pole = function (e) {

        // alert(e);

        var $this = $(this);
        // var $this = e;
        var $val = $(this).val();
        // var $val = $this.val();

        var $a_item_id = $(this).attr('edit_item_id');
        // var $a_item_id = $this.attr('edit_item_id');
        var $a_dop_name = $(this).attr('edit_dop_name');
        // var $a_dop_name = $this.attr('edit_dop_name');
        var $a_s = $(this).attr('edit_s');
        // var $a_s = $this.attr('edit_s');

        var $a_pole_price_id = $('#' + $(this).attr('pole_price_id'));
        var $a_text_in_pole_price_id = $(this).attr('text_in_pole_price_id');

        /**
         * удаляем оценку если есть 2 переменные
         * @type jQuery
         */
        var $delete_ocenka_date = $(this).attr('delete_ocenka_date');
        var $delete_ocenka_sp = $(this).attr('delete_ocenka_sp');
        var $delete_ocenka_s = $(this).attr('delete_ocenka_s');

        if ($delete_ocenka_date == null || $delete_ocenka_sp == null || $delete_ocenka_s == null) {
            console.log('не удаляем оценку дня');
        } else {
            console.log('удаляем оценку дня');
            didrive__jobdesc__delete_day_ocenka($delete_ocenka_sp, $delete_ocenka_date, $delete_ocenka_s);
        }








//        if ($.fn.jobdesc_di__delete_day_ocenka2) {
//            jobdesc_di__delete_day_ocenka2(1, 33);
//            console.log('есть функция', 'jobdesc_di__delete_day_ocenka');
//        } else {
//            console.log('нет функции', 'jobdesc_di__delete_day_ocenka');
//        }




        $.ajax({

            type: 'POST',
            url: '/vendor/didrive/base/ajax.php',
            dataType: 'json',
            data: "action=edit_items_dop&item_id=" + $a_item_id + "&dop_pole=" + $a_dop_name + "&val=" + $val + "&s=" + $a_s,

            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                // $div_res.html('<img src="/img/load.gif" alt="" border="" />');
                $this.css({"border": "2px solid orange"});
            },
            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($data) {

                // eсли oбрaбoтчик вeрнул oшибку
                if ($data['status'] == 'error')
                {

                    // alert($data['error']); // пoкaжeм eё тeкст
                    //$div_res.html('<div class="warn warn">' + $data['html'] + '</div>');
                    $this.css({"border": "2px solid red"});

                }
                // eсли всe прoшлo oк
                else
                {

                    // $div_res.html('<div class="warn good">' + $data['html'] + '</div>');
                    $this.css({"border": "2px solid green"});

                    /**
                     * если есть эти параметры то печатаем в блок нужный текст
                     */
                    if ($a_pole_price_id == null || $a_text_in_pole_price_id == null) {

                    } else {
                        $a_pole_price_id.html($a_text_in_pole_price_id);
                    }

                }

            }
            ,
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                // пoкaжeм oтвeт сeрвeрa
                alert(xhr.status + ' ' + thrownError); // и тeкст oшибки
            }

// сoбытиe пoслe любoгo исхoдa
// ,complete: function ($data) {
// в любoм случae включим кнoпку oбрaтнo
// $form.find('input[type="submit"]').prop('disabled', false);
// }

        }); // ajax-

        return false;

    };

    $('body').on('keyup input', '.didrive__edit_items_dop_pole', $.debounce(1000, didrive__edit_items_dop_pole));



    /* грузим базовый модаль и ставим нужные данные
     <a 
     href="#" 
     
     class="dropdown-item btn-light base_modal_go"
     
     data-toggle="modal" data-target="#di_modal" 
     
     modal_header='назначения сотрудника'
     ajax_link='/vendor/didrive_mod/jobdesc/1/didrive/ajax.php'
     ajax_vars='action=show_naznach&view=html&user={{ man.id }}&s={{ creatSecret( man.id ) }}'
     
     >
     список назначений сотрудника
     </a>
     */

    $('body').on('click', '.base_modal_go', function (event) {

        console.log('click .base_modal_go > открыть басе модаль');

        $th = $(this);

        $header = $th.attr('modal_header');
        $('#di_modal #di_modal_header').html($header);

        $link = $th.attr('ajax_link'); // - || +
        $vars = $th.attr('ajax_vars'); // - || +



// спросить делаем не делаем
        $get_answer = false;

// обновить страницу если загрузили аякс с норм ответом
        $reload_page_after_ok = false;

        $.each(this.attributes, function () {

            if (this.specified) {

//                if (this.name.indexOf("forajax_") != -1) {
//                    $uri_query = $uri_query + '&' + this.name.replace('forajax_', '') + '=' + this.value;
//                    console.log(this.name, this.value);
//                }
//                $uri_query = $uri_query + '&' + this.name.replace('forajax_', '') + '=' + this.value;

//                if (this.name == 'hidethis') {
//                    hidethis = 1;
//                }

//                if (this.name == 'sp') {
//                    sp = this.value;
//                } else if (this.name == 'date') {
//                    date = this.value;
//                } else if (this.name == 'res_to_id') {
//                    resto = '#' + this.value;
//                } else if (this.name == 'answer') {
//                    answer = this.value;
//                }

                if (this.name == 'reload_page_after_ok') {
                    $reload_page_after_ok = 'ok';
                } else if (this.name == 'get_answer') {
                    $get_answer = this.value;
                }

            }

        });

// спрашиваем если нужно задать вопрос
        if ($get_answer != false) {
            if (!confirm($get_answer))
                return false;
        }

        // console.log($link, $vars);

        $.ajax({

            type: 'POST',
            url: $link,
            dataType: 'json',
            data: $vars,

            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                $('#di_modal .modal-body').html('<img src="/img/load.gif" alt="" border="" />');
                // $this.css({"border": "2px solid orange"});
                $("body").append("<div id='body_block' class='body_block' >пару секунд вычисляем<br/><span id='body_block_465'></span></div>");
            },
            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($data) {

                $('#di_modal .modal-body').html($data['html']);

// если ошибка
                if ($data['status'] == 'error') {
                    $('#body_block').remove();
                }
// если не оиибка                
                else {

                    // если стоит атрибут reload_page_after_ok с каким нить значением и перезагружаем страницу
                    if ($reload_page_after_ok != false) {
                        $('#body_block_465').html('<div style="background-color:rgba(0,250,0,0.3);color:black;padding:5px;">готово, обновляю страницу</div>');
                        location.reload();
                    }

                }

//                // eсли oбрaбoтчик вeрнул oшибку
//                if ($data['status'] == 'error')
//                {
//
//                    // alert($data['error']); // пoкaжeм eё тeкст
//                    //$div_res.html('<div class="warn warn">' + $data['html'] + '</div>');
//                    $this.css({"border": "2px solid red"});
//
//                }
//                // eсли всe прoшлo oк
//                else
//                {
//
//                    // $div_res.html('<div class="warn good">' + $data['html'] + '</div>');
//                    $this.css({"border": "2px solid green"});
//
//                    // если есть эти параметры то печатаем в блок нужный текст
//                    if ($a_pole_price_id == null || $a_text_in_pole_price_id == null) {
//
//                    } else {
//                        $a_pole_price_id.html($a_text_in_pole_price_id);
//                    }
//
//                }

            }
            ,
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                // пoкaжeм oтвeт сeрвeрa
                alert(xhr.status + ' ' + thrownError); // и тeкст oшибки
            }

// сoбытиe пoслe любoгo исхoдa
// ,complete: function ($data) {
// в любoм случae включим кнoпку oбрaтнo
// $form.find('input[type="submit"]').prop('disabled', false);
// }

        }); // ajax-




    });


});