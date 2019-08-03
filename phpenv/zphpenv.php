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

    protected function getCommandBasedOnArgument()
    {
        global $argv;
        $arguments = $argv;
        $firstArgument = isset($arguments[1]) ? $arguments[1] : '';
        if (in_array($firstArgument, [
            'restart',
            'start',
        ])) {
            return $this->fpmExecCommand($firstArgument);
        }
        else{
            return "echo unexecpted result for $firstArgument";
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