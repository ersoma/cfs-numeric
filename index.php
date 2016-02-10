<?php
/*
Plugin Name: CFS - Numeric Add-on
Plugin URI: http://somaerdelyi.net/
Description: Adds a numeric input field type.
Version: 1.0
Author: Soma Erdelyi
Author URI: http://somaerdelyi.net/
License: GPL2
Text Domain: cfs-numeric
Domain Path: /languages/
*/

$cfs_numeric_addon = new cfs_numeric_addon();

class cfs_numeric_addon
{
    function __construct() {
        
        define( 'CFS_NUMERIC_VERSION', '1.0' );

        add_filter('cfs_field_types', array($this, 'cfs_field_types'));

        add_action( 'plugins_loaded', 'cfsnumeric_load_textdomain' );
        function cfsnumeric_load_textdomain() {
          load_plugin_textdomain( 'cfs-numeric', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
        }
    }

    function cfs_field_types( $field_types ) {
        $field_types['numeric'] = dirname( __FILE__ ) . '/numeric.php';
        return $field_types;
    }
}
