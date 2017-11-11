<?php
require_once(__DIR__ . "/../vendor/autoload.php");

class appTest extends PHPUnit\Framework\TestCase{
     private $appId;
     private $app;
     
     protected function setUp() {
        kintoneasy\app::$config = array(
            "subdomain" => "",
            "method"    => "POST",
            "auth"      => ""
        );
        
        $this->app = new kintoneasy\app();
     }
     
     /*
      * @test
      */
     public function testCreate(){
        $content = array("name" => "テストアプリ");
        $res = $this->app->create($content);
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
         
        $res = $this->app->fields($content);
        $this->assertEquals(array("revision"), array_keys($res));
        
        $content = array(
            "apps" => array(
                array(
                    "app" => $appId,
                    "revision" => -1   
                )
            )
        );
        
        $res = $this->app->deploy($content);
        $this->assertEquals("", $res);
     }
}
