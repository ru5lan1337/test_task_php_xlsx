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

    public function reader($arr, $numSheet)
    {
        $this->xlsx->setActiveSheetIndex($numSheet);
        $oCells = $this->xlsx->getActiveSheet()->getCellCollection();
        for ($iRow = 1; $iRow <= $oCells->getHighestRow(); $iRow++) {
            $ordCount = 65; //ord('A') = 65
            foreach ($arr as $value) {
                $cell = $oCells->get(chr($ordCount) . $iRow)->getValue();
                if (empty($cell)) {
                    throw new \Exception((chr($ordCount) . $iRow) . ' - empty, sheet - ' . $numSheet);
                } else {
                    $res[$value] = $cell;
                    $ordCount++;
                }
                if($value == end($arr)){
                    yield $res;
                    $res = [];
                }
            }
        }
    }


}