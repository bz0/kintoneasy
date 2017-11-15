<?php
namespace bz0\kintoneasy;

class client{
    public static $config;
    
    public function rec($method){
        self::$config['method'] = strtoupper($method);
        
        switch(self::$config['method']){
            case 'GET':
                $req = new record\get(self::$config);
                break;
            case 'POST':
                $req = new record\post(self::$config);
                break;
            case 'PUT':
                $req = new record\put(self::$config);
                break;
            case 'DELETE':
                $req = new record\delete(self::$config);
                break;
            default:
                throw new \Exception("メソッド名の入力が間違っています");
        }
        
        return $req;
    }
}