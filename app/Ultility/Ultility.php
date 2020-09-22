<?php

namespace App\Ultility;

use App\Category;

class Ultility
{
   public static function createSlug($string,  $delimiter='-') {
       $unicode = array(

           'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

           'd'=>'đ',

           'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

           'i'=>'í|ì|ỉ|ĩ|ị',

           'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

           'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

           'y'=>'ý|ỳ|ỷ|ỹ|ỵ',

           'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

           'D'=>'Đ',

           'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

           'I'=>'Í|Ì|Ỉ|Ĩ|Ị',

           'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

           'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

           'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
           

       );

       foreach($unicode as $nonUnicode=>$uni){

           $string = preg_replace("/($uni)/i", $nonUnicode, $string);

       }

       $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
       $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
       $clean = strtolower(trim($clean, '-'));
       $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

       return strtolower($clean);
   }
    public static function textLimit($str,$limit=10)
    {
        if(stripos($str," ")){
            $str_s = '';
            $ex_str = explode(" ",$str);
            if(count($ex_str)>$limit){
                for($i=0;$i<$limit;$i++){
                    $str_s.=$ex_str[$i]." ";
                }
                $str_s .= '...';
                return $str_s;
            }

            return $str;
        }

        return $str;
    }

   public static function get_client_ip() {
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        
        return $ipaddress;
    }

    public static function getCurrentUrl() {
        return $_SERVER['REQUEST_URI'];
    }

}
