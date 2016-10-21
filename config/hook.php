<?php

//Exemple pour languae auto detect:
/*Conf::$hooks['pre_load'] = array(
    array(
        'class' => 'LanguageHook',
        'method' => 'run',
        'params' => array()
    ),
);*/

Conf::$hooks['after_load'] = array(
    array(
        'class' => 'MainHook',
        'method' => 'run',
        'params' => array()
    ),
);

