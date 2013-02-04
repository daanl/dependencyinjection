<?php
namespace Samples\Models
{
    /**
     * Default engine
     */
    class DefaultEngine implements IEngine
    {

        public function Start()
        {
            echo "Starting default engine!.<br />";
        }

        public function Stop()
        {
            echo "Stopping default engine!<br />";
        }
    }
}