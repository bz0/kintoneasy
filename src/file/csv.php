<?php
namespace bz0\kintoneasy\file;

class csv {
    private $column;
    private $client;
    const FILTER_SJIS_CONVERT_UTF8 = 'convert.mbstring.encoding.SJIS-win:UTF-8';
    
    /*
     * @param string $filePath
     * @param array  $column
     */
    public function __construct($config){
        $this->client = new \bz0\kintoneasy\client($config);
    }
    
    /*
     * リクエストボディの作成
     * @param array $csv
     * @param array $column
     */
    public function createBody($csv){
        $convert = new convert($this->column);
        $records = $convert->body($csv);
        
        print_r($records);
        
        $res = array(
          'records' => $records  
        );
        
        return $res;
    }
    
    /*
     * 指定したカラム数とCSVの項目数が同じかチェック
     * @param array $line  １行分の配列
     * @param int   $count 現在の行数
     */
    private function columnCountCheck($line, $count){
        $columnCount = count($line);
        $csvCount = count($this->column);
        if ($columnCount!=$csvCount){
            throw new Exception("指定した項目数とCSVの項目数が異なります。 {$count}行目　指定した項目数：{$columnCount} / CSV項目数：{$csvCount}");
        }
    }
    
    /*
     * ストリームの登録
     * $param $fp
     */
    private function stream($fp){
        $ret = stream_filter_register("convert.mbstring.*", "\Stream_Filter_Mbstring");
        $filter = stream_filter_append($fp, FILTER_SJIS_CONVERT_UTF8, STREAM_FILTER_READ);
        
        return $fp;
    }
    
    /*
     * kintoneAPIでレコード登録
     * @param array $csv
     */
    private function apiPost($csv){
        $content = $this->createBody($csv);
        $res = $this->client->rec('post')->records($content);
        if (isset($res['code'])){
            throw new Exception("POSTに失敗しました:{$res['message']}");
        }
        
        return $res;
    }
    
    /*
     * ロケールの変更
     */
    private function localeChange(){
        $current_locale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'ja_JP.UTF-8');
        
        return $current_locale;
    }
    
    /*
     * 100件ごとにkintoneAPIでレコード登録を行う
     * @param string $filePath
     * @param array  $column
     */
    public function exec($filePath, $column, $encode){
        if (!file_exists($filePath)){
            throw new Exception("ファイルが存在しません");
        }
        
        $fp = fopen($filePath, 'r');
        $this->column = $column;
        
        if ($encode=="UTF-8"){
            $fp = $this->stream($fp);
        }
        
        $current_locale = $this->localeChange();
        $csv = array();
        $count = 1;
        
        while ($line = fgetcsv($fp, 10000)){
            $this->columnCountCheck($line, $count);
            $csv[] = $line;
            
            if (count($csv)==100){
                $res = $this->apiPost($csv);
                $csv = array();
            }

            $count++;
        }
        
        if (!empty($csv)){
            $res = $this->apiPost($csv);
        }
        setlocale(LC_ALL, $current_locale);
        fclose($fp);
        
        return $res;
    }
}
