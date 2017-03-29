<?php
/*
Plugin Name: Wordpress Constibutors plugin
Plugin URI: http://poolgab.com
Description: A simple WordPress plugin to show slideshow
Version: 1.0
Author: dungendevelop
Author URI: http://poolgab.com
License: GPL2
*/
/*
Copyright 2017  VibeThemes  (email : anshuman.sahu143@gmail.com)

Wordpress Constibutors plugin program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

Wordpress Constibutors plugin program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with wplms_customizer program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


include_once 'classes/wp-c-camp.php';



if(class_exists('Wp_Contrubutors_Class'))
{	
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('Wp_Contrubutors_Class', 'activate'));
    register_deactivation_hook(__FILE__, array('Wp_Contrubutors_Class', 'deactivate'));

    // instantiate the plugin class
    $wpsc = Wp_Contrubutors_Class::init();
}

add_action( 'plugins_loaded', 'wp_c_camp_language_setup' );
function wp_c_camp_language_setup(){
    $locale = apply_filters("plugin_locale", get_locale(), 'bmbp');
    
    $lang_dir = dirname( __FILE__ ) . '/languages/';
    $mofile        = sprintf( '%1$s-%2$s.mo', 'wp-ctbr-camp', $locale );
    $mofile_local  = $lang_dir . $mofile;
    $mofile_global = WP_LANG_DIR . '/plugins/' . $mofile;

    if ( file_exists( $mofile_global ) ) {
        load_textdomain( 'wp-ctbr-camp', $mofile_global );
    } else {
        load_textdomain( 'wp-ctbr-camp', $mofile_local );
    }   
}