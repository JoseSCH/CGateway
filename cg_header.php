<?php
/*
Plugin Name: Just calcule it
Plugin URI: https://github.com/JoseSCH/Just-Calcule-It
Description: Plugin para pasarela de pago.
Author: JoseSCH
Version: 1.0
Author URI: https://github.com/JoseSCH
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

//seguridad
defined('ABSPATH') or die('No se admiten trampas');

//includes
require_once(plugin_dir_path( __FILE__ ) . 'includes/jci_page.php');

function crear_submenu(){
    add_menu_page( 'CG_GATEWAY', 'CG_GATEWAY', 'read', 'cg_ops', 'cg_page' );
}

add_action( 'admin_menu', 'crear_submenu' );


?>