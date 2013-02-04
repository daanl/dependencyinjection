<?php
namespace ClassLoaders
{
    /**
     * Namespace class loader
     */
    class NamespaceClassLoader
    {
        /* @var $_includePaths string */
        protected $_includePaths;

        /* @var $_nameSpaceSeparator string */
        protected $_nameSpaceSeparator = '\\';

        /* @var $_directorySeparator string */
        protected $_directorySeparator = '/';

        /* @var $_fileExtensions array */
        protected $_fileExtensions = array('php', 'fn');

        /**
         * @param array $includePaths
         */
        public function __construct(array $includePaths)
        {
            $this->_includePaths = $includePaths;
        }

        /**
         * Loads class
         * @param string $className
         * @return bool
         */
        public function loadClass($className)
        {
            $classParts = explode($this->_nameSpaceSeparator, $className);

            $className = array_pop($classParts);
            $directory = implode($this->_directorySeparator, $classParts);

            $path = $this->_directorySeparator . $directory . $this->_directorySeparator . $className;

            $fullPath = $this->tryFindFile($this->_includePaths, $path);

            // if we cant find file maybe complete filepath is lowercase try that
            if (!is_file($fullPath))
            {
                $path = $this->_directorySeparator . strtolower($directory) . $this->_directorySeparator . $className;

                $fullPath = $this->tryFindFile($this->_includePaths, $path);

                if (!is_file($fullPath))
                {
                    return false;
                }
            }

            require_once $fullPath;

            return class_exists($className, false);
        }

        /**
         * @param array $includePaths
         * @param string $classFilePath
         * @return null|string
         */
        private function tryFindFile(array $includePaths, $classFilePath)
        {
            $completeClassPath = null;

            foreach ($includePaths AS $includePath)
            {
                foreach ($this->_fileExtensions AS $fileExtension)
                {
                    $path = realpath($includePath) . $classFilePath . '.' . $fileExtension;

                    if (is_file($path))
                    {
                        $completeClassPath = $path;
                        break;
                    }

                    $path = strtolower(realpath($includePath)) . $this->_directorySeparator . $classFilePath . '.' . $fileExtension;

                    if (is_file(strtolower($path)))
                    {
                        $completeClassPath = $path;
                        break;
                    }
                }

                if ($completeClassPath != null)
                {
                    break;
                }
            }

            return $completeClassPath;
        }
    }
}