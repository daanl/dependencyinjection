<?php
namespace Samples\Models
{
    /**
     * Car interface
     */
    interface ICar
    {
        /**
         * @return IDriver
         */
        public function Driver();

        /**
         * @return IEngine
         */
        public function Engine();
    }
}