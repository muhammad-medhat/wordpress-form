<?php
/**
 *
 * @wordpress-plugin
 * Plugin Name:       MDForms
 * Plugin URI:        https://example.com/plugin-name
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Muhammad  Medhat
 * Author URI:        https://example.com
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://example.com/my-plugin/
 */


require_once( '__DIR__' .'/inc.class.PHPForms.php' );

// Main Plugin Code

if(! class_exists(  'MDForms' )){

  class MDForms{
  
    public __construct(){}
      
    public function enqueue_scripts(){}

    public function form( $atts ){}

    public function form_handler(){}

  
}
$mdForms = new MDForms; 
