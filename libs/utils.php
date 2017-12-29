<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function cleanText($str){
		
    $str = preg_replace('/[^(\x20-\x7F)\x0A]*/','', $str);
    //$str = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $str);
    //$str = preg_replace('/[^(\x20-\x7F)]*/','', $str);
    return $str;
}

function htpass($pass)
{
    return crypt($pass,ENCRYPT);
}
?>