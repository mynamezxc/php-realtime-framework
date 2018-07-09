<?php
    class config {

        public $default_controller = "home";

        function __construct($path) {

            define('ApplicationFolder', $path['applicationFolder']);
            define('ControllerFolder', $path['controllerFolder']);
            define('ModelFolder', $path['modelFolder']);
            define('ViewFolder', $path['viewFolder']);
            define('LibraryFolder', $path['libraryFolder']);
            define('HelperFolder', $path['helperFolder']);
            define('DiskFolder', $path['diskFolder']);
            define('baseUrl', $path['baseUrl']);
            define('indexPath', $path['indexPath']);

        }

    }