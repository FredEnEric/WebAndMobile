<?php

namespace model\repositories;

require_once('vendor/autoload.php');

use \PDO;
use PDOException;
use model\factories\LocationFactory;
use model\interfaces\dao\ILocatoinDAO;
use config\DependencyInjector;

class LocatoinDAO implements ILocatoinDAO {
    
    private $connection = null;

    public function __construct( PDO $connection = null ) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM locations' );
            $statement->execute();
            $rows = $statement->fetch();
            
            $locations = array();

            for ( $i = 0; $i < count( $rows ); $i++ ) {
                $locations[$i] = LocationFactory::CreateFromArray( $rows[$i] );
            } 

            return $locations;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function find( $id ) {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM locations WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $technician = $statement->fetch();

            if ( count( $row ) > 0 ) {
                return LocationFactory::CreateFromArray( $technician[0] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function create( $name, $location_id ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO locations (name) VALUES (:name)' );
            $statement->bindParam( ':name', $name, \PDO::PARAM_INT );
            $statement->execute();

            $statement = $this->connection->prepare( 'SELECT * FROM locations ORDER BY id DESC LIMIT 1' );
            $statement->execute();
            $results = $statement->fetch();

            if ( count( $row ) > 0 ) {
                return LocationFactory::CreateFromArray( $technician[0] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }
/*
    public function update( $id, $name, $location_id ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO locations (id, name, location_id) VALUES (:id, :name, :location_id)' );
            $statement->bindParam( ':id', $id, \PDO::PARAM_INT );
            $statement->bindParam( ':name', $name, \PDO::PARAM_INT );
            $statement->bindParam( ':location_id', $location_id, \PDO::PARAM_INT );
            $statement->execute();

            $statement = $this->connection->prepare( 'SELECT * FROM locations WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $technician = $statement->fetch();

            if ( count( $row ) > 0 ) {
                return LocationFactory::CreateFromArray( $technician[0] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function delete( $id ) {
        try {
            $statement = $this->connection->prepare( 'DELETE FROM locations WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, \PDO::PARAM_INT );

            return $statement->execute();
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }
    */
}