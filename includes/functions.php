<?php
/*
 * Project: Double-P Framework
 * Copyright: 2011-2012, Moin Uddin (pay2moin@gmail.com)
 * Version: 1.0
 * Author: Moin Uddin
 */
function dbconnect() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    } else return $mysqli;
}

function module_include($module) {
    global $option, $mysqli;
	if(file_exists("modules/".$module."/".$module.".php")) include("modules/".$module."/".$module.".php");
}

function display_html( $path, $data = array() ) {
    if( file_exists ( 'htmls/' . $path . '.php' ) ) {
        include ( 'htmls/' . $path . '.php' );
    }
}

function get_curl_data($body_url){
    $curl_handle=curl_init();
    curl_setopt($curl_handle, CURLOPT_URL,$body_url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl_handle, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
    $html_data = curl_exec($curl_handle);
    curl_close($curl_handle);

    return $html_data;
}

function add_components( $path = '', $data = array() ) {
    if( $path == '' ) $path = 'app';
    $components = array();
    $components_path = 'htmls/' . $path . '/components';
    if( is_dir( $components_path ) ) {
        $component_files = scandir( $components_path );
        foreach( $component_files as $component ) {
            $extbr = explode( '.', $component );
            if( count( $extbr ) == 2 && $extbr[1] == 'php' ) {
                $components[] = str_replace( '.' . $extbr[1], '', $component );
                $_the_route = str_replace( '$', ':', str_replace( ':', '/', $component ) );
                $_the_component = str_replace( '.php', '', str_replace( array( ':$' , ':' ), '_', $component ) );
                include( $components_path . '/' . $component );    
            }   
        }
    }
    return $components;
}

function add_component( $path, $data = array() ) {
    if( file_exists ( 'htmls/components/' . $path . '.php' ) ) {
        include ( 'htmls/components/' . $path . '.php' );
    }
}
?>
