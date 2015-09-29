<?php
    namespace configuracion;
    interface DEFINICIONES{
        CONST MANTENIMIENTO     = 0;
        CONST HOST              = 'mysql:host=localhost';
        CONST DATABASE          = 'dbname=db_sistema_registro_fichas';
        CONST USER              = 'root';
        CONST PASSWD            = '';
        CONST DATETIME          = 'Y-d-m H:i:s';
        CONST URL               = '/SISTEMA_VISITAS_MDCGAL';

        /*TIPO DE SALIDA DE DATOS*/

        CONST ARRAY_FILA        = ARRAY_FILA;
        CONST ARRAY_DATO        = ARRAY_DATO;
        CONST ARRAY_TUPLA       = ARRAY_TUPLA;
        CONST ARRAY_COLUMNA     = ARRAY_COLUMNA;
    }
?>