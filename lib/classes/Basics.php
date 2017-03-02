<?php
class Basics {

    public static function shortStringByWords($string, $wordsreturned){
        $retval = $string;
        $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $string);
        $string = str_replace("\n", " ", $string);
        $array = explode(" ", $string);
        if (count($array)<=$wordsreturned){
            $retval = $string;
        }else{
            array_splice($array, $wordsreturned);
            $retval = implode(" ", $array)."...";
        }
        return $retval;
    }

    public static function slugify($string){
        $string = preg_replace('~[^\pL\d]+~u', '-', $string);
        $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
        $string = preg_replace('~[^-\w]+~', '', $string);
        $string = trim($string, '-');
        $string = preg_replace('~-+~', '-', $string);
        $string = strtolower($string);
        if (empty($string)) {
            return 'n-a';
        }
        return $string;
    }


    public static function validateInt($int){
        if(filter_var($int, FILTER_VALIDATE_INT)){
            return true;
        }else{
            return false;
        }
    }

    public static function validateFloat($float){
        $regex = '/^\s*[+\-]?(?:\d+(?:\.\d*)?|\.\d+)\s*$/';
        return preg_match($regex, $float);
    }


    public static function validateEmail($string){
        if(filter_var($string, FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            return false;
        }
    }


    public static function hashPassword($string){
        $string = password_hash($string, PASSWORD_DEFAULT);
        return $string;
    }

    public static function verifyPassword($string, $hash){
        return password_verify($string, $hash);
    }


    public static function FahrenheitToCelsius($fahrenheit){
        $celsius = ($fahrenheit - 32) / 1.8;
        return $celsius;
    }

    public static function CelsiusToFahrenheit($celsius){
        $fahrenheit = ($celsius * 9/5) + 32;
        return $fahrenheit;
    }

    public static function secondsBetweenDates($date1, $date2){

        $date1  = strtotime($date1);
        $date2 = strtotime($date2);
        return $date2 - $date1;
    }

    public static function secondsToTime($seconds) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        $days = $dtF->diff($dtT)->format('%a');
        $hours = $dtF->diff($dtT)->format('%h');
        $minutes = $dtF->diff($dtT)->format('%i');
        $time = "";
        if($days!=0){
            if($days==1){
                $time .= $days." day";
            }else{
                $time .= $days." days";
            }
            if($hours!=0){
                $time .= ", ";
            }
        }
        if($hours!=0){
            $time .= $hours." hours";
            if($minutes!=0){
                $time .= ", ";
            }
        }
        if($minutes!=0){
            $time .= $minutes." minutes";
        }

        return $time;
    }

}
