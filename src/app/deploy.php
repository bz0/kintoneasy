<?php
namespace bz0\kintoneasy\app;

class deploy {
    private $config;
    
    public function __construct($config){
        $this->config = $config;
    }
    
    public function exec($content){
        $file = "preview/app/deploy.json";
        
        $req  = new \bz0\kintoneasy\request($this->config, $file);
        $res  = $req->send($content);
        
        return $res;
    }
}
