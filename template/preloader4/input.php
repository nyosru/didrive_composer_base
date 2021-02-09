<?php

$vv['preloader_start'] = '<link href="/vendor/didrive/base/template/preloader4/css.min.css" rel="stylesheet" />'
        . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/template/preloader4/up.htm');

$vv['preloader_fin'] = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/template/preloader4/down.htm');


/*

вставить в шаблон 

{% if preloader_start is defined %}
{{ preloader_start }}
{% endif %}

{% if preloader_fin is defined %}
{{ preloader_fin }}
{% endif %}

*/