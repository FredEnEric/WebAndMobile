<?php

namespace controller;

use util\Executor;

abstract class BaseController {

    public function __construct( $repository ) {
        $this->repository = $repository;
    }

    public function handleFindAll() {
        $statuscode = 200;
        $result = Executor::try( $this->repository->findAll() );
        
        if ( !is_array( $result ) ) {
            $statuscode = 500;
        }

        $this->returnJSON( $result, $statuscode );
    }

    public function handleFind( $id ) {
        $statuscode = 200;
        $result = Executor::try( $this->repository->find( $id ) );
        
        if ( !$result ) {
            $statuscode = 204;
        } elseif ( is_string( $result )) {
            $statuscode = 500;
        }

        $this->returnJSON( $result, $statuscode );
    }

    public function handleCreate( $object ) {
        $createdObject = null;
        $statuscode = 201;

        if ( isset( $object ) ) {
            $createdObject = Executor::try( $this->repository->create( $object ));
            if ( is_string( $createdObject ) || $createdObject === null ) {
                $statuscode = 500;
            } 
        } else {
            $statuscode = 400;
        }
        
        $this->returnJSON( $createdObject, $statuscode );
    }
  
    protected function returnJSON( $object, $statuscode ) {
        header( 'Content-Type: application/json' );
        http_response_code( $statuscode );
        echo json_encode( $object );
    }
}