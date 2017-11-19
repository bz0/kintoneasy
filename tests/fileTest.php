<?php
require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/config.php");

class postTest extends PHPUnit\Framework\TestCase{
     protected function setUp() {
        $json = bz0\kintoneasy\config::read("file");
        
        bz0\kintoneasy\client::$config = array(
            "subdomain" => $json['subdomain'],
            "token"     => $json['token'],
            "app"       => $json['app']
        );
     }
     
     /*
      * 正常：1件登録
      */
     public function testCsv(){
        $filePath = dirname(__FILE__) . "/file/test.csv";
        
        $column = array(
            'no'   => 'NUMBER',
            'name' => 'SINGLE_LINE_TEXT'
        );

        $encode = "SJIS";
        $client = new bz0\kintoneasy\client();
        $res    = $client->file('import')->csv($filePath, $column, $encode);
        
        $this->assertEquals(array("ids", "revisions"), array_keys($res));
     }
}