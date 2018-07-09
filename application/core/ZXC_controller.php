<?php

    interface controller
    {
        public function __call($name, $arguments);
        public function __construct();
    }

    class ZXC_controller implements controller {

        public $call;

        public function __call($name, $arguments) {
            if (!method_exists($this, $name)) {
                try {
                    throw new ZXCException($name . ' is undefined function!', 2);
                } catch (Exception $e){
                    echo "Error: Code({$e->getCode()}) File({$e->getFile()}) Line({$e->getLine()}). Error message :" . $e->getMessage(), "\n";
                }
            }
        }

        public function __construct() {
            $this->call = new call();
            defined('CONTROLLER_PATH') or define('CONTROLLER_PATH', APPPATH . '/' . $_SERVER['path']['controllerFolder'] . '/');
            defined('MODEL_PATH') or define('MODEL_PATH', APPPATH . '/' . $_SERVER['path']['modelFolder'] . '/');
            defined('VIEW_PATH') or define('VIEW_PATH', APPPATH . '/' . $_SERVER['path']['viewFolder'] . '/');
            defined('LIBRARY_PATH') or define('LIBRARY_PATH', APPPATH . '/' . $_SERVER['path']['libraryFolder'] . '/');
            defined('HELPER_PATH') or define('HELPER_PATH', APPPATH . '/' . $_SERVER['path']['helperFolder'] . '/');
        }

    }

    class call {
    
        public function controller($file) {
            include(CONTROLLER_PATH . $file . EXT);
            return new $file();
        }

        public function model($file) {
            include(MODEL_PATH . $file . EXT);
            return new $file();
        }

        public function view($file) {
            include(VIEW_PATH . $file) . EXT;
            return new $file();
        }

        public function library($file) {
            include(LIBRARY_PATH . $file) . EXT;
            return new $file();
        }

        public function helper($file) {
            include(HELPER_PATH . $file) . EXT;
        }

    }

    class ZXCException extends Exception
    {
        protected $message = 'Unknown exception';   // exception message
        private   $string;                          // __toString cache
        protected $code = 0;                        // user defined exception code
        protected $file;                            // source filename of exception
        protected $line;                            // source line of exception
        private   $trace;                           // backtrace
        private   $previous;                        // previous exception if nested exception

        public function __construct($message = null, $code = 0, Exception $previous = null) {
            parent::__construct($message, $code, $previous);
        }
    }

    // try {
    //     $error = 'An error message';
    //     throw new ZXCException($error, 0);
    // } catch (ZXCException $e) {
    //     echo "Error: Code({$e->getCode()}) File({$e->getFile()}) Line({$e->getLine()}). Error message :" . $e->getMessage(), "\n";
    // }
    ////////////////////////////// Code Exception ////////////////////////////////
    // 1 : Unable to load class
    // 2 : Undefined function