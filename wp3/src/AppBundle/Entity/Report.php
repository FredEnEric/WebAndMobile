<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Report
 *
 * @ORM\Table(name="reports", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="location_id", columns={"location_id"}), @ORM\Index(name="technician_id", columns={"technician_id"})})
 * @ORM\Entity
 */
class Report
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="handled", type="boolean", nullable=false)
     */
    private $handled = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="technician_id", type="integer", nullable=true)
     */
    private $technicianId;
    
    /**
     * @var \AppBundle\Entity\Technician
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Technician")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="technician_id", referencedColumnName="id")
     * })
     */
    private $technician;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var \AppBundle\Entity\Location
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="location_id", type="integer", nullable=true)
     */
    private $locationId;

    // Setters
    public function setId( $id ) {
        $this->id = $id;
    }

    public function setLocationId( $locationId ) {
        $this->locationId = $locationId;
    }
    
    public function setLocation( $location ) {
        $this->location = $location;
    }

    public function setDate( $date ) {
        $this->date = $date;
    }
    
    public function setText( $text ) {
        $this->text = $text;
    }

    public function setHandled( $handled ) {
        $this->handled = $handled;
    }

    public function setTechnicianId( $technicianId ) {
        $this->technicianId = $technicianId;
    }
    
    public function setTechnician( $technician ) {
        $this->technician = $technician;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getLocationId() {
        return $this->locationId;
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

    public function getHandled( $readable = false ) {
        if ( $readable )
            return ( $this->handled ) ? 'Handled' : 'Not handled';
        else
            return $this->handled;
    }

    public function getTechnicianId() {
        return $this->technicianId;
    }
    
    public function getTechnician() {
        return $this->technician;
    }
}