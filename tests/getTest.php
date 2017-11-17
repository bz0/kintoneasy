<?php
require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/config.php");

class getTest extends PHPUnit\Framework\TestCase{
     protected function setUp() {
        $json = bz0\kintoneasy\config::read("get");
        bz0\kintoneasy\client::$config = array(
            "subdomain" => $json['subdomain'],
            "token"     => $json['token'],
            "app"       => $json['app']
        );
     }
     
     /*
      * 異常：存在しないメソッド名を入力
      */
     public function testGet_異常_存在しないメソッド名(){
        try{
            $content = array(
                "app" => 1,
                "id"  => 1003
            );

            $client = new bz0\kintoneasy\client();
            $res    = $client->rec('aaa')->record($content);
        }catch(\Exception $e){
            $msg = $e->getMessage();
        }
        
        $this->assertEquals("メソッド名の入力が間違っています", $msg);
     }
     
     /*
      * 正常：1件取得
      */
     public function testGet_1件取得(){
        $content = array(
            "id"  => 1999
        );

        $client = new bz0\kintoneasy\client();
        $res    = $client->rec('get')->record($content);
        
        $this->assertEquals("1999", $res['record']['$id']['value']);
     }
     
     /*
      * 正常：1件取得 該当データなし
      */
     public function testGet_1件取得_該当データなし(){
        $content = array(
            "id"  => 10000
        );

        $client = new bz0\kintoneasy\client();
        $res    = $client->rec('get')->record($content);
        
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

        $client = new bz0\kintoneasy\client();
        $res    = $client->rec('get')->records($content);
        
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

        $client = new bz0\kintoneasy\client();
        $res    = $client->rec('get')->records($content);
        
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

        $client = new bz0\kintoneasy\client();
        $res    = $client->rec('get')->records($content);
        
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

        $client = new bz0\kintoneasy\client();
        $res    = $client->rec('get')->records($content);
        
        $this->assertEquals("GAIA_IQ03", $res['code']);
     }
     
     public function testFetchAll_複数回リクエスト(){
        $content = array(
            "query" => "no >= 760 order by no asc",
            "totalCount" => true
        );
        
         $client = new bz0\kintoneasy\client();
         $res    = $client->rec('get')->fetchAll($content);
         
         $this->assertEquals($res['totalCount'], count($res['records']));
     }
     
     public function testFetchAll_1回リクエスト(){
        $content = array(
            "query" => "no >= 970 order by no asc",
            "totalCount" => true
        );
        
        $client = new bz0\kintoneasy\client();
        $res    = $client->rec('get')->fetchAll($content);
         
        $this->assertEquals($res['totalCount'], count($res['records']));
     }
}
