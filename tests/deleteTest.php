<?php
require_once(__DIR__ . "/../vendor/autoload.php");

class deleteTest extends PHPUnit\Framework\TestCase{
     protected function setUp() {
        kintoneasy\client::$config = array(
            "subdomain" => "",
            "token"     => "",
            "app"       => 1
        );
     }
     
     /*
      * 正常：1件削除
      */
     public function testDelete_1件削除(){
        $content = array(
            "app" => 1,
            "ids" => array_values(array("1009"))
        );

        $client = new kintoneasy\client();
        $res    = $client->method('delete')->records($content);
        
        print_r($res);
        
        $this->assertEquals(array(), $res);
     }
     
     /*
      * 正常：複数件削除
      */
     public function testDelete_複数件削除(){
        $content = array(
            "app" => 1,
            "ids" => array_values(array("1007","1008"))
        );

        $client = new kintoneasy\client();
        $res    = $client->method('delete')->records($content);
        
        $this->assertEquals(array(), $res);
     }
     
     /*
      * 異常：１件削除
      * 該当のデータなし
      */
     public function testDelete_1件削除_該当データなし(){
        $content = array(
            "app" => 1,
            "ids" => array_values(array("1","2"))
        );

        $client = new kintoneasy\client();
        $res    = $client->method('delete')->records($content);
        
        $this->assertEquals("CB_IL02", $res['code']);
     }
}
