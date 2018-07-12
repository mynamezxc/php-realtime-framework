<?php
    class config {

        public $default_controller  = "home";

        //You must be create a remote server in controllers folder with default structure
        //***namespace Realtime;
        //***use Ratchet\MessageComponentInterface;
        //***use Ratchet\ConnectionInterface;
        //***require '../application/disks/autoload.php';
        //***Create class ZXC_remote implements MessageComponentInterface
        //***    DEMO FILE application/controllers/price.php

        public $server_websocket    = "open";//close
        public $server_default_port = 8080;
        public $server_file_name    = "server.php";
        public $remote_file_name    = "price.php";
        public $remote_server       = "";//windows, linux or centos
        public $php_exe_path        = "";//Server will auto get php.exe if php_exe_path empty

        function __construct($path = null) {

            $this->remote_server = is_array($this->getOS()) ? $this->getOS()['type'] : $this->getOS();
            defined('ApplicationFolder') OR define('ApplicationFolder', $path['applicationFolder']);
            defined('ControllerFolder') OR define('ControllerFolder', $path['controllerFolder']);
            defined('ModelFolder') OR define('ModelFolder', $path['modelFolder']);
            defined('ViewFolder') OR define('ViewFolder', $path['viewFolder']);
            defined('LibraryFolder') OR define('LibraryFolder', $path['libraryFolder']);
            defined('HelperFolder') OR define('HelperFolder', $path['helperFolder']);
            defined('DiskFolder') OR define('DiskFolder', $path['diskFolder']);
            defined('baseUrl') OR define('baseUrl', $path['baseUrl']);
            defined('indexPath') OR define('indexPath', $path['indexPath']);

        }

        public function getOS() {

            $os_platform  = "Unknown OS Platform";
            $os_array     = [
                '/windows nt 10/i'      =>  ['name' => 'Windows 10', 'type' => 'windows'],
                '/windows nt 6.3/i'     =>  ['name' => 'Windows 8.1', 'type' => 'windows'],
                '/windows nt 6.2/i'     =>  ['name' => 'Windows 8', 'type' => 'windows'],
                '/windows nt 6.1/i'     =>  ['name' => 'Windows 7', 'type' => 'windows'],
                '/windows nt 6.0/i'     =>  ['name' => 'Windows Vista', 'type' => 'windows'],
                '/windows nt 5.2/i'     =>  ['name' => 'Windows Server 2003/XP x64', 'type' => 'windows'],
                '/windows nt 5.1/i'     =>  ['name' => 'Windows XP', 'type' => 'windows'],
                '/windows xp/i'         =>  ['name' => 'Windows XP', 'type' => 'windows'],
                '/windows nt 5.0/i'     =>  ['name' => 'Windows 2000', 'type' => 'windows'],
                '/windows me/i'         =>  ['name' => 'Windows ME', 'type' => 'windows'],
                '/win98/i'              =>  ['name' => 'Windows 98', 'type' => 'windows'],
                '/win95/i'              =>  ['name' => 'Windows 95', 'type' => 'windows'],
                '/win16/i'              =>  ['name' => 'Windows 3.11', 'type' => 'windows'],
                '/macintosh|mac os x/i' =>  ['name' => 'Mac Os', 'type' => 'mac'],
                '/mac_powerpc/i'        =>  ['name' => 'Mac Os', 'type' => 'mac'],
                '/linux/i'              =>  ['name' => 'Linux', 'type' => 'linux'],
                '/ubuntu/i'             =>  ['name' => 'Ubuntu', 'type' => 'linux'],
                '/iphone/i'             =>  ['name' => 'Iphone', 'type' => 'mobile'],
                '/ipod/i'               =>  ['name' => 'Ipod', 'type' => 'mobile'],
                '/ipad/i'               =>  ['name' => 'Ipad', 'type' => 'mobile'],
                '/android/i'            =>  ['name' => 'Android', 'type' => 'mobile'],
                '/blackberry/i'         =>  ['name' => 'BlackBerry', 'type' => 'mobile'],
                '/webos/i'              =>  ['name' => 'Mobile', 'type' => 'mobile']
            ];
            foreach ($os_array as $regex => $value) {
                if (preg_match($regex, $_SERVER['HTTP_USER_AGENT'])) {
                    $os_platform = $value;
                }
            }
            return $os_platform;
        }
        

    }