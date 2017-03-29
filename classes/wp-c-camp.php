<?php

if(!class_exists('Wp_Contrubutors_Class'))
{   
    class Wp_Contrubutors_Class  // We'll use this just to avoid function name conflicts 
    {
            
        public static $instance;
    
        public static function init(){
            if ( is_null( self::$instance ) )
                self::$instance = new Wp_Contrubutors_Class();
            return self::$instance;
        }

        private function __construct(){
            add_action( 'add_meta_boxes',array($this, 'wp_ctbr_register_meta_boxes' ));
            add_action( 'save_post', array($this,'wp_ctbr_save_meta_box' ));
            add_filter('the_content', array($this,'wp_ctbr_show_contributors' ),999);
        }


        function wp_ctbr_show_contributors($content){
          global $post;
          $contributors = get_post_meta($post->ID,'ctbr_authors',true);
          wp_enqueue_style( 'camp-ctbr-css', plugins_url( '../assets/css/camp-ctbr.css' , __FILE__ ) );
          if(!empty($contributors) && count($contributors)){
            $html='<div class="camp_ctbrs_wrapper"><h3>'._x('Contributors','contributor heading','wp-ctbr-camp').'</h3><ul class="camp_ctbrs">';
            foreach($contributors as $cuser){
              $user =  get_user_by('id',$cuser);
              $html.='<li class=""><a href="'.get_author_posts_url($cuser,$user->display_name).'">'.get_avatar($cuser,128).'<span>'.$user->display_name.'</span></a></li>';
            }
            $html .= '</ul></div>';
            $content .= $html;
          }
            return $content;
        }

        function wp_ctbr_register_meta_boxes() {
            add_meta_box( 'wp-ctbr', __( 'Contributors', 'wp-ctbr-camp' ), array
                ($this,'wp_ctbr_my_display_callback'), array('post','page') );
        }
        
         
     
        function wp_ctbr_my_display_callback( $post ) {
            // Display code/markup goes here. Don't forget to include nonces!
          wp_nonce_field( 'campctbr_security', 'campctbr_security' );
          $saved_users = get_post_meta( $post->ID, 'ctbr_authors', true );
          $args = array(
            'who' => 'authors' 
          );
          // The Query
          $user_query = new WP_User_Query( $args );
          $users = $user_query->get_results();
          foreach ($users as $key => $user) {
            echo '<input type="checkbox" name="ctbr_authors[]" '.((!empty($saved_users) && in_array($user->ID,$saved_users))?'checked':'').' value="'.$user->ID.'"><label>'.$user->display_name.'</label></br>';
          }
        }
         
      
        function wp_ctbr_save_meta_box( $post_id ) {
            // Save logic goes here. Don't forget to include nonce checks!
            if ( ! isset( $_POST['campctbr_security'] ) || ! wp_verify_nonce( $_POST['campctbr_security'], 'campctbr_security' ) ) {
                return;
            }else{
                $users =  $_POST['ctbr_authors'];
                update_post_meta( $post_id, 'ctbr_authors', $users );
            }
        }
        
        public function activate(){
        	// ADD Custom Code which you want to run when the plugin is activated
        }
        public function deactivate(){
               	
        }
        
        
        // ADD custom Code in clas
        
    } // END class Wp_Contrubutors_Class
} // END if(!class_exists('Wp_Contrubutors_Class'))
