<?php


if( ! class_exists(  'MDFormsAdmin' )){

    class MDFormsAdmin{
        public function __construct(){
            add_action( 'init', array($this, 'create_post_type') );
        }
        
        public function create_post_type(){
                register_post_type( 'mdforms', array(
                    'label'=>array(
                        'name'=>__('MD Orders', 'mdforms'),
                        'short_name'=>__('MD Orders', 'mdforms')
                    ), 
                    'public'=>false,
                    'has_archive'=>false, 
                    'show_ui'=>true, 
                    'show_in_nav_menu'=>false, 
                    'menu_icon'=> 'dashicons-menu', 
                    'supports'=>array(
                        'title', 'editor', 'custom-fields'
                    )

                ) 
                    );
        }
    }

}
$mdFormsAdmin = new MDFormsAdmin;
