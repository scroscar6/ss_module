<?php
    class XSS{
        static function stripData($data) {
            return ini_get('magic_quotes_gpc') ? stripslashes($data) : $data;
        }
        static function prepareData($data) {
            return ini_get('magic_quotes_gpc') ? $data : addslashes($data);
        }
        static function compData($data) {
            return ini_get('magic_quotes_gpc') ? addslashes($data) : $data;
        }
        static function LimpiarXSS($tags){
            $tags = strip_tags($tags);
            $tags = stripslashes($tags);
            $tags = htmlentities($tags,ENT_QUOTES,'UTF-8');
            $tags = trim($tags);
            return $tags;
        }
        function A(){

        }
        static function LimpiarCampo($tags){
            $tags = str_replace(array("<div>","</div>"),array("",""), $tags);
            $tags = strip_tags($tags,"<a><p><u><em><strong><b><i><img><h1><h2><h3><h4><h5><h6><ol><ul><li><br><br/><table><tr><th><td><strike><sup><sub><span><blockquote><hr><s><del><embed>");
            $tags = trim($tags);
            return $tags;
        }
        static function AlfaNumericoSS($cadena){
            $consev = '0-9a-z'; // juego de caracteres a conservar
            $regex = sprintf('~[^%s]++~i', $consev); // case insensitive
            $cadena = preg_replace($regex, '', $cadena);
            return $cadena;
        }
        static function iTexto($itexto){
            $itexto = utf8_encode(str_replace("\\","",trim($itexto)));
            $itexto = str_replace(array('&','"',"'"),array("&amp;","&quot;","&#039;"), trim($itexto));
            $sustituye = array("\r\n", "\n\r", "\n", "\r");
            $itexto = str_replace($sustituye, " ", $itexto);
            return trim($itexto);
        }
        static function iDescription($itexto){
            $itexto = str_replace(array('&','<','>'),array("&amp;",'&lt;','&gt;'), $itexto);
            $itexto = utf8_encode(str_replace("\\","",trim($itexto)));
            //$itexto = str_replace(array('"',"'"),array("&quot;","&#039;"), trim($itexto));
            return $itexto;
        }
        static function iDescription1($itexto1){
            $itexto1 = str_replace(array("&","\\"),array("&amp;",""), $itexto1);
            $itexto1 = htmlspecialchars_decode($itexto1);
            return trim($itexto1);
        }
        static function iDescriptionAddEdit($itexto){
            $itexto = utf8_encode(preg_replace("/<br \/>/","\n",trim($itexto)));
            //$itexto = str_replace(array('"',"'"),array("&quot;","&#039;"), trim($itexto));
            return $itexto;
        }
        static function dameURL(){
            $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            return htmlentities(trim($url));
        }
        static function dameHOST(){
            $url="http://".$_SERVER['HTTP_HOST'];
            return htmlentities(trim($url));
        }
        static function xsFloat($float = 0.00){
            $float = number_format((float)$float, 2, '.', '');
            return trim($float);
        }
        static function xsFloatRound($float = 0){
            $float = number_format((float)$float, 0, '.', '');
            $float = round($float);
            return trim($float);
        }
        static function valFecha($fecha = ''){
            return preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $fecha);
        }
        static function valFechaN($fecha = ''){
            return preg_match('/^\d{1,2}\-\d{1,2}\-\d{4}$/', $fecha);
        }
        static function valFechaM($fecha = ''){
            return preg_match('/^\d{4}\-\d{1,2}\-\d{1,2}$/', $fecha);
        }
        static function diaSemana($anio,$mes,$dia){
            setlocale(LC_ALL,"es_ES");
            $anio_s = $dia.'-'.$mes.'-'.$anio;
            if(valFechaN($anio_s)){
                $dias = array("dom","lun","mar","mié","jue","vie","sáb");
                $dia_s = date('w',strtotime($anio_s));
                return $dias[$dia_s];
            }else{
                return 0;
            }
        }
        static function LoadClase($dir='', $name=''){
            $DirClass = SSMODULO.$dir.DS.'Clases'.DS.$name.'.php';
            if(file_exists($DirClass)){
                include($DirClass);
            }else{
                die('<strong>ERROR: </strong>La clase <strong>"'.$name.'"</strong> faltante, revise.');
            }
        }
        static function LoadClaseAJAX($dir='', $name=''){
            $DirClass = '../../../'.SSMODULO.$dir.DS.'Clases'.DS.$name.'.php';
            if(file_exists($DirClass)){
                include($DirClass);
            }else{
                die('<strong>ERROR: </strong>La clase <strong>"'.$name.'"</strong> faltante, revise.');
            }
        }
        static function IdVideoYT($urlyt){
            $video_id = '';
            if(preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $urlyt, $match)) {
                $video_id = trim($match[1]);
            }
            return $video_id;
        }
    }
?>