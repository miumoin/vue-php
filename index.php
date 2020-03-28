<?php
/*
 * Project: Vuedoo Framework
 * Copyright: 2020, Moin Uddin (pay2moin@gmail.com)
 * Version: 1.0
 * Author: Moin Uddin
 */
	$url = $_SERVER['REQUEST_URI'];
    //starting a secured session
    session_start();

    include ( "config/connection.php" );
    include ( "includes/functions.php" );

    //breaking the url to many parts
    $break = explode ( "/", $url );

    //broken useful parts starts from the array position $start
    $start = START;

    /*Start routing*/
    $option = $break[ $start ];
    if ( ( $option == "" ) || !file_exists( "modules/" . $option . '.php' ) ) $option = "app";

    include ( "modules/" . $option . ".php" );

    /* if a class exists with the string of $option, create the object */
    if( class_exists ( $option ) ) {
        $option_obj = new $option();
        /* call method based on URL structure */
        for( $j = ( count( $break ) - START ); $j >= 0; $j-- ) {
            $break_point_method = '';
            for( $i = 1; $i < ( $j ); $i++ ) {
                $break_point_method .= ( $break_point_method != '' ? '_' : '' ) . $break[ START + $i ];
            }

            if( method_exists( $option_obj, $break_point_method ) ) {
                $option_obj->$break_point_method();
                break;
            }
        }

        if( ( $break_point_method == '' ) && ( method_exists( $option_obj, $option . '_method' ) ) ) {
            $break_point_method = $option . '_method';
            $option_obj->$break_point_method();
        }
    }
 ?>
