<?php
namespace kintoneasy;

class client{
    public static $config;
    
    public function method($method){
        self::$config['method'] = strtoupper($method);
        
        switch(self::$config['method']){
            case 'GET':
                $req = new method\get(self::$config);
                break;
            case 'POST':
                $req = new method\post(self::$config);
                break;
            case 'PUT':
                $req = new method\put(self::$config);
                break;
            case 'DELETE':
                $req = new method\delete(self::$config);
                break;
            default:
                break;
        }
        
        return $req;
    }
}