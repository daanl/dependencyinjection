<?php

namespace DependencyInjectionContainers
{
    /**
     * Injection class
     */
    class InjectionClass implements IInjectionClass
    {
        private $_AsSingleton;
        private $_ClassName;
        private $_ConstructorArguments = array();

        /**
         * @param string $ClassName
         */
        public function __construct($ClassName)
        {
            $this->_ClassName = $ClassName;
        }

        /**
         * @param string $parameterName
         * @param mixed $parameterValue
         * @return InjectionClass
         */
        public function WithConstructorArgument($parameterName, $parameterValue)
        {
            $this->_ConstructorArguments[$parameterName] = $parameterValue;

            return $this;
        }

        /**
         * Sets as Static
         * @return IIjectionClass
         */
        public function AsSingleton()
        {
            $this->_AsSingleton = true;

            return $this;
        }

        /**
         * Checks if class is singleton
         * @return bool
         */
        public function IsSingleton()
        {
            return $this->_AsSingleton;
        }


        /**
         * Gets class name
         * @return string class name
         */
        public function GetClassName()
        {
            return $this->_ClassName;
        }

        /**
         * Gets constructor argument
         * @param string $ParameterName
         * @return string value
         */
        public function GetConstructorArgument($ParameterName)
        {
            return (isset($this->_ConstructorArguments[$ParameterName])) ? $this->_ConstructorArguments[$ParameterName] : null;
        }

        /**
         * Returns if the constructor argument exists
         * @param string $ParameterName
         * @return bool
         */
        public function HasConstructorArgument($ParameterName)
        {
            return (isset($this->_ConstructorArguments[$ParameterName]));
        }

        /**
         * Gets all constructor arguments
         * @return array
         */
        public function GetConstructorAgruments()
        {
            return $this->_ConstructorArguments;
        }
    }
}
