#!/usr/bin/env php
<?php

class ZPhpEnv
{
    protected function getPhpExecPath()
    {
        return shell_exec('phpenv which php');
    }

    protected function getPhpEnvCurrentFolder()
    {
        return dirname(dirname($this->getPhpExecPath()));
    }

    protected function phpFpmInitPath()
    {
        return $this->getPhpEnvCurrentFolder() . '/etc/init.d/php-fpm';
    }

    protected function fpmExecCommand($argument)
    {
        $path = $this->phpFpmInitPath();
        return "$path $argument";
    }
    protected function processFirstArgumentOnly($firstArgument)
    {
        if (in_array($firstArgument, [
            'restart',
            'start',
            'stop',
        ])) {
            return $this->fpmExecCommand($firstArgument);
        }
        else{
            return "echo unexecpted result for $firstArgument";
        }
    }
    protected function getCommandBasedOnArgument()
    {
        global $argv;
        $arguments = $argv;
        if(isset($arguments[1])){
            return $this->processFirstArgumentOnly($arguments[1]);
        }
        else{
            return "echo no arguments provided, try something like zphpenv restart";
        }
    }

    protected function test()
    {
        return $this->getCommandBasedOnArgument();
    }

    public function run()
    {
        echo $this->test();
    }
}

$zCopy = new ZPhpEnv();
$zCopy->run();