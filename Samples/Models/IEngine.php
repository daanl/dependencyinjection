<?php
namespace Samples\Models
{
    /**
     * Engine interface
     */
    interface IEngine
    {
        public function Start();
        public function Stop();
    }
}