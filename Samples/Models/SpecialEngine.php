<?php
namespace Samples\Models
{
    /**
     * SpecialEngine
     */
    class SpecialEngine implements IEngine
    {
        /**
         * @param $startParameter
         * @param $stopParameter
         */
        public function __construct(
            $startParameter,
            $stopParameter
        )
        {
            $this->_startParameter = $startParameter;
            $this->_stopParameters = $stopParameter;
        }

        public function Start()
        {
            echo "Starting special engine: $this->_startParameter!.<br />";
        }

        public function Stop()
        {
            echo "Stopping special engine: $this->_stopParameters!<br />";
        }
    }
}