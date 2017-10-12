<?php

namespace model\factories;

use model\Report;

abstract class ReportFactory {
    public static function CreateFromArray( $array ) {
        return new Report(
            $array['id'],
            $array['location_id'],
            $array['date'],
            $array['handled'],
            $array['technician_id']
        );
    }
}