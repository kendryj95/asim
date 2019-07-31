<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('formato_fecha_entrada'))
{
    function formato_fecha_entrada($var = '')
    {
        if($var != ''){
            $arrayFecha =  explode('/',$var);
            $day        = $arrayFecha[0];
            $month      = $arrayFecha[1];
            $year       = $arrayFecha[2];

            return $year.'-'.$month.'-'.$day;
        }else{
            return '0000-00-00';
        }
    }
}

if ( ! function_exists('formato_fecha_salida'))
{
    function formato_fecha_salida($var = '')
    {
        if($var != ''){

            if($var != '0000-00-00'){
                return date('d/m/Y',strtotime($var));
            }else{
                return '';
            }

        }else{
            return '';
        }
    }
}



if ( ! function_exists('meses_espanol'))
{
    function meses_espanol($mes)
    {

        $formato = '';

        switch ($mes) {
            case "1":
                $formato .= "Enero";
                break;
            case "2":
                $formato .= "Febrero";
                break;
            case "3":
                $formato .= "Marzo";
                break;
            case "4":
                $formato .= "Abril";
                break;
            case "5":
                $formato .= "Mayo";
                break;
            case "6":
                $formato .= "Junio";
                break;
            case "7":
                $formato .= "Julio";
                break;
            case "8":
                $formato .= "Agosto";
                break;
            case "9":
                $formato .= "Septiembre";
                break;
            case "10":
                $formato .= "Octubre";
                break;
            case "11":
                $formato .= "Noviembre";
                break;
            case "12":
                $formato .= "Diciembre";
                break;
            default:
                break;
        }

        return $formato;
    }
}