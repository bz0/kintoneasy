<?php
namespace bz0\kintoneasy\record;

class get implements methodInterface{
    private $config;
    
    public function __construct($config){
        $this->config = $config;
    }
    
    public function record($content){
        $file = "record.json";
        $req  = new \bz0\kintoneasy\request($this->config, $file);
        $res  = $req->send($content);
        
        return $res;
    }
    
    public function records($content){
        $file = "records.json";
        $req  = new \bz0\kintoneasy\request($this->config, $file);
        $res  = $req->send($content);
        
        return $res;
    }
    
    public function fetchAll($content){
        $file = "records.json";
        $req  = new \bz0\kintoneasy\request($this->config, $file);
        $res  = $req->send($content);
        $query = $content['query'];
        
        $total   = $res['totalCount'];
        $limit   = 100;
        $already = count($res['records']);
        $reqCnt  = ceil(($total - $already) / $limit);
        
        for($i=0; $i<$reqCnt; $i++){
            $offset = $already + ($limit * $i);
            $content['query'] = $query . " offset {$offset}";
            $tmp  = $req->send($content);
            $res['records'] = array_merge($res['records'], $tmp['records']);
        }
        
        return $res;
    }
}