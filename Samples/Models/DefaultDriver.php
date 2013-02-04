<?php
namespace Samples\Models
{
    /**
     * Driver
     */
    class DefaultDriver implements IDriver
    {

        public function Drive()
        {
            echo "Driving!...<br />";
        }
    }
}