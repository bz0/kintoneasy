<?php
require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/config.php");

class appTest extends PHPUnit\Framework\TestCase{
     private $appId;
     private $app;
     
     protected function setUp() {
        $json = bz0\kintoneasy\config::read("app");
        
        bz0\kintoneasy\client::$config = array(
            "subdomain" => $json['subdomain'],
            "auth"      => $json['auth']
        );
        
        $this->app = new bz0\kintoneasy\client();
     }
     
     /*
      * @test
      */
     public function testCreate(){
        $content = array("name" => "テストアプリ");
        
        $client = new bz0\kintoneasy\client();
        $res    = $client->app('create')->exec($content);

        $appId = $res['app'];
         
        $this->assertEquals(array("app", "revision"), array_keys($res));
         
        $content = array(
            "app" => $appId,
            "properties" => array(
                "no" => array(
                    "code"   => "no",
                    "label"  => "No",
                    "type"   => "NUMBER"
                ),
                "name" => array(
                    "code"   => "name",
                    "label"  => "名前",
                    "type"   => "SINGLE_LINE_TEXT"
                )
             )
         );
         
        $res = $res    = $client->app('fields')->exec($content);
        $this->assertEquals(array("revision"), array_keys($res));
        
        $content = array(
            "apps" => array(
                array(
                    "app" => $appId,
                    "revision" => -1   
                )
            )
        );
        
        $res = $client->app('deploy')->exec($content);
        
        
     }
}
