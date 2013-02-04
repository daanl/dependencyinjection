<?php
namespace Samples\Models
{
    /**
     * Car model
     */
    class DefaultCar implements ICar
    {
        private $_driver;
        private $_engine;

        /**
         * @param IEngine $engine
         * @param IDriver $driver
         */
        public function __construct(IEngine $engine, IDriver $driver)
        {
            $this->_driver = $driver;
            $this->_engine = $engine;
        }

        /**
         * @return IDriver
         */
        public function Driver()
        {
            return $this->_driver;
        }

        /**
         * @return IEngine
         */
        public function Engine()
        {
            return $this->_engine;
        }
    }
}
