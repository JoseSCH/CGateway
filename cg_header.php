<?php
/*
Plugin Name: CG_GATEWAY
Plugin URI: https://github.com/JoseSCH/CGateway
Description: Plugin para pasarela de pago.
Author: JoseSCH
Version: 1.0.1
Author URI: https://github.com/JoseSCH
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

//seguridad
defined('ABSPATH') or die('No se admiten trampas');

//Gancho de tipo filtro para registrar nuestra clase php como una pasarela de pago ante woocommerce_payment_gateways
add_filter( 'woocommerce_payment_gateways', 'CG_class_agregar' );
function CG_class_agregar( $gateways ) {
	$gateways[] = 'CG_Payment_class'; // El nombre de la clase.
	return $gateways;
}

//La clase, esta dentro del gancho de acción 'plugins loaded'
add_action('plugins_loaded', "Iniciar_Clase_GC");
function Iniciar_Clase_GC(){

    class CG_Payment_class extends WC_Payment_Gateway{

        //constructor
        public function __construct(){

            $this->id = 'CHEPE';//ID de la pasarela.
            $this->icon = '';//URL de icono si se usa o nel.
            $this->has_fields = true;//Para aceptar formularios personalizados.
            $this->method_title = 'CG Payment Gateway';//Título del metodo.
            $this->method_description = 'Yo solo se que no se nada';//Descripción del método.

            $this->supporst = array(//Para pagos simples.
                'products'
            );

            //Metodo con todos los campos.
            $this->init_form_fields();

            //Cargar opciones.
            $this->init_settings();
            $this->title = $this->get_option( 'title' );
            $this->description = $this->get_option( 'description' );
            $this->enabled = $this->get_option( 'enabled' );
            $this->testmode = 'yes' === $this->get_option( 'testmode' );
            $this->private_key = $this->testmode ? $this->get_option( 'test_private_key' ) : $this->get_option( 'private_key' );
            $this->publishable_key = $this->testmode ? $this->get_option( 'test_publishable_key' ) : $this->get_option( 'publishable_key' );

            //Gancho de acción que guarda las opciones.
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

            //Para obtener el token desde JavaScript.
            add_action( 'wp_enqueue_scripts', array( $this, 'payment_scripts' ) );

        }

        public function init_form_fields(){

            $this->form_fields = array(
                'enabled' => array(
                    'title'       => 'Enable/Disable',
                    'label'       => 'Enable CG Gateway',
                    'type'        => 'checkbox',
                    'description' => '',
                    'default'     => 'no'
                ),
                'title' => array(
                    'title'       => 'Title',
                    'type'        => 'text',
                    'description' => 'This controls the title which the user sees during checkout.',
                    'default'     => 'Credit Card',
                    'desc_tip'    => true,
                ),
                'description' => array(
                    'title'       => 'Description',
                    'type'        => 'textarea',
                    'description' => 'This controls the description which the user sees during checkout.',
                    'default'     => 'Pay with your credit card via our super-cool payment gateway.',
                ),
                'testmode' => array(
                    'title'       => 'Test mode',
                    'label'       => 'Enable Test Mode',
                    'type'        => 'checkbox',
                    'description' => 'Place the payment gateway in test mode using test API keys.',
                    'default'     => 'yes',
                    'desc_tip'    => true,
                ),
                'test_publishable_key' => array(
                    'title'       => 'Test Publishable Key',
                    'type'        => 'text'
                ),
                'test_private_key' => array(
                    'title'       => 'Test Private Key',
                    'type'        => 'password',
                ),
                'publishable_key' => array(
                    'title'       => 'Live Publishable Key',
                    'type'        => 'text'
                ),
                'private_key' => array(
                    'title'       => 'Live Private Key',
                    'type'        => 'password'
                )
            );

        }

        public function payment_scripts() {

            // we need JavaScript to process a token only on cart/checkout pages, right?
            if ( ! is_cart() && ! is_checkout() && ! isset( $_GET['pay_for_order'] ) ) {
                return;
            }
        
            // if our payment gateway is disabled, we do not have to enqueue JS too
            if ( 'no' === $this->enabled ) {
                return;
            }
        
            // no reason to enqueue JavaScript if API keys are not set
            if ( empty( $this->private_key ) || empty( $this->publishable_key ) ) {
                return;
            }
        
            // do not work with card detailes without SSL unless your website is in a test mode
            if ( ! $this->testmode && ! is_ssl() ) {
                return;
            }
        
            // let's suppose it is our payment processor JavaScript that allows to obtain a token
            wp_enqueue_script( 'rigel_js', 'https://www.mishapayments.com/api/token.js' );
        
            // and this is our custom JS in your plugin directory that works with token.js
            wp_register_script( 'woocommerce_misha', plugins_url( 'rigel.js', __FILE__ ), array( 'jquery', 'rigel_js' ) );
        
            // in most payment processors you have to use PUBLIC KEY to obtain a token
            wp_localize_script( 'woocommerce_misha', 'misha_params', array(
                'publishableKey' => $this->publishable_key
            ) );
        
            wp_enqueue_script( 'woocommerce_chepe' );
        
        }

    }

}


?>