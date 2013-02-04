<?php
namespace Samples\Models
{
    /**
     * SpecialDriver
     */
    class SpecialDriver implements IDriver
    {
        private $someArgument;

        /**
         * @param $someArgument
         */
        public function __construct(
            $someArgument
        )
        {
            $this->_someArgument = $someArgument;
        }

        public function Drive()
        {
            echo "Driving the special car $this->_someArgument!...<br />";
        }
    }
}