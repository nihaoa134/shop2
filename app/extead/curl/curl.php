<?php
class url{
    function sendGet($str){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $str);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        $info = curl_exec($ch);
        curl_close($ch);
        return $info;
    }

    function sendPost($url,$arr){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD,true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        $info = curl_exec($ch);
        curl_close($ch);
        return $info;
    }
    function arr2Xml( $arr ){
        $xml = '<xml version="1.0" encoding="UTF-8"> ';
        foreach(  $arr as $key => $value ){
            if (is_numeric($value)){
                $xml.="<".$key.">".$value."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$value."]]></".$key.">";
            }

        }
        $xml .= '</xml>';
        return $xml;
    }
}