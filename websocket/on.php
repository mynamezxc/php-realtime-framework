<?php

    require "../application/config/config.php";
    $config = new config();
    
    if($config->server_websocket) {
        if($config->remote_server == "windows") {
            if($config->php_exe_path !== "") {
                //Disabled windows
                die("Operating system is not yet supported. Try again later");
                $command_script = "nohup {$config->php_exe_path} {$config->server_file_name} logs/nohup.log 2>&1 &";
                $a = shell_exec ($command_script);
                $command_script = "echo $! > pids/pid_proccess.txt";
                shell_exec ($command_script);
            } else {
                //Disabled windows
                die("Operating system is not yet supported. Try again later");
                $command_script = "where php.exe";
                $php_exe_path = trim(preg_replace('/\s\s+/', ' ', shell_exec ($command_script)));
                $command_script = "nohup {$php_exe_path} {$config->server_file_name} logs/nohup.log 2>&1 &";
                echo $command_script;
                $a = shell_exec ($command_script);
                $command_script = "echo $! > pids/pid_proccess.txt";
                shell_exec ($command_script);
            }
        } else if($config->remote_server == "linux" || $config->remote_server == "centos") {
            $command_script = "nohup php ".$config->server_file_name." > logs/nohup.log 2>&1 &";
            shell_exec ($command_script);
            $command_script = "echo $! > pids/pid_proccess.txt";
            shell_exec ($command_script);
        } else {
            die("Server is not supported.");
        }
    }