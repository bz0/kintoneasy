<?php
namespace bz0\kintoneasy\record;

class delete implements methodInterface{
    private $config;
    
    public function __construct($config){
        $this->config = $config;
    }
    
    public function record($content){
        $file = "record.json";
        $req  = new bz0\kintoneasy\request($this->config, $file);
        $res  = $req->send($content);
        
        return $res;
    }
    
    public function records($content){
        $file = "records.json";
        $req  = new bz0\kintoneasy\request($this->config, $file);
        $res  = $req->send($content);
        
        return $res;
    }
}
