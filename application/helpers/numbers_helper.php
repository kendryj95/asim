<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('formato_entrada'))
{
    function formato_entrada($var = '')
    {
        $numero =  str_replace('.','',$var) ;
        $numero =  str_replace(',','.',$numero) ;
        return $numero;
    }
}

if ( ! function_exists('formato_salida'))
{
    function formato_salida($var = '')
    {
        if($var != ''){
            $numero = number_format($var,2,',','.');
            return $numero;
        }else{
            return '';
        }

    }
}

?>
