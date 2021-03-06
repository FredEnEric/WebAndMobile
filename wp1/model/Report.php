<?php

namespace model;

class Report implements \JsonSerializable {
    
    private $id;
	private $location;
	private $date;
	private $handled;
	private $technician;

    function __construct( $date, $text, $handled, $location, $technician = null, $id = null ) {
        $this->setId( $id );
        $this->setLocation( $location );
        $this->setDate( $date );
        $this->setText( $text );
        $this->setHandled( $handled );
        $this->setTechnician( $technician );
    }

    // Setters
    public function setId( $id ) {
        $this->id = $id;
    }

    public function setLocation( $location ) {
        $this->location = $location;
    }

    public function setDate( $date ) {
        $this->date = $date;
    }

    public function setHandled( $handled ) {
        if ( \is_string( $handled )) {
            $handled = ((int) $handled) === 1;
        }
        $this->handled = $handled;
    }

    public function setTechnician( $technician ) {
        $this->technician = $technician;
    }

    public function setText ( $text ) {
        $this->text = $text;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getDate() {
        return $this->date;
    }

    public function getText() {
        return $this->text;
    }

    public function isHandled() {
        return $this->handled;
    }

    public function getTechnician() {
        return $this->technician;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'date' => $this->getDate(),
            'text' => $this->getText(),
            'handled' => $this->isHandled(),
            'location' => $this->getLocation(),
            'technician' => $this->getTechnician()
        ];
    }
}