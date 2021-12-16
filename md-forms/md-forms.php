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

    public function form( $atts ){
        global $post;
        $atts = shortcode_atts(
            array(
                'add_honeypot'=>false
            ), $atts, 'mdform');

        //1) Instantiate the class
            $form = new PHPFormBuilder();

        //2) Change any form attributes, if desired

            $form->set_att( 'action', esc_url ( admin_url( 'admin-post.php') ) );
            $form->set_att( 'add_honeypot', $atts['add_honeypot'] );

        // 3) Add inputs, in order you want to see them
        

        //hidden fields
        $form->add_input('action', array(
            'type'=>'hidden', 
            'value' =>'mdform'
        ), 'action');
        $form->add_input('wp_nonce', array(
            'type'=>'hidden', 
            'value' =>wp_create_nonce( 'submit_mdform')
        ), 'wp_nonce');
        $form->add_input('redirect_id', array(
            'type'=>'hidden', 
            'value' => $post->ID
        ), 'redirect_id');


        //input fields
        $form->add_input('Name', array(
            'type'=>'text', 
            'placeholder'=>'your name', 
            'required'=>true
        ), 'name'); 
        $form->add_input('Phone', array(
            'type'=>'number', 
            'placeholder'=>'your phone', 
            'required'=>true
        ), 'phone');
        $form->add_input('Phone 2', array(
            'type'=>'number', 
            'placeholder'=>'your phone', 
            'required'=>false
        ), 'phone2');


        //shortcode ahould not output directly
        ob_start();
        $status = filter_input(INPUT_GET, 'status', FILTER_VALIDATE_INT);
        if($status == 1){
            printf('<div class="message success">%s</div>', __('great', 'mdforms'));        
        }

        // build the form
        $form->build_form();

        return ob_get_clean();
    }

    public function form_handler(){}

  
}
$mdForms = new MDForms; 
