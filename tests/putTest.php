<?php
require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/config.php");

class putTest extends PHPUnit\Framework\TestCase{
     protected function setUp() {
        $json = bz0\kintoneasy\config::read("put");
        kintoneasy\client::$config = array(
            "subdomain" => $json['subdomain'],
            "token"     => $json['token'],
            "app"       => $json['app']
        );
     }
     
     /*
      * 正常：1件更新
      */
     public function testPut_1件更新(){
        $content = array(
            "id"  => 2000,
            "record" => array(
                "name" => array(
                    "value" => "aaaaaaaaaaaaaaaaa"
                )
            )
        );

        $client = new kintoneasy\client();
        $res    = $client->method('put')->record($content);
        
        print_r($res);
        
        $this->assertEquals(array("revision"), array_keys($res));
     }
     
     /*
      * 正常：複数件更新
      */
     public function testPut_複数件更新(){
        $content = array(
            "records" => array(
                array(
                    "id"  => 2000,
                    "name" => array(
                        "value" => "aaaaaaaaaaaaaaaaa"
                    )
                ),array(
                    "id"  => 1999,
                    "name" => array(
                        "value" => "bbbbbbbbbbbbbbbbb"
                    )
                )
            )
        );

        $client = new kintoneasy\client();
        $res    = $client->method('put')->records($content);
        
        $this->assertEquals(2, count($res['records']));
     }
}
