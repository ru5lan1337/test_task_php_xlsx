<?php


namespace App\Service;


class ExcelReader
{
    private $xlsx;
    private $errorXlsx = false;

    public function __construct($fileXlsx, $countSheetValidator = false)
    {
        $inputFileType = 'Xlsx';
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        if ($reader->canRead($fileXlsx)) {
            $this->xlsx = $reader->load($fileXlsx);
            if ($countSheetValidator && $this->xlsx->getSheetCount() != $countSheetValidator) {
                throw new \Exception('count sheet error.');
            }
        } else {
            throw new \Exception('filetype error.');
        }
    }

    public function getError()
    {
        return $this->errorXlsx;
    }

    public function reader($arr, $numSheet)
    {
        $this->xlsx->setActiveSheetIndex($numSheet);
        $oCells = $this->xlsx->getActiveSheet()->getCellCollection();
        for ($iRow = 1; $iRow <= $oCells->getHighestRow(); $iRow++) {
            $ordCount = 65; //ord('A') = 65
            foreach ($arr as $value) {
                $cell = $oCells->get(chr($ordCount++) . $iRow)->getValue();
                if (empty($cell)) {
                    throw new \Exception((chr($ordCount) . $iRow) . ' - empty, sheet - ' . $numSheet);
                } else {
                    $resultValue[$value] = $cell;
                }
            }
            $result[] = $resultValue;
        }
        return $result;
    }


}