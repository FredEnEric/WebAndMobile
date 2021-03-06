<?php

namespace tests\model\dao;

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use model\Action;
use model\Location;
use model\dao\ActionDAO;
use tests\util\GUID;

class ActionDAOTests extends TestCase {

    public function setUp() {
        $this->connection = new \PDO('sqlite::memory:');
        $this->connection->exec( 
            'CREATE TABLE actions (
            id INTEGER, 
            action TEXT,
            date TEXT,
            location_id INTEGER,
            PRIMARY KEY (id))'
        );
        $this->connection->exec( 
            'CREATE TABLE locations (
            id INTEGER, 
            name TEXT,
            PRIMARY KEY (id))'
        );
        $this->actionDAO = new ActionDAO( $this->connection );
    }

    public function tearDown() {
        $this->connection = null;
        $this->actionDAO = null;
    }

    public function testFind_IdExists_ActionObject() {
        //Arrange
        $action = $this->createAction();
        $this->addToTable( $action );
        //Act
        $actualAction = $this->actionDAO->find( $action->getId() );
        //Assert
        $this->assertEquals( $action, $actualAction );
    }

    public function testFind_IdDoesNotExist_Null() {
        //Arrange
        //Act
        $actualAction = $this->actionDAO->find( rand() );
        //Assert
        $this->assertNull( $actualAction );
    }

    public function testFind_TableActionsDoesntExist_Exception() {
        //Arrange
        $this->expectException( \Error::class );
        $this->connection->exec( "DROP TABLE actions" );
        //Act
        $this->actionDAO->find( 1 );
    }

    public function testFindAll_MultipleActionsExist_ActionObjectArray() {
        //Arrange
        $actions = array();
        $actions[0] = $this->createAction();
        $this->addToTable( $actions[0] );
        $actions[1] = $this->createAction();
        $this->addToTable( $actions[1] );
        //Act
        $actualActions = $this->actionDAO->findAll();
        //Assert
        $this->assertEquals( sort( $actions ), sort( $actualActions ));
    }
    
    public function testFindAll_TableActionsDoesntExist_Exception() {
        //Arrange
        $this->expectException( \Error::class );
        $this->connection->exec( "DROP TABLE actions" );
        //Act
        $this->actionDAO->findAll();
    }

    public function testCreate_ValidActionObjectWithoutIdProvided_ActionObjectWithId() {
        //Arrange
        $action = $this->createAction();
        $action->setId( null );
        //Act
        $createdAction = $this->actionDAO->create( $action );
        //Assert
        $this->assertNotNull( $createdAction->getId() );
        $this->assertEquals( $action->getAction(), $createdAction->getAction() );
        $this->assertEquals( $action->getDate(), $createdAction->getDate() );
    }

    public function testCreate_NullActionObject_Exception() {
        //Arrange
        $this->expectException( \Error::class );
        $action = null;
        //Act
        $createdAction = $this->actionDAO->create( $action );
    }

    private function addToTable( $action ) {
        $this->connection->exec(
            "INSERT INTO actions (id, action, date, location_id) 
            VALUES (".$action->getId().",'".$action->getAction()."','".$action->getDate()."', ".$action->getLocation()->getId().");"
        );
        $location = $action->getLocation();
        $this->connection->exec(
            "INSERT INTO locations (id, name) 
            VALUES (".$location->getId().",'".$location->getName()."');"
        );
    }

    private function createAction() {
        $text = GUID::create();
        $dateArray = getdate();
        $date = $dateArray['year'].'-'.$dateArray['mon'].'-'.$dateArray['mday'];
        $id = rand();
        $location = new Location( GUID::create(), rand() );
        return new Action( $text, $date, $location, $id );
    }

}
