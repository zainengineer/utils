#!/usr/bin/env php
<?php
class ZCopy
{
    protected function getData()
    {
        $vFilePath = dirname(dirname(__FILE__)) . '/local_data/data.json';
        if (!file_exists($vFilePath)){
            return ['add__data.json__in__local_data' =>"sample is provided, value will be copied to clipboard \n
            write json into  " . dirname(__DIR__) . '/local_data' ];
        }
        $aMap = json_decode(file_get_contents($vFilePath), true);
        return $aMap;
    }
    protected function install()
    {
        $vTarget = dirname(__FILE__) . '/zcopy.bash';
        $vLink = "/usr/bin/zcopy";
        symlink($vTarget,$vLink) ?
            $this->haltError('Symlink created'):
            $this->haltError('Unable to create symlink');
    }

    protected function getKey()
    {
        global $argv;
        $aArguments = $argv;
        unset($aArguments[0]);
        $vArguments = $aArguments ? implode(' ', $aArguments) : '';
        return $vArguments;
    }

    protected function getToCopy()
    {
        $aMap = $this->getData();
        $vKey = $this->getKey();
        if ($vKey == 'list'){
            $this->haltError(print_r($aMap,true));
        }
        $vKey || $this->haltError('key not provided, try list');
        ($vKey != 'install') || $this->install();
        isset($aMap[$vKey]) || $this->haltError('key not found, try list');
        return $aMap[$vKey];
    }

    protected function copyText($vCopy)
    {
//        $this->copyUsingDirectPipe($vCopy);
//        $this->copyTextUsingBash($vCopy);
        echo $vCopy;
    }

    protected function copyTextUsingBash($vCopy)
    {
//        echo $vCopy . "\n";
//        exit;
        $vcopy = 'test';
        $vCopy = escapeshellcmd($vCopy);
        $cmd = "bash -c \" (echo $vCopy | xclip) \"";
        echo $cmd . "\n";
        echo "executing \n";
        shell_exec($cmd);
    }

    protected function copyUsingDirectPipe($vCopy)
    {
        $aDescriptorSpec = array(
            0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
            2 => array("pipe", "w"),  // stdout is a pipe that the child will write to
//            2 => array("file", "/tmp/error-output.txt", "a") // stderr is a file to write to
        );

        $vCwd = '/tmp';
        $aEnv = array('some_option' => 'aeiou');
        $aEnv = null;
        $vCommand = 'php';
//        $vCommand = 'xclip';
//        $vCommand = 'DISPLAY=:0 xclip';
        $vInput = '<?php print_r($_ENV); ?>';
//        $vInput = $vCopy;
        $rProcessor = proc_open($vCommand, $aDescriptorSpec, $aPipes, $vCwd, $aEnv);

        if (is_resource($rProcessor)) {
            // $pipes now looks like this:
            // 0 => writeable handle connected to child stdin
            // 1 => readable handle connected to child stdout
            // Any error output will be appended to /tmp/error-output.txt

            fwrite($aPipes[0], $vInput);
            fclose($aPipes[0]);

            $stdout = stream_get_contents($aPipes[1]);
            fclose($aPipes[1]);

            $error = stream_get_contents($aPipes[2]);
            fclose($aPipes[2]);

            // It is important that you close any pipes before calling
            // proc_close in order to avoid a deadlock
            $return_value = proc_close($rProcessor);
            echo "error is: $error\n";
            echo "stdout is: $stdout\n";
            echo "command returned $return_value\n";

        }

        else{
            echo "command is not resource\n";
        }

    }

    protected function copyToClip()
    {
        $vText = $this->getToCopy();
        $this->copyText($vText);
    }

    public function run()
    {
        $this->copyToClip();
    }
    public function haltError($vMessage){
//        die($vMessage);
        fwrite(STDERR, $vMessage . "\n");
        die();
    }
}

$zCopy = new ZCopy();
$zCopy->run();