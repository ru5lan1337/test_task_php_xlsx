<?php


namespace App\Service;


class ExcelReader
{
    private $xlsx;

    public function __construct($fileXlsx, $countSheetValidator = false)
    {
        $inputFileType = 'Xlsx';
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        if ($reader->canRead($fileXlsx)) {
            $this->xlsx = $reader->load($fileXlsx);
            if ($countSheetValidator && $this->xlsx->getSheetCount() != count($countSheetValidator)) {
                throw new \Exception('count sheet error.');
            }
            $nameSheets = $this->xlsx->getSheetNames();
            if ($countSheetValidator && $nameSheets != $countSheetValidator) {
                throw new \Exception('Naming sheet error.');
            }
        } else {
            throw new \Exception('filetype error.');
        }
    }

    public function read($model)
    {
        $numSheet = $model::getExcelNumSheet();
        $arr = $model::getExcelNaming();
        $this->xlsx->setActiveSheetIndex($numSheet);
        $oCells = $this->xlsx->getActiveSheet()->getCellCollection();
        for ($iRow = 1; $iRow <= $oCells->getHighestRow(); $iRow++) {
            $ordCount = 65; //ord('A') = 65
            foreach ($arr as $value) {
                $cell = $oCells->get(chr($ordCount) . $iRow);
                if (is_null($cell)) {
                    throw new \Exception((chr($ordCount) . $iRow) . ' - empty, sheet - ' . $numSheet);
                } else {
                    $cell = $cell->getValue();
                    $res[$value] = $cell;
                    $ordCount++;
                }
                if($value == end($arr)){
                    $obj = new $model();
                    foreach ($arr as $prop){
                        $obj[$prop] = $res[$prop];
                    }
                    yield $obj;
                    $res = [];
                }
            }
        }
    }


}
