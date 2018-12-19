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
		private $id;
		
		public function __construct( $id ) {
			$this->id = $id;
			$root = $_SERVER[ 'DOCUMENT_ROOT' ];
			$this->updatePath('Config.ini' );
			$this->config = parse_ini_file('Config.ini' );
			$this->PDOConnection = $this->getConnection();
			$this->item = $this->findItem();
			$this->images = $this->findImages( $this->item[ "item_id" ] );
		}
		
		private function findItem() {
			$sql = 'SELECT * FROM item WHERE item_id = :id';
			$stmt = $this->PDOConnection->prepare( $sql );
			$stmt->bindParam( ':id', $this->id, PDO::PARAM_INT );
			$stmt->execute();
			return $stmt->fetch( PDO::FETCH_ASSOC );
		}
		
		private function findImages( $id ) {
			$sql = 'SELECT * FROM item_images WHERE item_id = :id';
			$stmt = $this->PDOConnection->prepare( $sql );
			$stmt->bindParam( ':id', $id, PDO::PARAM_INT );
			$stmt->execute();
			return $stmt->fetchAll( PDO::FETCH_ASSOC );
		}
		
		public function getImages() {
			return $this->images;
		}
		
		public function getItem() {
			return $this->item;
		}
		
		protected function validateAndSanitize() {
			// TODO: Implement validateAndSanitize() method.
		}
	}