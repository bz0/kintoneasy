<?php
namespace bz0\kintoneasy\app;

class step {
    public function create($content, $header){
        $file = "preview/app.json";
        $req  = new \bz0\kintoneasy\request($this->config, $file);
        $res  = $req->send($content, $header);
        
        return $res;
    }
    
    public function fields($content){
        $file = "preview/app/form/fields.json";
        $req  = new \bz0\kintoneasy\request($this->config, $file);
        $res  = $req->send($content, $header);
        
        return $res;
    }
    
    public function deploy($content){
        $file = "preview/app/deploy.json";
        $req  = new \bz0\kintoneasy\request($this->config, $file);
        $res  = $req->send($content, $header);
        
        return $res;
    }
}
