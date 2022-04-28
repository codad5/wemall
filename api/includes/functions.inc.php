<?php

/**
 * @param mixed $datas
 * @return bool 
 * return `false` whem any of the passed parameters are null or not set
 * 
 * else return `true`
 * 
 */
function has_value(...$datas) :  bool{
    foreach($datas as $data):
        if(is_null($data) || !isset($data)):
            return false;
        endif;
    endforeach;
    return true;
}