<?php
namespace kintoneasy;

class app {
    const VERSION = 1;
    private $url;
    public static $config;
    
    public function __construct(){
        $this->url    = "https://" . self::$config['subdomain'] . ".cybozu.com/k/v" . self::VERSION . "/";
    }
    
    private function header(){
        $header = array(
            "Host: " . self::$config['subdomain'] . ".cybozu.com:443",
            "X-Cybozu-Authorization: " . self::$config['auth'],
            "Authorization: Basic " . self::$config['auth'],
            "Content-Type: application/json"
        );
        
        return $header;
    }
    
    private function streamContext($header, $body){
        $context = stream_context_create(array(
            "http" => array(
                "method"        => self::$config['method'],
                "ignore_errors" => true,
                "header"        => implode("\r\n", $header),
                "content"       => json_encode($body)
            )
        ));
        
        return $context;
    }
    
    private function request($file, $content){
        $url = "https://" . self::$config['subdomain'] . ".cybozu.com/k/v" . self::VERSION . "/" . $file;
        
        $header  = $this->header();
        $context = $this->streamContext($header, $content);
        $json    = file_get_contents($url, FALSE, $context);

        $res     = $this->jsonConvertArray($json);
        
        return $res;
    }
    
    private function jsonConvertArray($json){
        $res = json_decode($json, true);
        
        return $res;
    }
    
    public function create($content){
        $file = "preview/app.json";
        $res  = $this->request($file, $content);
        
        return $res;
    }
    
    public function fields($content){
        $file = "preview/app/form/fields.json";
        $res  = $this->request($file, $content);
        
        return $res;
    }
    
    public function deploy($content){
        $file = "preview/app/deploy.json";
        $res  = $this->request($file, $content);
        
        return $res;
    }
}
