<?php
    namespace configuracion;
    use PDO;
    class ClsConexion{
        static $Mantenimiento;
        static $ServerName;
        static $InfoConexion;
        static $Host;
        static $User;
        static $Passwd;
        static $Url;
        static $dateTime;
        static $Port = 3306;
        static $Conexion;
        function __construct(){
            self::Conectar();
        }
        public function Conectar(){
            self::$Mantenimiento    = DEFINICIONES::MANTENIMIENTO;
            self::$Host             = DEFINICIONES::HOST.';'.DEFINICIONES::DATABASE;
            self::$User             = DEFINICIONES::USER;
            self::$Passwd           = DEFINICIONES::PASSWD;
            self::$dateTime         = DEFINICIONES::DATETIME;
            self::$Url              = DEFINICIONES::URL;
            $on = true;
            try
            {
                self::$Conexion = new PDO(self::$Host, self::$User, self::$Passwd,array(PDO::ATTR_PERSISTENT => true));
                self::$Conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$Conexion->exec("SET CHARACTER SET utf8");
                $on = true;
            }
            catch (PDOException $e)
            {
                $on = false;
                $iderrno = 0;
                $ConfigFromName = self::$ConfigFromName;
                include('includes/conec_error.php');
                $on = false;
                exit();
            }
            return $on;
        }
        public function Desconectar(){
            if (isset(self::$Conexion)){
                self::$Conexion = NULL;
            }
        }
        public function Conexion(){
            return self::$Conexion;
        }
        public function URLBase(){
            return self::$Url;
        }
        public function DateTime(){
            return self::$dateTime;
        }
        public function Mantenimiento(){
            return self::$Mantenimiento;
        }
        public function querySelect($consulta,$tipo = NULL){
            try {
                self::$Conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$Conexion->beginTransaction();
                $resultado = self::$Conexion->prepare($consulta);
                $resultado->execute();
                self::$Conexion->commit();
                $zLista = array();
                $i = 0;
                switch ($tipo) {
                    case ARRAY_TUPLA:
                        $count = $resultado->columnCount();
                        while($row = $resultado->fetch())
                        {
                            for ($j=0;$j < $count; $j++)
                            {
                                $nombre = $resultado->getColumnMeta($j);
                                $zLista[$i][$nombre['name']]= $row[$nombre['name']];
                            }
                            $i++;
                        }
                    break;
                    case ARRAY_DATO:
                        try {
                            while($row = $resultado->fetch())
                            {
                                $nombre = $resultado->getColumnMeta(0);
                                $zLista = $row[$nombre['name']];
                            }
                            } catch (Exception $e) {
                            echo ('DEMACIADAS COLUMNAS - SOLO VALOR INDEPENDIENTE : '. $e->getMessage());
                        }
                    break;
                    case ARRAY_FILA:
                        $count = $resultado->columnCount();
                        while($row = $resultado->fetch())
                        {
                            for ($j=0;$j < $count; $j++)
                            {
                                $nombre = $resultado->getColumnMeta($j);
                                $zLista[$nombre['name']]= $row[$nombre['name']];
                            }
                            $i++;
                        }
                    break;
                    case ARRAY_COLUMNA:
                        $count = $resultado->columnCount();
                        while($row = $resultado->fetch())
                        {
                            array_push($zLista,$row[0]);
                        }
                    break;
                }
                return $zLista;
            } catch (PDOException $e) {
                self::$Conexion->rollBack();
                echo 'Falló de Conexion o Recorrido de Array: ' . $e->getMessage();
            }
        }
        public function queryInsert($consulta,$array){
            try {
                self::$Conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$Conexion->beginTransaction();
                $resultado = self::$Conexion->prepare($consulta);
                $resultado->execute($array);
                self::$Conexion->commit();
                return true;
            } catch (PDOException $e) {
                self::$Conexion->rollBack();
                echo 'Falló de Conexion o Recorrido de Array: ' . $e->getMessage();
            }
        }
        public function queryUpdate($consulta_,$array_){
            try {
                self::$Conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$Conexion->beginTransaction();
                $resultado = self::$Conexion->prepare($consulta_);
                $resultado->execute($array_);
                self::$Conexion->commit();
                return true;
            } catch (PDOException $e) {
                self::$Conexion->rollBack();
                echo 'Falló de Conexion o Recorrido de Array: ' . $e->getMessage();
            }
        }
        public function queryDelete($consulta,$array = NULL){
            try {
                self::$Conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$Conexion->beginTransaction();
                $resultado = self::$Conexion->prepare($consulta);
                if ($array != NULL) {
                    $resultado->execute($array);
                }else{
                    $resultado->execute();
                };
                self::$Conexion->commit();
                return true;
            } catch (PDOException $e) {
                self::$Conexion->rollBack();
                echo 'Falló de Conexion o Recorrido de Array: ' . $e->getMessage();
            }
        }
    }
?>