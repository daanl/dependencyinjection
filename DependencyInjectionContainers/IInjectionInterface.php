<?php

namespace DependencyInjectionContainers
{
    /**
     * Injection interface
     */
    interface IInjectionInterface
    {
        /**
         * Binds interface to class
         * @param string $ClassName
         * @return IInjectionClass
         */
        public function To($ClassName);

        /**
         * Retrieves instance for bounded class
         * @return object of class
         */
        public function RetrieveInstance();
    }
}
