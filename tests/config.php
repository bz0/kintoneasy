<?php
namespace bz0\kintoneasy;

class config {
    public static function read($name){
        $filepath = realpath(dirname(__FILE__) . "/fixtures/{$name}.json");
        if (!file_exists($filepath)){
            return array();
        }
        
        $content = file_get_contents($filepath);
        return json_decode($content, true);
    }
}
