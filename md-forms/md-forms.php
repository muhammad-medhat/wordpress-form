<?php
/**
 *
 * @wordpress-plugin
 * Plugin Name:       MDForms
 * Plugin URI:        https://mdstore.com/md-forms
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Muhammad  Medhat
 * Author URI:        https://mdstore.com
 * Text Domain:       mdforms
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://example.com/my-plugin/
 */

// echo 'dir = ' .__DIR__;
require_once( __DIR__ .'/inc/class.PHPForms.php' );
require_once( __DIR__ .'/admin/class.MDFormsAdmin.php' );

// Main Plugin Code

if(! class_exists(  'MDForms' )){
      $sh='mdforms';
      $form_submit = 'submit_md_form' ;

    class MDForms{
    
        public function __construct(){
            add_action( 'wp_enquque_scripts', array($this, 'enqueue_scripts') );
            add_shortcode($sh, array($this, 'form'));   
            add_action( 'wp_post_nopriv_md_action_form', array( $this, 'form_handler' ) );
            add_action( 'wp_post_md_action_form', array( $this, 'form_handler' ) );
        }
        
        public function enqueue_scripts(){
            wp_enqueue_style( $sh, plugins_url( '/public/css/style.css', __FILE__ ), array(), 0.001 );
        }

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
                'value' =>'md_action_form'
            ), 'action');
            $form->add_input('wp_nonce', array(
                'type'=>'hidden', 
                'value' =>wp_create_nonce( $form_submit)
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
                printf('<div class="message success">%s</div>', __('great', $sh));        
            }

            // build the form
            $form->build_form();

            return ob_get_clean();
        }

        public function form_handler(){
            $post = $_POST;

            if( ! isset( $post['wp_nonce'] || wp_verify_nonce( $post['wp_nonce'], $form_submit ))){
                wp_die( 'Error submitting form', title, args )
            }
            
            // check required fields
            //.................
            //insert the post
            $postarr = array(
                'post_author'=>1, 
                'post_title'=>sanitize_text_field( $post['name'] ), 
                'post_type'=> $sh, 
                'post_status'=>'publish',

                'meta_input'=>arrar(
                    'phone' => sanitize_text_field( $post['phone'] ), 
                    'address' => sanitize_text_field( $post['addtrss'] ), 
                )
            );
            $post_id = _insert_post( $postarr, true );
            if( is_wp_error($post_id, true ){
                wp_die( 'errrrrrr' );
            }
        }
    }
}
$mdForms = new MDForms; 
// $mdForms = new MDForms(); 
