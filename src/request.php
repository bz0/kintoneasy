<?php
namespace bz0\kintoneasy;

class request{
    const VERSION = 1;
    private $url;
    private $config;
    
    public function __construct($config, $file){
        $this->config = $config;
        $this->url    = "https://{$this->config['subdomain']}.cybozu.com/k/v" . self::VERSION . "/" . $file;
    }
    
    private function header(){
        $header   = array();
        $header[] = "Content-Type: application/json";
        
        if (isset($this->config['subdomain'])){
            $header[] = "Host: {$this->config['subdomain']}.cybozu.com:443";
        }
        
        if (isset($this->config['token'])){
            $header[] = "X-Cybozu-API-Token: {$this->config['token']}";
        }
        
        if (isset($this->config['auth'])){
            $header[] = "X-Cybozu-Authorization: " . $this->config['auth'];
            $header[] = "Authorization: Basic " . $this->config['auth'];
        }
        
        if (isset($this->config['method'])){
            $header[] = "X-HTTP-Method-Override: {$this->config['method']}";
        }
        
        return $header;
    }
    
    private function body($content){
        $body = array();
        if (isset($this->config['app'])){
            $body["app"] = $this->config['app'];
        }
        
        if (!empty($content)){
            $body = array_merge($body, $content);
        }
        
        return $body;
    }
    
    private function jsonConvertArray($json){
        $res = json_decode($json, true);
        
        return $res;
    }
    
    public function streamContext($header, $body){
        $context = stream_context_create(array(
            "http" => array(
                "method"        => $this->config['method'],
                "ignore_errors" => true,
                "header"        => implode("\r\n", $header),
                "content"       => json_encode($body),
            )
        ));
        
        return $context;
    }
    
    public function send($content){
        $header  = $this->header();
        $body    = $this->body($content);
        $context = $this->streamContext($header, $body);

        $json = file_get_contents($this->url, FALSE, $context);
        $res  = $this->jsonConvertArray($json);
        
        return $res;
    }
}
