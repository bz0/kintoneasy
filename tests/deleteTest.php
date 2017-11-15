<?php
require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/config.php");

class deleteTest extends PHPUnit\Framework\TestCase{
     protected function setUp() {
        $json = bz0\kintoneasy\config::read("delete");
        bz0\kintoneasy\client::$config = array(
            "subdomain" => $json['subdomain'],
            "token"     => $json['token'],
            "app"       => $json['app']
        );
     }
     
     /*
      * 正常：1件削除
      */
     public function testDelete_1件削除(){
        $content = array(
            "ids" => array_values(array("1017"))
        );

        $client = new bz0\kintoneasy\client();
        $res    = $client->rec('delete')->records($content);
        
        $this->assertEquals(array(), $res);
     }
     
     /*
      * 正常：複数件削除
      */
     public function testDelete_複数件削除(){
        $content = array(
            "ids" => array_values(array("1015","1016"))
        );

        $client = new bz0\kintoneasy\client();
        $res    = $client->rec('delete')->records($content);
        
        $this->assertEquals(array(), $res);
     }
     
     /*
      * 異常：１件削除
      * 該当のデータなし
      */
     public function testDelete_1件削除_該当データなし(){
        $content = array(
            "ids" => array_values(array("1","2"))
        );

        $client = new bz0\kintoneasy\client();
        $res    = $client->rec('delete')->records($content);
        
        $this->assertEquals("CB_IL02", $res['code']);
     }
}
