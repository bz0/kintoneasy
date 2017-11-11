<?php
require_once(__DIR__ . "/../vendor/autoload.php");

class getTest extends PHPUnit\Framework\TestCase{
     protected function setUp() {
        kintoneasy\client::$config = array(
            "subdomain" => "",
            "token"     => "",
            "app"       => 1
        );
     }
     
     /*
      * 正常：1件取得
      */
     public function testGet_1件取得(){
        $content = array(
            "app" => 1,
            "id"  => 1003
        );

        $client = new kintoneasy\client();
        $res    = $client->method('get')->record($content);
        
        $this->assertEquals("Daron Harvey", $res['record']['name']['value']);
     }
     
     /*
      * 正常：1件取得 該当データなし
      */
     public function testGet_1件取得_該当データなし(){
        $content = array(
            "app" => 1,
            "id"  => 10000
        );

        $client = new kintoneasy\client();
        $res    = $client->method('get')->record($content);
        
        $this->assertEquals("GAIA_RE01", $res['code']);
     }
     
     /*
      * 正常：一括取得
      * クエリなしGETリクエスト 100件取得
      */
     public function testGet_一括取得_クエリなし(){
        $content = array(
            "query" => ""
        );

        $client = new kintoneasy\client();
        $res    = $client->method('get')->records($content);
        
        $this->assertEquals(100, count($res['records']));
     }
     
     /*
      * 正常：一括取得
      * 条件指定 + order by　50件取得
      */
     public function testGet_一括取得_クエリあり(){
        $content = array(
            "query" => "no >= 950 order by no asc",
            "totalCount" => true
        );

        $client = new kintoneasy\client();
        $res    = $client->method('get')->records($content);
        
        $this->assertEquals(50, count($res['records']));
     }
     
     /*
      * 正常：一括取得
      * 条件指定 + フィールド指定
      */
     public function testGet_一括取得_フィールド指定(){
        $content = array(
            "query" => "no >= 950 order by no asc",
            "fields" => array("name"),
            "totalCount" => true
        );

        $client = new kintoneasy\client();
        $res    = $client->method('get')->records($content);
        
        foreach($res['records'] as $i => $val){
            $this->assertEquals(array("name"), array_keys($val));
        }
     }
     
     /*
      * 異常：一括取得
      * 無効なクエリを発行したとき
      */
     public function testGetError_一括取得_クエリあり(){
        $content = array(
            "query" => "name >= 950 order by no asc",
            "totalCount" => true
        );

        $client = new kintoneasy\client();
        $res    = $client->method('get')->records($content);
        
        $this->assertEquals("GAIA_IQ03", $res['code']);
     }
}
