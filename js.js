
$(document).ready(function () {

//    window.nyos = [];
//    window.nyos.dolgn = ['123'];

    didrive__get_cash = function (e) {

//        if (typeof window['nyos'] !== 'undefined')
//            window['nyos'] = [];
//
        if (typeof window !== 'undefined' &&
                typeof window.nyos !== 'undefined' &&
                typeof window.nyos.dolgn !== 'undefined' && window.nyos.dolgn | length > 0)
            return [ 1, window.nyos.dolgn ];
//
//        return window['nyos']['dolgn'];

        window.nyos = ['dodo'];
        window.nyos.dolgn = ['234234'];
        return [ 2 , window.nyos.dolgn ];

        // return ['dolgn'];
    };

    // didrive__creat_cash();

    /**
     * добавляем заменяем запись в items (1 значение указанов форме, остальные фикс в аттрибутах)
     * @param {type} e
     * @returns {Boolean}
     */

    var didrive__items__new_edit = function (e) {

        var $this = $(this);

        var uri_query = '';

        $.each(this.attributes, function () {

            if (this.specified) {

                if (this.name == 'href') {

                } else if (this.name == 'class') {

                } else if (this.name == 'style') {

                } else if (this.name == 'value') {

                } else {

                    uri_query = uri_query + '&' + this.name + '=' + this.value;

                }


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

//                if (this.name == 'reload_page_after_ok') {
//                    $reload_page_after_ok = 'ok';
//                } else if (this.name == 'get_answer') {
//                    $get_answer = this.value;
//                    console.log('ключ в атрибутах', this.name, this.value);
//                }

            }

        });

        uri_query = uri_query + '&value=' + $this.val();







//        // alert(e);
//
//        var $this = $(this);
//        // var $this = e;
//        var $val = $(this).val();
//        // var $val = $this.val();
//
//        var $a_item_id = $(this).attr('edit_item_id');
//        // var $a_item_id = $this.attr('edit_item_id');
//        var $a_dop_name = $(this).attr('edit_dop_name');
//        // var $a_dop_name = $this.attr('edit_dop_name');
//        var $a_s = $(this).attr('edit_s');
//        // var $a_s = $this.attr('edit_s');
//
//        var $a_pole_price_id = $('#' + $(this).attr('pole_price_id'));
//        var $a_text_in_pole_price_id = $(this).attr('text_in_pole_price_id');
//
//        /**
//         * удаляем оценку если есть 2 переменные
//         * @type jQuery
//         */
//        var $delete_ocenka_date = $(this).attr('delete_ocenka_date');
//        var $delete_ocenka_sp = $(this).attr('delete_ocenka_sp');
//        var $delete_ocenka_s = $(this).attr('delete_ocenka_s');
//
//        if ($delete_ocenka_date == null || $delete_ocenka_sp == null || $delete_ocenka_s == null) {
//            console.log('не удаляем оценку дня');
//        } else {
//            console.log('удаляем оценку дня');
//            didrive__jobdesc__delete_day_ocenka($delete_ocenka_sp, $delete_ocenka_date, $delete_ocenka_s);
//        }








//        if ($.fn.jobdesc_di__delete_day_ocenka2) {
//            jobdesc_di__delete_day_ocenka2(1, 33);
//            console.log('есть функция', 'jobdesc_di__delete_day_ocenka');
//        } else {
//            console.log('нет функции', 'jobdesc_di__delete_day_ocenka');
//        }




        $.ajax({

            type: 'POST',
            url: '/vendor/didrive_mod/items/1/ajax.php',
            dataType: 'json',
            // data: "action=edit_items_dop&item_id=" + $a_item_id + "&dop_pole=" + $a_dop_name + "&val=" + $val + "&s=" + $a_s,
            data: "a=a&" + uri_query,

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

    $(document).on('keyup input', '.didrive__items__new_edit', $.debounce(1000, didrive__items__new_edit));









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
        
        
        
        
        
        
        var $uri_query = '';

        $.each(this.attributes, function () {

            if (this.specified) {

                // пропускаем атрибуты
                if (this.name == 'style' || this.name == 'class' || this.name == 'href') {

                }
                // обрабатываем атрибуты
                else {

                    // console.log(this.name, this.value);
                    $uri_query = $uri_query + '&in_' + this.name + '=' + this.value;
////
//                    if (1 == 2) {
//
//                    }
//                    //
//                    else if (this.name == 'hidethis' && this.value == 'da') {
//                        hidethis = 1;
//                    }
//
//                    // куда шлём указываем в href
//                    else if (this.name == 'href_to_ajax') {
//                        href_to_ajax = this.value;
//                    }
//                    // 
//                    else if (this.name == 'return' && this.value == 'false') {
//                        return1 = false;
//                    }
//                    //
//                    else if (this.name == 'after_click_showid') {
//                        after_click_showid = $('#' + this.value);
//                    }
//                    // сообщение в случае удачи
//                    else if (this.name == 'msg_to_success') {
//                        msg_to_success = this.value;
//                    }
//                    //
//                    else if (this.name == 'answer') {
//                        answer = this.value;
//                    }
////                    else if (this.name == 'msg_to_success') {
////                        msg_to_success = this.value;
////                    } 
//                    else if (this.name == 'res_to_id') {
//                        res_to_id = $('#' + this.value);
//                        //console.log($vars['resto']);
//                        // alert($res_to);
//                    } else if (this.name == 'result_success_text') {
//                        result_success_text = this.value;
//                        //console.log($vars['resto']);
//                        // alert($res_to);
//                    } else if (this.name == 'show_res') {
//                        show_res = 'da';
//                        //console.log($vars['resto']);
//                        // alert($res_to);
//                    }
//
//                if (this.name == 'show_on_click') {
//                    $('#' + this.value).show('slow');
//                }

                }
            }

        });

        
        
//        
//        
//        
//        
//        
//        // var $this = e;
        var $val = $(this).val();
//        // var $val = $this.val();
//
//
//
//        var $a_item_id = $(this).attr('edit_item_id');
//        // var $a_item_id = $this.attr('edit_item_id');
//        var $a_dop_name = $(this).attr('edit_dop_name');
//        // var $a_dop_name = $this.attr('edit_dop_name');
//        var $a_s = $(this).attr('edit_s');
//        // var $a_s = $this.attr('edit_s');
//
//        var $a_pole_price_id = $('#' + $(this).attr('pole_price_id'));
//        var $a_text_in_pole_price_id = $(this).attr('text_in_pole_price_id');
//
//        
//
//        /**
//         * удаляем оценку если есть 2 переменные
//         * @type jQuery
//         */
//        var $delete_ocenka_date = $(this).attr('delete_ocenka_date');
//        var $delete_ocenka_sp = $(this).attr('delete_ocenka_sp');
//        var $delete_ocenka_s = $(this).attr('delete_ocenka_s');
//
//
//
//
//
//
//
//        if ($delete_ocenka_date == null || $delete_ocenka_sp == null || $delete_ocenka_s == null) {
//            console.log('не удаляем оценку дня');
//        } else {
//            console.log('удаляем оценку дня');
//            didrive__jobdesc__delete_day_ocenka($delete_ocenka_sp, $delete_ocenka_date, $delete_ocenka_s);
//        }

//        if ($.fn.jobdesc_di__delete_day_ocenka2) {
//            jobdesc_di__delete_day_ocenka2(1, 33);
//            console.log('есть функция', 'jobdesc_di__delete_day_ocenka');
//        } else {
//            console.log('нет функции', 'jobdesc_di__delete_day_ocenka');
//        }

        $.ajax({

            type: 'POST',
            url: '/vendor/didrive/base/micro-service/edit_items_dop.php',
            dataType: 'json',
//            data: "action=edit_items_dop&item_id=" + $a_item_id + "&dop_pole=" + $a_dop_name 
//                    + "&val=" + $val 
//                    + "&s=" + $a_s
//                    + "&data_json=" + $dada
//            ,
            data: "new_val="+ $val +"&" + $uri_query ,

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

    $(document).on('keyup input', '.didrive__edit_items_dop_pole', $.debounce(1000, didrive__edit_items_dop_pole));
    $(document).on('keyup input', '.didrive__edit_items_dop_pole2', function () {


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

    });

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
                    console.log('ключ в атрибутах', this.name, this.value);
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
                if ($reload_page_after_ok != false) {
                    $("body").append("<div id='body_block' class='body_block' >пару секунд вычисляем<br/><span id='body_block_465'></span></div>");
                }

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

// alert('123123');

    $(document).on('click', '.base__send_to_ajax', function (event) {

        console.log('.base__send_to_ajax', '/nyos/base/js.js');

//        return false;

        //alert('2323');
//        $(this).removeClass("show_job_tab");item_id
//        $(this).addClass("show_job_tab2");
//        var $uri_query = '';
//        var $vars = [];
        // var $vars = serialize(this.attributes);
        // var $vars =  JSON.stringify(this.attributes);

        var res_to_id = 0;

//        var $vars = new Array();
        var $uri_query = '';
        var hidethis = 0;
        var after_click_showid = 0;
        var answer = 0;
        /**
         * сообщение в случае удачи
         * @type Number|jsL#1#L#372.value
         */
        var msg_to_success = 0;
        var return1 = 0;
        var href_to_ajax = 0;

        var show_res = 0;
        var result_success_text = 0;

        $.each(this.attributes, function () {

            if (this.specified) {

                // пропускаем атрибуты
                if (this.name == 'style' || this.name == 'class' || this.name == 'href') {

                }
                // обрабатываем атрибуты
                else {

                    // console.log(this.name, this.value);
                    // $uri_query = $uri_query + '&' + this.name + '=' + this.value.replace(' ', '..')
                    $uri_query = $uri_query + '&' + this.name + '=' + this.value;
//
                    if (1 == 2) {

                    }
                    //
                    else if (this.name == 'hidethis' && this.value == 'da') {
                        hidethis = 1;
                    }

                    // куда шлём указываем в href
                    else if (this.name == 'href_to_ajax') {
                        href_to_ajax = this.value;
                    }
                    // 
                    else if (this.name == 'return' && this.value == 'false') {
                        return1 = false;
                    }
                    //
                    else if (this.name == 'after_click_showid') {
                        after_click_showid = $('#' + this.value);
                    }
                    // сообщение в случае удачи
                    else if (this.name == 'msg_to_success') {
                        msg_to_success = this.value;
                    }
                    //
                    else if (this.name == 'answer') {
                        answer = this.value;
                    }
//                    else if (this.name == 'msg_to_success') {
//                        msg_to_success = this.value;
//                    } 
                    else if (this.name == 'res_to_id') {
                        res_to_id = $('#' + this.value);
                        //console.log($vars['resto']);
                        // alert($res_to);
                    } else if (this.name == 'result_success_text') {
                        result_success_text = this.value;
                        //console.log($vars['resto']);
                        // alert($res_to);
                    } else if (this.name == 'show_res') {
                        show_res = 'da';
                        //console.log($vars['resto']);
                        // alert($res_to);
                    }
//
//                if (this.name == 'show_on_click') {
//                    $('#' + this.value).show('slow');
//                }

                }
            }

        });


//        alert($uri_query);
//        return false;

        // console.log($vars['resto']);

        if (answer != 0 && !confirm(answer)) {
            if (res_to_id != 0) {
                res_to_id.html('');
            }
            return false;
        }

// если нет пути к php ajax то возвращаем ошибку
        if (href_to_ajax == 0) {
            console.log('не указан путь к обработчику ajax, возвращаем false');
            return false;
        }

        // console.log($uri_query);
        //$(this).html("тут список");
        var $th = $(this);

        $.ajax({

            url: href_to_ajax,
            data: "t=1" + $uri_query,
            cache: false,
            dataType: "json",
            type: "post",

            beforeSend: function () {

                if (res_to_id != 0) {
                    res_to_id.html('<img src="/img/load.gif" alt="... обработка ..." border="0" style="max-width:75px;" />');
                }

                if (after_click_showid != 0) {
                    after_click_showid.show('slow');
                }

                /*
                 if (typeof $div_hide !== 'undefined') {
                 $('#' + $div_hide).hide();
                 }
                 */
                // $("#ok_but_stat").html('<img src="/img/load.gif" alt="" border=0 />');
//                $("#ok_but_stat").show('slow');
//                $("#ok_but").hide();

            }
            ,

            success: function ($j) {

                //alert(resto);

                // $($res_to).html($j.data);
                // $($vars['resto']).html($j.data);
                // $(resto).html($j.html);

                if ($j.status == 'ok') {

                    if (hidethis == 1) {
                        $th.hide();
                    }

                    if (msg_to_success != 0) {
                        res_to_id.html('<b class="warn" >' + msg_to_success + '</b>');
                    } else {
                        // res_to_id.html('<b class="warn" >' + $j.html + '</b>');
                        res_to_id.html('<b class="bg-success" style="padding:5px 10px;" >' + $j.html + '</b>');
                    }

                    // $th("#main").prepend("<div id='box1'>1 блок</div>");                    
                    // $th("#main").prepend("<div id='box1'>1 блок</div>");                    
                    // $th("#main").prepend("<div id='box1'>1 блок</div>");                    
                    // $th.html( $j.html + '<br/><A href="">Сделать ещё заявку</a>');
                    // $($res_to_id).html( $j.html + '<br/><A href="">Сделать ещё заявку</a>');

                    // return true;

                    /*
                     // alert($j.html);
                     if (typeof $div_show !== 'undefined') {
                     $('#' + $div_show).show();
                     }
                     */
//                $('#form_ok').hide();
//                $('#form_ok').html($j.html + '<br/><A href="">Сделать ещё заявку</a>');
//                $('#form_ok').show('slow');
//                $('#form_new').hide();
//
//                $('.list_mag').hide();
//                $('.list_mag_ok').show('slow');

                }
// если ошибка
                else {

//                    if (res_error_show_id != 0) {
//                        $(res_error_show_id).show('slow');
//                    }

                    res_to_id.html('<b class="bg-warning" style="padding:5px 10px;" >' + $j.html + '</b>');

                }
            }

        });

        if (return1 == false)
            return false;

    });

});