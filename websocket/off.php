<?php

    require "../application/config/config.php";
    $config = new config();
    
    if($config->server_websocket) {
        if($config->remote_server == "windows") {
            $command_script = "kill -9 `more pid_proccess.txt`";
            shell_exec ($command_script);
        } else if($config->remote_server == "linux" || $config->remote_server == "centos") {
            $command_script = "kill -9 `cat pids/pid_proccess.txt`";
            shell_exec ($command_script);
        }
    }