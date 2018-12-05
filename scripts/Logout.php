<?php
    ini_set( 'display_errors', 1 );
    ini_set( 'display_startup_errors', 1 );
    error_reporting( E_ALL );
    
    class Logout {
        public function __construct () {
            session_start();
            if ( isset( $_COOKIE[ session_name() ] ) ) {
                $_COOKIE[ session_name() ] = null;
                $_SESSION[ 'id' ] = null;
            }
            session_destroy();
            header( 'location: ../index.php' );
        }
    }
    
    new Logout();