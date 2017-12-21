<?php
namespace bz0\kintoneasy\app;

class info {
    private $config;
    
    public function __construct($config){
        $this->config = $config;
    }
    
    public function fetchAll($content){
        $file = "apps.json";
        $req  = new \bz0\kintoneasy\request($this->config, $file);
        $res  = $req->send($content);
        
        $count   = count($res['apps']);
        $already = $count;
        $limit   = 100;
        
        $i = 0;
        
        while($count==100){
            $offset = $already + ($limit * $i);
            $content['offset'] = $offset;
            
            $tmp  = $req->send($content);
            $count = count($tmp['apps']);
            $res['apps'] = array_merge($res['apps'], $tmp['apps']);
            
            $i++;
        }
        
        return $res;
    }
}
