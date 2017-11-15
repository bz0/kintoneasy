<?php
require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/config.php");

class postTest extends PHPUnit\Framework\TestCase{
     protected function setUp() {
        $json = bz0\kintoneasy\config::read("post");
        
        bz0\kintoneasy\client::$config = array(
            "subdomain" => $json['subdomain'],
            "token"     => $json['token'],
            "app"       => $json['app']
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

        $client = new bz0\kintoneasy\client();
        $res    = $client->rec('post')->record($content);
        
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

        $client = new bz0\kintoneasy\client();
        $res    = $client->rec('post')->records($content);
        
        $this->assertEquals(array("ids", "revisions"), array_keys($res));
     }
}