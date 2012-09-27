<?php

namespace DependencyInjectionContainers
{
    /**
     * Injection class interface
     */
    interface IInjectionClass
    {
        /**
         * Add constructor argument
         * @param string $ParameterName
         * @param string $ParameterValue
         * @return IInjectionClass
         */
        public function WithConstructorArgument($ParameterName, $ParameterValue);

        /**
         * Sets as Static
         * @return IInjectionClass
         */
        public function AsSingleton();

        /**
         * Checks if class is singleton
         * @return bool
         */
        public function IsSingleton();

        /**
         * Gets class name
         * @return string class name
         */
        public function GetClassName();

        /**
         * Gets constructor argument
         * @param string $ParameterName
         * @return string value
         */
        public function GetConstructorArgument($ParameterName);

        /**
         * Returns if the constructor argument exists
         * @param string $ParameterName
         * @return bool
         */
        public function HasConstructorArgument($ParameterName);

        /**
         * Gets all constructor arguments
         * @return array
         */
        public function GetConstructorAgruments();
    }
}

