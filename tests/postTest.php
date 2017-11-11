<?php
require_once(__DIR__ . "/../vendor/autoload.php");

class postTest extends PHPUnit\Framework\TestCase{
     protected function setUp() {
        kintoneasy\client::$config = array(
            "subdomain" => "",
            "token"     => "",
            "app"       => 29
        );
     }
     
     /*
      * 正常：1件登録
      */
     public function testPost_1件登録(){
        $content = array(
            "record" => array(
                'no' => array(
                    "value" => 11111
                ),
                'name' => array(
                    "value" => "aaaaaa"
                )
            )
        );

        $client = new kintoneasy\client();
        $res    = $client->method('post')->record($content);
        
        print_r($res);
        
        $this->assertEquals(array("id", "revision"), array_keys($res));
     }
     
     public function testPost_複数登録(){
        $content = array(
            "records" => array(
                array(
                    'no' => array(
                        "value" => 11111
                    ),
                    'name' => array(
                        "value" => "aaaaaa"
                    )
                ),
                array(
                    'no' => array(
                        "value" => 22222
                    ),
                    'name' => array(
                        "value" => "bbbbbb"
                    )
                )
            )
        );

        $client = new kintoneasy\client();
        $res    = $client->method('post')->records($content);
        
        print_r($res);
        
        $this->assertEquals(array("ids", "revisions"), array_keys($res));
     }
}