<?php
    class FUNCIONES{
        static function getRealIP() {
            if (!empty($_SERVER['HTTP_CLIENT_IP']))
                return $_SERVER['HTTP_CLIENT_IP'];
            if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            return $_SERVER['REMOTE_ADDR'];
        }
        static function ValidarModulos($variable,$Modulo){
            foreach ($variable as $permisos) {
                if (strstr($permisos,'modulo')) {
                    $permisos = explode('-',$permisos);
                    if ($Modulo == $permisos[1]){
                        $resultado = true;
                        return $resultado;
                    }else{
                        $resultado = false;
                    }
                }
            }
            return false;
        }
        static function ValidarPermisos($variable,$acceso){
            foreach ($variable as $permisos) {
                if (strstr($permisos,'acceso')) {
                    $permisos = explode('-',$permisos);
                    if ($acceso == $permisos[1]){
                        $resultado = true;
                        return $resultado;
                    }else{
                        $resultado = false;
                    }
                }
            }
            return false;
        }
        static function ValidarUsuarios($var,$tipo){
            new ClsConexion();
            $ObjUsuariosXXXXX = new ClsUsuarios();
            $ObjRolesXXXXX = new CLsRoles();
            if ($ObjUsuariosXXXXX->ObtenerXidTotal($_SESSION['ID'])['ESTADO'] == 1) {
                if ($ObjRolesXXXXX->ObtenerEstado($ObjUsuariosXXXXX->ObtenerXidTotal($_SESSION['ID'])['IDROL']) == 1) {
                    if ($ObjRolesXXXXX->ObtenerEstadoRolPermiso($ObjUsuariosXXXXX->ObtenerXidTotal($_SESSION['ID'])['IDROL']) == 1) {
                        $_SESSION['PERMISOS'] = $ObjUsuariosXXXXX->PermisosXUsuario($_SESSION['ID']);
                        switch ($tipo) {
                            case 'modulo':
                                return ValidarModulos($_SESSION['PERMISOS'],$var);
                                break;
                            case 'permiso':
                                return ValidarPermisos($_SESSION['PERMISOS'],$var);
                                break;
                            default:
                                exit();
                            break;
                        }
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        static function RutaCargaAjax(){
            $ruta = '../../../includes/autoload.php';
            return $ruta;
        }
        static function BorrarDirectorio($dirname) {
                if(file_exists($dirname)){
                    if (is_dir($dirname)){
                        $dir_handle = opendir($dirname);
                        ob_flush();
                        flush();
                    }
                    if (!$dir_handle)
                    return false;
                    while($file = readdir($dir_handle)){
                        if ($file != "." && $file != ".."){
                            chmod($dirname."/".$file, 0777);
                            if (!is_dir($dirname."/".$file) ) {
                                if(unlink($dirname."/".$file)){
                                    ob_flush();
                                    flush();
                                }else{
                                    ob_flush();
                                    flush();
                                }
                            }
                        else
                            delete_directory($dirname.'/'.$file);
                        }
                    }
                    closedir($dir_handle);
                    if(rmdir($dirname)){
                        ob_flush();
                        flush();
                    }else{
                        ob_flush();
                        flush();
                    }
                    return true;
                }
                return true;
        }
        static function LimpiarCampo111($tags){
            $tags = strip_tags($tags);
            $tags = trim($tags);
            return $tags;
        }
        static function zb_password($clavez){
            $salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
            $salt = '';
            for($i=0; $i < 6; $i++) {
                $salt .= $salt_chars[array_rand($salt_chars)];
            }
            $password = '$1$'.md5(sha1(md5($clavez))).'$';
            if(strlen($password)==36){ return $password; }
        }
        static function zbetter_crypt($input, $rounds = 7){
            $salt = "";
            $salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
            for($i=0; $i < 22; $i++) {
                $salt .= $salt_chars[array_rand($salt_chars)];
            }
            return crypt($input, sprintf('$2a$%02d$', $rounds) . $salt);
        }
        static function comprobar_clave($clave, $password_hash){
            if(crypt($clave, $password_hash) == $password_hash) {
                return true;
            }
        }
        static function validarUsuario($nombre){
            if (preg_match('#^[a-z][\da-z_]{4,16}[a-z\d]$#i', $nombre)) {
                return true;
            }else{
                return false;
            }
        }
        static function validarEmail($email){
            if (preg_match("/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})+$/", $email)){
                return true;
            }else{
                return false;
            }
        }
        static function validarUsuario___($nombre){
            if (preg_match('/^[a-z\d_]{4,16}$/i', $nombre)) {
                return true;
            }else{
                return false;
            }
        }
        static function fijar_cadena($string, $length=NULL){
            //Si no se especifica la longitud por defecto es 50
            if($length == NULL){
                $length = 50;
            }
            //Primero eliminamos las etiquetas html y luego cortamos el string
            $stringDisplay = substr(strip_tags($string), 0, $length);
            //Si el texto es mayor que la longitud se agrega puntos suspensivos
            if (strlen(strip_tags($string)) > $length){
                $stringDisplay .= ' ...';
                return $stringDisplay;
            }else{
                return $stringDisplay;
            }
        }
        static function IDVIDEO_youtube($link){
            $regexstr = '~
                # Match Youtube link and embed code
                (?:                             # Group to match embed codes
                    (?:<iframe [^>]*src=")?     # If iframe match up to first quote of src
                    |(?:                        # Group to match if older embed
                        (?:<object .*>)?        # Match opening Object tag
                        (?:<param .*</param>)*  # Match all param tags
                        (?:<embed [^>]*src=")?  # Match embed tag to the first quote of src
                    )?                          # End older embed code group
                )?                              # End embed code groups
                (?:                             # Group youtube url
                    https?:\/\/                 # Either http or https
                    (?:[\w]+\.)*                # Optional subdomains
                    (?:                         # Group host alternatives.
                    youtu\.be/                  # Either youtu.be,
                    | youtube\.com              # or youtube.com
                    | youtube-nocookie\.com     # or youtube-nocookie.com
                    )                           # End Host Group
                    (?:\S*[^\w\-\s])?           # Extra stuff up to VIDEO_ID
                    ([\w\-]{11})                # $1: VIDEO_ID is numeric
                    [^\s]*                      # Not a space
                )                               # End group
                "?                              # Match end quote if part of src
                (?:[^>]*>)?                     # Match any extra stuff up to close brace
                (?:                             # Group to match last embed code
                    </iframe>                   # Match the end of the iframe
                    |</embed></object>          # or Match the end of the older embed
                )?                              # End Group of last bit of embed code
                ~ix';
            preg_match($regexstr, $link, $matches);
            if($matches!=NULL){
                return $matches[1];
            }else{
                return false;
            }
        }
        static function IDVIDEO_vimeo($link){
            $regexstr = '~
                # Match Vimeo link and embed code
                (?:<iframe [^>]*src=")?     # If iframe match up to first quote of src
                (?:                         # Group vimeo url
                    https?:\/\/             # Either http or https
                    (?:[\w]+\.)*            # Optional subdomains
                    vimeo\.com              # Match vimeo.com
                    (?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
                    \/                      # Slash before Id
                    ([0-9]+)                # $1: VIDEO_ID is numeric
                    [^\s]*                  # Not a space
                )                           # End group
                "?                          # Match end quote if part of src
                (?:[^>]*></iframe>)?        # Match the end of the iframe
                (?:<p>.*</p>)?              # Match any title information stuff
                ~ix';
            preg_match($regexstr, $link, $matches);
            if($matches!=NULL){
                return $matches[1];
            }else{
                return false;
            }
        }
        static function debug($var='', $modo='v'){
            $res = '';
            if($var!=NULL){
                if($modo=='v'){
                    echo "<pre>";
                    $res = var_dump($var);
                    echo "</pre>";
                }else{
                    echo "<pre>";
                    $res = print_r($var);
                    echo "</pre>";
                }
            }
            return $res;
        }
        static function formato_numero($numero=0){
            return number_format($numero, 2, ".", ",");
        }
        static function RandomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE){
            $source = 'abcdefghijklmnopqrstuvwxyz';
            if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            if($n==1) $source .= '1234567890';
            if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
            if($length>0){
                $rstr = "";
                $source = str_split($source,1);
                for($i=1; $i<=$length; $i++){
                    mt_srand((double)microtime() * 1000000);
                    $num = mt_rand(1,count($source));
                    $rstr .= $source[$num-1];
                }

            }
            return $rstr;
        }
        static function fechasSQL($fecha){
            $fecha = (string)($fecha);
            $fecha = explode(' ',$fecha);
            return var_dump($fecha);
        }
        static function calcular_edad($edad){
            list($anio,$mes,$dia) = explode("-",$edad);
            $anio_dif = date("Y") - $anio;
            $mes_dif = date("m") - $mes;
            $dia_dif = date("d") - $dia;
            if ($dia_dif < 0 || $mes_dif < 0)
            $anio_dif--;
            return $anio_dif+1;
        }
        static function es_alfanumerico($nombreUsuario){
            $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.";
            $cantidad = strlen($nombreUsuario);
            for($i=0;$i<=$cantidad-1;$i++){
                $aux = eregi("\\".$nombreUsuario[$i],$permitidos);
                if(!$aux)
                {
                    $switch=1;
                    return false;
                }
            }
            if ($switch==1){
                return false;
            }else{
                return true;
            }
        }
        static function es_numerico($nombreUsuario){
            $permitidos = "0123456789";
            $cantidad=strlen($nombreUsuario);
            for($i=0;$i<=$cantidad-1;$i++){
                $aux=eregi("\\".$nombreUsuario[$i],$permitidos);
                if(!$aux){
                    $switch=1;
                    return false;
                }
            }
            if ($switch==1){
                return false;
            }else{
                return true;
            }
        }
        static function cortar_cadena($texto="",$tamano = 50){
            $texto = strip_tags($texto);
            $contador = 0;
            $arrayTexto = split(' ',$texto);
            $ntexto = '';
            while($tamano >= strlen($ntexto) + strlen($arrayTexto[$contador])){
                $ntexto .= ' '.$arrayTexto[$contador];
                $contador++;
            }
            return $ntexto.'...';
        }
        static function array_envia($array) {

            $tmp = serialize($array);
            $tmp = urlencode($tmp);

            return $tmp;
        }
        static function array_recibe($url_array) {
            $tmp = stripslashes($url_array);
            $tmp = urldecode($tmp);
            $tmp = unserialize($tmp);

           return $tmp;
        }
        static function RedimImagen($path,$ancho_fijo=200,$altura_fijo=200,$ubi=3,$defecto="images/default.jpg"){
            $Imagen['path']=$path;
            $Imagen['error'] = 0;
            $Imagen['ancho']=$ancho_fijo;
            $Imagen['altura']=$altura_fijo;

            $variable = preg_split('[\/]',$path);

            if(file_exists($Imagen['path']) && $variable[$ubi]<>"" ){
                $resolucion = getimagesize($Imagen['path']);
                $res = preg_split('/ /',$resolucion[3]);

                $Imagen['ancho'] = preg_replace('/width="(.*?)"/', '$1', $res[0]);
                $Imagen['altura'] = preg_replace('/height="(.*?)"/', '$1', $res[1]);

                $dif = $Imagen['ancho'] - $Imagen['altura'];
                $dif_altura = $altura_fijo - $Imagen['altura'];
                $dif_ancho = $ancho_fijo - $Imagen['ancho'];

                if($dif_altura<0){
                    if($dif_ancho<0){
                        $resize=1;
                    }else{
                        $resize=2;
                    }
                }else{
                    if($dif_ancho<0){
                        $resize=3;
                    }else{
                        $resize=4;
                    }
                }

                switch($resize){
                    case 1:
                    //echo 'ancho y altura son grandes';
                    $Imagen['altura']=round(($altura_fijo*$Imagen['altura'])/$Imagen['ancho'],0);
                    $Imagen['ancho']=round($ancho_fijo,0);
                    break;
                    case 2:
                    //echo 'altura es grande';
                    $Imagen['ancho']=round(($altura_fijo*$Imagen['ancho'])/$Imagen['altura'],0);
                    $Imagen['altura']=round($altura_fijo,0);
                    break;
                    case 3:
                    //echo 'ancho es grande';
                    $Imagen['altura'] = round(($ancho_fijo*$Imagen['altura'])/$Imagen['ancho'],0);
                    $Imagen['ancho'] = round($ancho_fijo,0);
                    break;
                    case 4:
                    //echo 'todo ok';
                    break;
                }

            }else{
                $Imagen['error'] = 1;
                $Imagen['path'] = $defecto;
            }
            return $Imagen;
        }
        static function RedimImagenP($path,$ancho_fijo=200,$altura_fijo=200,$ubi=3,$defecto="images/no-image-found.jpg"){
                $Imagen['path']= $path;
                $Imagen['error'] = 0;
                $Imagen['ancho']=$ancho_fijo;
                $Imagen['altura']=$altura_fijo;
                    $variable=split('/',$path);
                    if  (file_exists($Imagen['path']) && $variable[$ubi]<>"" ){
                            $resolucion = getimagesize($Imagen['path']);
                            $res = explode(' ',$resolucion[3]);
                            $Imagen['ancho']=eregi_replace("[width,=,\"]",'',$res[0]);
                            $Imagen['altura']=eregi_replace("[height,=,\"]",'',$res[1]);
                            $dif=$Imagen['ancho']-$Imagen['altura'];
                            $dif_altura=$altura_fijo-$Imagen['altura'];
                            $dif_ancho=$ancho_fijo-$Imagen['ancho']."<br><br>";
                            if($dif_altura > $dif_ancho){
                                    $resize=1;
                            }else{
                                if($dif_ancho > $dif_altura){
                                    $resize=2;
                                }else{
                                    $resize=1;
                                }
                            }
                            switch($resize){
                                case 1:
                                    $Imagen['altura']=($altura_fijo*$Imagen['altura'])/$Imagen['ancho'];
                                    $Imagen['ancho']=$ancho_fijo;
                                break;
                                case 2:
                                    $Imagen['ancho']=($altura_fijo*$Imagen['ancho'])/$Imagen['altura'];
                                    $Imagen['altura']=$altura_fijo;
                                break;
                                case 3:
                                    $Imagen['altura']=($ancho_fijo*$Imagen['altura'])/$Imagen['ancho'];
                                    $Imagen['ancho']=$ancho_fijo;
                                break;
                                case 4:
                                break;
                            }
                    }else{
                        $Imagen['error'] = 1;
                        $Imagen['path'] = $defecto;
                    }
                return $Imagen;
        }
        static function Cero($var) {
                return ($var > 0);
        }
        static function ValidarId($id){
                $validar = true;
                if($id==''){
                    $validar = false;
                }else{
                    if(is_numeric($id) && $id > 0){
                        $validar = true;
                    }else{
                        $validar = false;
                    }
                }
                return $validar;
        }
        static function data_text($data, $tipus=1){

              if ($data != '' && $tipus == 0 || $tipus == 1)
              {
                $setmana = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
                $mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

                if ($tipus == 1)
                {
                  ereg('([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})', $data, $data);

                  $data = mktime(0,0,0,$data[2],$data[1],$data[3]);
                }

                return $setmana[date('w', $data)].', '.date('d', $data).' '.$mes[date('m',$data)-1].' de '.date('Y', $data);
              }
              else
              {
                return 0;
              }
        }
        static function fechat_a_cadena($data, $tipus=1){
            $fecha  = explode(" ",$data);
            $data = cambiaf_a_normal($fecha[0]);
              if ($data != '' && $tipus == 0 || $tipus == 1)
              {
                $setmana = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado');
                $mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                if ($tipus == 1)
                {
                  ereg('([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})', $data, $data);
                  $data = mktime(0,0,0,$data[2],$data[1],$data[3]);
                }
                return $setmana[date('w', $data)].', '.date('d', $data).' '.$mes[date('m',$data)-1].' del '.date('Y', $data).' a las '.$fecha[1];
              }
              else
              {
                return 0;
              }
        }
        static function cambiaf_a_normal($fecha){
            $lafecha =  preg_replace("/([0-9]{4})-([0-9]{2})-([0-9]{2})/i","$3/$2/$1",$fecha);
            //ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
            //$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
            return $lafecha;
        }
        static function cambiaf_a_normal2($fecha){
            $lafecha =  preg_replace("/([0-9]{4})-([0-9]{2})-([0-9]{2})/i","$3-$2-$1",$fecha);
            return $lafecha;
        }
        static function cambiaf_a_mysql($fecha){
            $lafecha =  preg_replace("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/i","$3-$2-$1",$fecha);
            //ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
            //$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
            return $lafecha;
        }
        static function cambiar_fechat($fecha){
            $fec = explode(" ",$fecha);
            $aux = explode("-",$fec[0]);
            $fecha = $aux[2]."/".$aux[1]."/".$aux[0];
            $nueva_fecha = $fecha." a las ".$fec[1];
            return $nueva_fecha;
        }
        static function StrCut($texto){
                $tamano = 350; // tamaño máximo
                $contador = 0;
                // Cortamos la cadena por los espacios
                $arrayTexto = split(' ',$texto);
                $texto = '';

                // Reconstruimos la cadena
                while($tamano >= strlen($texto) + strlen($arrayTexto[$contador])){
                    $texto .= ' '.$arrayTexto[$contador];
                    $contador++;
                }
                return $texto.'.';
        }
        static function StrCutA($texto){
            $tamano = 100; // tamaño máximo
            $contador = 0;
            // Cortamos la cadena por los espacios
            $arrayTexto = split(' ',$texto);
            $texto = '';

            // Reconstruimos la cadena
            while($tamano >= strlen($texto) + strlen($arrayTexto[$contador])){
                $texto .= ' '.$arrayTexto[$contador];
                $contador++;
            }
            return $texto.'....';
        }
        static function StrCutT($texto){
            $tamano = 30; // tamaño máximo
            $contador = 0;
            // Cortamos la cadena por los espacios
            $arrayTexto = split(' ',$texto);
            $texto = '';

            // Reconstruimos la cadena
            while($tamano >= strlen($texto) + strlen($arrayTexto[$contador])){
                $texto .= ' '.$arrayTexto[$contador];
                $contador++;
            }
            return $texto.'.';
        }
        static function StrCutTitulo($texto){
            $tamano = 70; // tamaño máximo
            $contador = 0;
            // Cortamos la cadena por los espacios
            $arrayTexto = split(' ',$texto);
            $texto = '';

            // Reconstruimos la cadena
            while($tamano >= strlen($texto) + strlen($arrayTexto[$contador])){
                $texto .= ' '.$arrayTexto[$contador];
                $contador++;
            }
            return $texto.'...';
        }
        static function StrCutResumen($texto){
            $tamano = 180; // tamaño máximo
            $contador = 0;
            // Cortamos la cadena por los espacios
            $arrayTexto = split(' ',$texto);
            $texto = '';

            // Reconstruimos la cadena
            while($tamano >= strlen($texto) + strlen($arrayTexto[$contador])){
                $texto .= ' '.$arrayTexto[$contador];
                $contador++;
            }
            return $texto.'...';
        }
        static function StrCutResumen2($texto){
            $tamano = 300; // tamaño máximo
            $contador = 0;
            // Cortamos la cadena por los espacios
            $arrayTexto = split(' ',$texto);
            $texto = '';

            // Reconstruimos la cadena
            while($tamano >= strlen($texto) + strlen($arrayTexto[$contador])){
                $texto .= ' '.$arrayTexto[$contador];
                $contador++;
            }
            return $texto.'...';
        }
        static function StrCutD($texto){
            $tamano = 180; // tamaño máximo
            $contador = 0;
            // Cortamos la cadena por los espacios
            $arrayTexto = split(' ',$texto);
            $texto = '';

            // Reconstruimos la cadena
            while($tamano >= strlen($texto) + strlen($arrayTexto[$contador])){
                $texto .= ' '.$arrayTexto[$contador];
                $contador++;
            }
            return $texto.'....';
        }
        static function StrCut2($texto){
            $tamano = 300; // tamaño máximo
            $contador = 0;
            // Cortamos la cadena por los espacios
            $arrayTexto = split(' ',$texto);
            $texto = '';

            // Reconstruimos la cadena
            while($tamano >= strlen($texto) + strlen($arrayTexto[$contador])){
                $texto .= ' '.$arrayTexto[$contador];
                $contador++;
            }
            return $texto.'....';
        }
        static function codificarObj(&$aObj){
            if(is_array($aObj) or is_object($aObj)){
                foreach($aObj as &$element){
                    codificarObj($element);
                }
            } else {
                $aObj = fncCodificar($aObj);
            }
        }
        static function fncCodificar($texto){
            return codificarTexto(utf8_decode(htmlspecialchars(trim(stripslashes($texto)))));
        }
        static function fncSeguridad($texto){
            return htmlspecialchars(trim(stripslashes($texto)));
        }
        static function nombre_mes($mes){
            $meses = array(1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre");
            return $meses[GetSQLValueString($mes, "int")];
        }
        static function nombre_mes22($mes){
            $meses = array(1=>"Ene",2=>"Feb",3=>"Mar",4=>"Abr",5=>"May",6=>"Jun",7=>"Jul",8=>"Ago",9=>"Sep",10=>"Oct",11=>"Nov",12=>"Dic");
            return $meses[GetSQLValueString($mes, "int")];
        }
        static function dia($fecha){
            $fechats = strtotime($fecha);
            switch (date('w', $fechats)){
                case 0: $diaTexto = "Domingo"; break;
                case 1: $diaTexto = "Lunes"; break;
                case 2: $diaTexto = "Martes"; break;
                case 3: $diaTexto = "Miercoles"; break;
                case 4: $diaTexto = "Jueves"; break;
                case 5: $diaTexto = "Viernes"; break;
                case 6: $diaTexto = "Sabado"; break;
            }
            return $diaTexto;
        }
        static function fecha_letras($dia,$mes,$anio){
            $fec = dia($dia."-".$mes."-".$anio).", ".$dia." de ".strtolower(nombre_mes($mes))." del ".$anio;
            return $fec;
        }
        static function fecha_letrasCompacto($fec=""){// date("Y-m-d")
            if($fec=="") $fec=date("Y-m-d");
            list($anio,$mes,$dia) = explode("-",$fec);
            $fec = dia($dia."-".$mes."-".$anio).", ".$dia." de ".strtolower(nombre_mes($mes))." del ".$anio;
            return $fec;
        }
        static function fecha_letrasCompacto2($fec=""){// date("Y-m-d")
            if($fec=="") $fec=date("Y-m-d");
            list($anio,$mes,$dia) = explode("-",$fec);
            $fec = $dia." de ".strtolower(nombre_mes($mes))." del ".$anio;
            return $fec;
        }
        static function fecha_mescorto($fec=""){// date("Y-m-d")
            if($fec=="") $fec=date("Y-m-d");
            list($anio,$mes,$dia) = explode("-",$fec);
            $fec = $dia." ".nombre_mes22($mes)." ".$anio;
            return $fec;
        }
        static function fecha_mestextocoma($fec=""){// date("Y-m-d")
            if($fec=="") $fec=date("Y-m-d");
            list($anio,$mes,$dia) = explode("-",$fec);
            $fec = $dia." ".nombre_mes22($mes).", ".$anio;
            return $fec;
        }
        static function fecha(){
            $fec = "Tacna, ".nombre_mes(GetSQLValueString(date("m"), "int"))." ".date("d")." del ".date("Y");
            return $fec;
        }
        static function fechaSinDia(){
            $fec = "Tacna, ".nombre_mes(GetSQLValueString(date("m"), "int"))." del ".date("Y");
            return $fec;
        }
        static function fecha_corta(){
            $fec = date("d/m/Y");
            return $fec;
        }
        static function hora_corta(){
            $hor = date("h:i:s");
            return $hor;
        }
        static function restaFechas($dFecIni, $dFecFin){
            $dFecIni = str_replace("-","",$dFecIni);
            $dFecIni = str_replace("/","",$dFecIni);
            $dFecFin = str_replace("-","",$dFecFin);
            $dFecFin = str_replace("/","",$dFecFin);

            ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
            ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

            $date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
            $date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);

            return round(($date2 - $date1) / (60 * 60 * 24));
        }
        static function utf8_decoded($contenido) {
            $contenido = str_replace("Ã¡", "Á", $contenido);
            $contenido = str_replace("Ã©", "É", $contenido);
            $contenido = str_replace("Ã­", "Í", $contenido);
            $contenido = str_replace("Ã³", "Ó", $contenido);
            $contenido = str_replace("Ãº", "Ú", $contenido);
            $contenido = str_replace("Ã±", "Ñ", $contenido);
            $contenido = str_replace("Â¡", "¡", $contenido);
            $contenido = str_replace("Ã'", "Ñ", $contenido);
            $contenido = str_replace("Â¿", "¿", $contenido);

            $contenido = str_replace("ã¡", "á", $contenido);
            $contenido = str_replace("ã©", "é", $contenido);
            $contenido = str_replace("ã­", "í", $contenido);
            $contenido = str_replace("ã³", "ó", $contenido);
            $contenido = str_replace("ãº", "ú", $contenido);
            $contenido = str_replace("ã±", "ñ", $contenido);
            $contenido = str_replace("â¡", "¡", $contenido);
            $contenido = str_replace("ã'", "ñ", $contenido);
            $contenido = str_replace("â¿", "¿", $contenido);
            return $contenido;
        }
        static function urls_amigables($url) {
            // Tranformamos todo a minusculas
            $url = utf8_encode(strtolower($url));
            $url = utf8_decoded($url);
            //Rememplazamos caracteres especiales latinos
            /*
            $find = array('á', 'é', 'í', 'ó', 'Ó', 'ú', 'ñ', ':');
            $repl = array('a', 'e', 'i', 'o', 'o', 'u', 'n', '-');*/

            $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ', ':', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');
            $repl = array('a', 'e', 'i', 'o', 'u', 'n', '-', 'a', 'e', 'i', 'o', 'u', 'n');

            $url = str_replace ($find, $repl, $url);

            // Añaadimos los guiones

            $find = array(' ', '&', '\r\n', '\n', '+');
            $url = str_replace ($find, '-', $url);

            // Eliminamos y Reemplazamos demás caracteres especiales

            $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');

            $repl = array('', '-', '');

            $url = preg_replace ($find, $repl, $url);

            return $url;
        }
        static function urls_amigablesLetra($url) {
            // Tranformamos todo a minusculas
            $url = utf8_encode(strtolower($url));
            $url = utf8_decoded($url);
            //Rememplazamos caracteres especiales latinos
            /*
            $find = array('á', 'é', 'í', 'ó', 'Ó', 'ú', 'ñ', ':');
            $repl = array('a', 'e', 'i', 'o', 'o', 'u', 'n', '-');*/

            $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ', ':', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');
            $repl = array('a', 'e', 'i', 'o', 'u', 'n', '-', 'a', 'e', 'i', 'o', 'u', 'n');

            $url = str_replace ($find, $repl, $url);

            // Añaadimos los guiones

            $find = array(' ', '&', '\r\n', '\n', '+');
            $url = str_replace ($find, '-', $url);

            // Eliminamos y Reemplazamos demás caracteres especiales

            $find = array('/[^a-z\-<>]/', '/[\-]+/', '/<[^>]*>/');

            $repl = array('', '-', '');

            $url = preg_replace ($find, $repl, $url);

            return $url;
        }
        static function ConvertMinSinTildes($url) {
            $url = $url;
            $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ', ':', 'Á', 'É', 'Í', 'Ú', 'Ó', 'Ñ');
            $repl = array('a', 'e', 'i', 'o', 'u', 'n', '-', 'a', 'e', 'i', 'u', 'o', 'n');
            $url = str_replace ($find, $repl, $url);
            $find = array(' ', '&', '\r\n', '\n', '+');
            $url = str_replace ($find, '-', $url);
            $find = array('/[^a-zA-Z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
            $repl = array('', '-', '');
            $url = preg_replace ($find, $repl, $url);
            return strtolower($url);
        }
        static function tiempo_transcurrido($fecha) {
            if(empty($fecha)) {
                  return "No hay fecha";
            }

            $intervalos = array("segundo", "minuto", "hora", "día", "semana", "mes", "año");
            $duraciones = array("60","60","24","7","4.35","12","1");

            $ahora = time();
            $Fecha_Unix = strtotime($fecha);

            if(empty($Fecha_Unix)) {
                  return "Fecha incorracta";
            }
            if($ahora > $Fecha_Unix) {
                  $diferencia     =$ahora - $Fecha_Unix;
                  $tiempo         = "Hace";
            } else {
                  $diferencia     = $Fecha_Unix -$ahora;
                  $tiempo         = "Dentro de";
            }
            for($j = 0; $diferencia >= $duraciones[$j] && $j < count($duraciones)-1; $j++) {
              $diferencia /= $duraciones[$j];
            }

            $diferencia = round($diferencia);

            if($diferencia != 1) {
                $intervalos[5].="e"; //MESES
                $intervalos[$j].= "s";
            }

            return "$tiempo $diferencia $intervalos[$j]";
        }
        // Ejemplos de uso
        // fecha en formato yyyy-mm-dd
        // echo tiempo_transcurrido('2010/02/05');
        // fecha y hora
        static function hace_tiempo($valor){

                // FORMATOS:
                // segundos    desde 1970 (función time())        hace_tiempo('12313214');
                // defecto (variable $formato_defecto)        hace_tiempo('12:01:02 04-12-1999');
                // tu propio formato                        hace_tiempo('04-12-1999 12:01:02 [n.j.Y H:i:s]');

                $formato_defecto="H:i:s j-n-Y";

                // j,d = día
                // n,m = mes
                // Y = año
                // G,H = hora
                // i = minutos
                // s = segundos

                if(stristr($valor,'-') || stristr($valor,':') || stristr($valor,'.') || stristr($valor,',')){
                    if(stristr($valor,'[')){
                        $explotar_valor=explode('[',$valor);
                        $valor=trim($explotar_valor[0]);
                        $formato=str_replace(']','',$explotar_valor[1]);
                    }else{
                        $formato=$formato_defecto;
                    }

                $valor = str_replace("-"," ",$valor);
                $valor = str_replace(":"," ",$valor);
                $valor = str_replace("."," ",$valor);
                $valor = str_replace(","," ",$valor);

                $numero = explode(" ",$valor);

                $formato = str_replace("-"," ",$formato);
                $formato = str_replace(":"," ",$formato);
                $formato = str_replace("."," ",$formato);
                $formato = str_replace(","," ",$formato);

                $formato = str_replace("d","j",$formato);
                $formato = str_replace("m","n",$formato);
                $formato = str_replace("G","H",$formato);

                $letra = explode(" ",$formato);

                $relacion[$letra[0]]=$numero[0];
                $relacion[$letra[1]]=$numero[1];
                $relacion[$letra[2]]=$numero[2];
                $relacion[$letra[3]]=$numero[3];
                $relacion[$letra[4]]=$numero[4];
                $relacion[$letra[5]]=$numero[5];

                $valor = mktime($relacion['H'],$relacion['i'],$relacion['s'],$relacion['n'],$relacion['j'],$relacion['Y']);

                }

                $ht = time()-$valor;

                if($ht>=86400){
                    $dia = date('d',$valor);
                    $mes = date('n',$valor);
                    $año = date('Y',$valor);
                    $hora = date('H',$valor);
                    $minuto = date('i',$valor);
                    $mesarray = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
                    $fecha = "el $dia de $mesarray[$mes] del $año";
                }
                //if($ht<30242054.045){$hc=round($ht/2629743.83);if($hc>1){$s="es";}$fecha="hace $hc mes".$s;}
                //if($ht<2116800){$hc=round($ht/604800);if($hc>1){$s="s";}$fecha="hace $hc semana".$s;}
                //if($ht<561600){$hc=round($ht/86400);if($hc==1){$fecha="ayer";}if($hc==2){$fecha="antes de ayer";}if($hc>2)$fecha="hace $hc días";}
                if($ht<86400){$hc=round($ht/3600);if($hc>1){$s="s";}$fecha="hace $hc hora".$s;if($ht>4200 && $ht<5400){$fecha="hace más de una hora";}}
                if($ht<3570){$hc=round($ht/60);if($hc>1){$s="s";}$fecha="hace $hc minuto".$s;}
                if($ht<60){$fecha="hace $ht segundos";}
                if($ht<=3){$fecha="ahora";}
                return $fecha;
        }
                    // Ejemplos
                    //echo hace_tiempo("1271201645")."<br />";
                    //echo hace_tiempo("19:10:05 01-12-2012")."<br />";
                    //echo hace_tiempo("2010-04-13 20:34:05 [Y-n-j H:i:s]")."<br />";
        static function format_bytes($size) {
            $units = array(' B', ' KB', ' MB', ' GB', ' TB');
            for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
            return round($size, 2).$units[$i];
        }
        //función mime type
        static function mime_content_type1($filename) {
            $mime_types = array(

                //exe, pdf, 7z, zip, rar, doc, docx, xls, xlsx, ppt, pptx,pps,ppsx
                // archives
                //'exe' => 'application/x-msdownload',
                'pdf' => 'application/pdf',
                '7z'  => 'application/x-7z-compressed',
                'zip' => 'application/zip',
                'rar' => 'application/x-rar-compressed',
                //'rar' => 'application/x-rar',
                'jpg' => 'image/jpeg',
                'jpeg'=> 'image/pjpeg',
                'png' => 'image/png',
                'bmp' => 'image/bmp',
                // ms office
                'doc'  => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',

                'xls'  => 'application/vnd.ms-excel',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

                'ppt'  => 'application/vnd.ms-powerpoint',
                'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'pps'  => 'application/vnd.ms-powerpoint',
                'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow'

            );

            $ext = strtolower(array_pop(explode('.',$filename)));

            if (array_key_exists($ext, $mime_types)) {
                return $mime_types[$ext];
            }
            elseif (function_exists('finfo_open')) {
                $finfo = finfo_open(FILEINFO_MIME);
                $mimetype = finfo_file($finfo, $filename);
                finfo_close($finfo);
                return $mimetype;
            }else{
                return 'application/octet-stream';
            }
        }
        // generamos los meses
        static function genMonth_Text($m='') {
            $month_text = '';
            switch($m) {
                case 1: $month_text = "enero"; break;
                case 2: $month_text = "febrero"; break;
                case 3: $month_text = "marzo"; break;
                case 4: $month_text = "abril"; break;
                case 5: $month_text = "mayo"; break;
                case 6: $month_text = "junio"; break;
                case 7: $month_text = "julio"; break;
                case 8: $month_text = "agosto"; break;
                case 9: $month_text = "septiembre"; break;
                case 10: $month_text = "octubre"; break;
                case 11: $month_text = "noviembre"; break;
                case 12: $month_text = "diciembre"; break;
            }
            return ($month_text);
        }

    }
?>