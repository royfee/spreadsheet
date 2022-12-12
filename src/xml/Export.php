<?php
namespace royfee\spreadsheet\xml;

class Export extends Excelxml{
    private $_xml;
    private $_sheet = [];
    private $_sheetIndex = 0;

    public function newSheet(){
        $this->addSheet();
        return $this;
    }

    public function addRows($data){
        $this->_sheet[$this->_sheetIndex]['data'] = array_merge($this->_sheet[$this->_sheetIndex]['data'],$data);
        return $this;
    }

    public function addRow($row){
        $this->_sheet[$this->_sheetIndex]['data'][] = $row;
        return $this;
    }

    public function addData($data){
        $this->_sheet[$this->_sheetIndex]['data'] = $data;
        return $this;
    }

    public function addSheet($index=0,$title=null,$data = []){
        if(isset($this->_sheet[$index])){
            return;
        }

        $this->_sheet[$index] = [
            'title' =>  $title,
            'data'  =>  $data
        ];

        $this->_sheetIndex = $index;
    }

    public function output($filename){
        $this->createSheet();
        $this->sendWorkbook($filename);
    }

    private function createSheet(){
        foreach($this->_sheet as $index => $sheet){
            $this->addWorksheet($sheet['title'],$sheet['data']);
        }
    }
}