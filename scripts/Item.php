<?php
    ini_set( 'display_errors', 1 );
    ini_set( 'display_startup_errors', 1 );
    error_reporting( E_ALL );
    include( "DBConnection.php" );
    
    class Item extends DBConnection {
        private $config;
        private $PDOConnection;
        private $item;
        private $images;
        
        public function __construct ( $id ) {
            $item_id = $id;
            $this->config = parse_ini_file( '../Config.ini' );
            $this->PDOConnection = $this->getConnection();
            $this->item = $this->findItem( $item_id );
            $this->images = $this->findImages( $item_id );
        }
        
        private function findItem ( $id ) {
            $sql = 'SELECT * FROM item WHERE item_id = :id';
            $stmt = $this->PDOConnection->prepare( $sql );
            $stmt->bindParam( ':id', $id, PDO::PARAM_INT );
            $stmt->execute();
            return ( PDO::FETCH_ASSOC );
        }
        
        private function findImages ( $id ) {
            $sql = 'SELECT image_url FROM item_images WHERE item_id = :id';
            $stmt = $this->PDOConnection->prepare( $sql );
            $stmt->bindParam( ':id', $id, PDO::PARAM_INT );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        }
        
        protected function validateAndSanitize () {
            // TODO: Implement validateAndSanitize() method.
        }
    }