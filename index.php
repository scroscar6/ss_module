<?php
/**
 * Sistema Gestión Modular
 *
 * Este sistema funciona bajo licencias de Paga en una plataforma PHP
 *
 * Copyright (c) 2015 - 2020, Sitelsur SAC
 *
 *
 * El aviso de copyright anterior y este aviso de permiso se incluirán en
 * Todas las copias o partes sustanciales del Software.
 *
 * EL SOFTWARE SE PROPORCIONA "TAL CUAL", SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * Implícita, incluyendo pero sin limitarse a las GARANTÍAS DE COMERCIALIZACIÓN,
 * IDONEIDAD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO EL
 * AUTORES O TITULARES DEL COPYRIGHT SERÁN RESPONSABLES POR NINGÚN RECLAMO, DAÑO U OTRA
 * RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO, AGRAVIO O CUALQUIER OTRA FORMA, DERIVADOS DE,
 * DE O EN RELACIÓN CON EL SOFTWARE O EL USO U OTROS TRATOS EN
 * EL SOFTWARE.
 *
 * @package Sitelsur SAC
 * @author  Oscar Antonio Alay (scroscar6)
 * @copyright   Copyright (c) 2015 - 2020, Sitelsur SAC (http://sitelsur.com/)
 * @license http://sitelsur.com
 * @link    http://www.sitelsur.com
 * @since   Version 2.5.6
 */
session_start();
define('_MODULAR_',true);
define('TRUE_MODULAR',true);
date_default_timezone_set('America/Lima');
define('DIR', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) .DIR);
define('CONF','configuracion/');
define('SSINCLUDES', 'includes/');
define('MODULOS', 'modulos'.DIR);
defined('PLANTILLA') ? null : define('PLANTILLA','vista/plantilla/');
    require_once(DIR.CONF.DIR.'autoload.php');
    if(file_exists(CONF.'conexion.php') && file_exists(CONF.'definiciones.php')){
        require_once(CONF.'definiciones.php');
        require_once(CONF.'conexion.php');
        require_once(CONF.'inicializa.php');
    }else{
        die('<strong>ERROR: </strong>La clase <strong>"Conexion"</strong> faltante, revise.');
    }
?>

