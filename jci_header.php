<?php
/*
Plugin Name: Just calcule it
Plugin URI: #
Description: Una simpre calculadora.
Author: JoseSCH
Version: 1.0
Author URI: #
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

//seguridad
defined('ABSPATH') or die('No se admiten trampas');

//includes
require_once(plugin_dir_path( __FILE__ ) . 'includes/jci_page.php');

function crear_submenu(){
    add_menu_page( 'Just Calcule It', 'Just Calcule It', 'read', 'jci_ops', 'jci_calculator' );
}

add_action( 'admin_menu', 'crear_submenu' );


?>