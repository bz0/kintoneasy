<?php
namespace bz0\kintoneasy\file;

class convert {
    private $column;
    
    public function __construct($column){
        $this->column = $column;
    }
    
    /*
     * 配列をkintone用のリクエストボディに変換
     * SUBTABLEは非対応
     */
    public function body($data){
        $body = array();
        foreach($data as $i => $line){
            $cnt = 0;
            foreach($this->column as $fieldCode => $type){
                $record[$fieldCode] = $this->column($type, $line, $cnt);
                $cnt++;
            }
            
            $body[] = $record;
        }
        
        return $body;
    }
    
    private function column($type, $line, $cnt){
        $body = array();
        switch($type){
            case 'SINGLE_LINE_TEXT':
            case 'NUMBER':
            case 'CALC':
            case 'MULTI_LINE_TEXT':
            case 'RICH_TEXT':
            case 'RADIO_BUTTON':
            case 'DROP_DOWN':
            case 'LINK':
            case 'DATE':
            case 'TIME':
            case 'DATETIME':
                $body['value'] = $line[$cnt];
                break;
            case 'CHECK_BOX':
            case 'MULTI_SELECT':
                $body['value'] = explode("\n", $line[$cnt]);
                break;
            case 'FILE':
                $filekeys = explode("\n", $line[$cnt]);
                foreach($filekeys as $f => $key){
                   $body['value'][$f]['filekey'] = $key; 
                }
                break;
            case 'USER_SELECT':
            case 'ORGANIZATION_SELECT':
            case 'GROUP_SELECT':
                $codes = explode("\n", $line[$cnt]);
                foreach($codes as $c => $code){
                   $body['value'][$c]['code'] = $code;
                }
                break;
            default:
                throw new Exception("利用できないフィールド型です：{$type}");
        }
        
        return $body;
    }
}
