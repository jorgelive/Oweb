<?php

namespace Gopro\MainBundle\Service;

use \Symfony\Component\DependencyInjection\ContainerAwareInterface;
use \Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Variableproceso implements ContainerAwareInterface{

    use ContainerAwareTrait;


    public function sanitizeString($str, $with = '', $what = array())
    {
        if(!is_array($what)){
            $what = [$what];
        }
        $what[] = "/[\\x00-\\x20]+/";
        $what[] = "/[']+/";
        $what[] = "/[(]+/";
        $what[] = "/[)]+/";
        $what[] = "/[-]+/";
        $what[] = "/[+]+/";
        $what[] = "/[*]+/";
        $what[] = "/[,]+/";
        $what[] = "/[\/]+/";
        $what[] = "/[\\\\]+/";
        $what[] = "/[?]+/";

        $withArray = [];
        foreach ($what as $dummy):
            $withArray[] = $with;
        endForeach;

        $proceso = trim(preg_replace($what, $withArray, $str));
        return $proceso;
    }

    public function sanitizeQuery($query, $tipo='select')
    {
        if($tipo=='select'){
            $what[] = "/insert/i";
            $what[] = "/update/i";
        }
        $what[] = "/;/";
        $what[] = '/"/';
        $with=array();

        foreach ($what as $dummy):
            $with[]='';
        endForeach;

        $what[] = "/\s/";
        $with[] = ' ';

        $proceso = trim(preg_replace($what, $with, $query));
        return preg_replace('/\s+/', ' ', $proceso);;
    }

    public function utf($variable,$tipo='to')
    {
        $encodings[]='Windows-1250';
        $encodings[]='UTF-8';
        if($tipo!='to'){
            array_reverse($encodings);
        }
        if(is_string($variable)){
            return iconv($encodings[0], $encodings[1], $variable);
        }elseif(is_array($variable)){
            array_walk_recursive(
                $variable,
                function (&$entry,$key,$encodings) {
                    $entry = iconv($encodings[0], $encodings[1], $entry);
                },
                $encodings
            );
            return $variable;
        }
        return null;
    }

    public function exceltime($variable, $tipo='from')
    {
        if(empty($variable)){
            return $variable;
        }
        if($tipo=='from'){

            if((!is_numeric($variable) && strpos($variable, ':') > 0) || $variable >= 1 ){
                $variable = str_replace(':', '', $variable);
                if(strlen($variable) == 4){
                    $variable = $variable . '00';
                }
                if(strlen($variable) != 6){
                    return $variable;
                }else{
                    return(date('H:i:s', strtotime(substr($variable, 0, 2) . ':' . substr($variable, 2, 2) . ':' . substr($variable, 4, 2))));
                }
            }elseif(is_numeric($variable)){
                $variable = $variable * 24;

                $hora = intval($variable);
                $variable = ($variable - $hora) * 60;
                $minuto = intval($variable);

                $segundo = intval(($variable - $minuto) * 60);
                return date('H:i:s', strtotime($hora . ':' . $minuto . ':' . $segundo));
            }else{
                return $variable;
            }

        }else{
            $variable = str_replace(':', '', $variable);
            if(strlen($variable) != 6 || !is_numeric($variable)){
                return $variable;
            }
            return (substr($variable, 0, 2) / 24) + (substr($variable, 2, 2) / 1440) + (substr($variable, 4, 2) / 86400);
        }
    }

    public function exceldate($variable,$tipo='from')
    {
        if(empty($variable)){
            return $variable;
        }
        if($tipo=='from'){

            if(!is_numeric($variable) && (strpos($variable, '-') > 0 || strpos($variable, '/') > 0)){
                return date('Y-m-d', strtotime(str_replace('/', '-', $variable)));
            }elseif(is_numeric($variable)){
                return date('Y-m-d', mktime(0,0,0,1,$variable-1,1900));
            }else{
                return $variable;
            }

        }else{
            return unixtojd(strtotime($variable)) - gregoriantojd(1, 1, 1900) + 2;
        }
    }

    public function is_multi_array($array) {
        return (count($array) != count($array, 1));
    }


}