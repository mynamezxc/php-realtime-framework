<?php

    class socket extends ZXC_controller implements controller {

        private $socketName = "websocket";

        public function __construct() {
            parent::__construct();
        }
        
        public function open() {

            if($this->config->server_websocket) {

                if($this->config->remote_server == "windows") {
                    
                    
                    if($this->config->php_exe_path !== "") {
    
                        //Disabled windows
                        $command_script = "start \"{$this->socketName}\" {$this->config->php_exe_path} {$this->config->server_file_name}";
                        $a = shell_exec ($command_script);
    
                    } else {
    
                        //Disabled windows
                        $command_script = "where php.exe";
                        $php_exe_path = trim(preg_replace('/\s\s+/', ' ', shell_exec ($command_script)));
                        
                        //Get path
                        if(substr($this->config->server_php_path, -1) == "/" || substr($this->config->server_php_path, -1) == "\\") {
                            $server_php_path = substr($this->config->server_php_path, 0, -1);
                        } else {
                            $server_php_path = str_replace(["/{$this->config->server_file_name}", "\\{$this->config->server_file_name}"], "", $this->config->server_php_path);
                        }

                        //Move
                        $command_script = "cd {$server_php_path}";
                        shell_exec($command_script);

                        $command_script = "start \"{$this->socketName}\" {$php_exe_path} {$server_php_path}/{$this->config->server_file_name}";
                        $a = shell_exec ($command_script);
    
                    }
    
                } else if($this->config->remote_server == "linux" || $this->config->remote_server == "centos") {
    
                    $command_script = "nohup php ".$this->config->server_file_name." > logs/nohup.log 2>&1 &";
                    shell_exec ($command_script);
                    $command_script = "echo $! > pids/pid_proccess.txt";
                    shell_exec ($command_script);
    
                } else {
                    die("Server is not supported.");
                }
            }
        }

        public function close() {
            
            if($this->config->server_websocket) {
                if($this->config->remote_server == "windows") {
                    $command_script = "taskkill /FI \"WindowTitle eq {$this->socketName}*\" /T /F";
                    shell_exec ($command_script);
                } else if($this->config->remote_server == "linux" || $this->config->remote_server == "centos") {
                    $command_script = "kill -9 `cat pids/pid_proccess.txt`";
                    shell_exec ($command_script);
                }
            }
        }
    }