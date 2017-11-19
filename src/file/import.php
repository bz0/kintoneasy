<?php
namespace bz0\kintoneasy\file;

class import {
    private $config;
    
    public function __construct($config){
        $this->config = $config;
    }
    
    public function csv($filePath, $column, $encode){
        $file = new csv($this->config);
        $res  = $file->exec($filePath, $column, $encode);
        
        return $res;
    }
}
