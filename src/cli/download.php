<?php
namespace bz0\kintoneasy\cli;

class download {
    private $config;
    
    public function __construct($config){
        $this->config = $config;
        putenv("PATH={$config['path']}");
    }
    
    public function exec($appId, $output){
        $cmd = "cli-kintone -u {$this->config['user']} -p {$this->config['password']} -d {$this->config['subdomain']} -a {$appId} -e sjis > {$output}";
        exec($cmd, $res, $status);
        
        return $res;
    }
}