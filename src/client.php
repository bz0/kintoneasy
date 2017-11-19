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
    
    public function app($cmd){
        self::$config['method'] = "POST";
        
        switch(strtoupper($cmd)){
            case 'CREATE':
                $req = new app\create(self::$config);
                break;
            case 'FIELDS':
                $req = new app\fields(self::$config);
                break;
            case 'DEPLOY':
                $req = new app\deploy(self::$config);
                break;
            default:
                throw new \Exception("コマンド名の入力が間違っています");
        }
        
        return $req;
    }
    
    public function file($cmd){
        self::$config['method'] = "POST";
        
        switch(strtoupper($cmd)){
            case 'IMPORT':
                $req = new file\import(self::$config);
                break;
            default:
                throw new \Exception("コマンド名の入力が間違っています");
        }
        
        return $req;
    }
}