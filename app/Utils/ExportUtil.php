<?php declare(strict_types=1);

/**
 * Create by Red.jiang in 8/12/21 at 1:59 PM
 *
 * Email redmadfinger@gmail.com
 */

namespace App\Utils;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportUtil
{
    /**
     * 简单导出
     *
     * @param Spreadsheet $spreadsheet
     * @param string $fileName
     * @param string $suffix
     *
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public static function simpleExport(Spreadsheet $spreadsheet, string $fileName, string $suffix = 'xlsx')
    {
        if (!in_array(strtolower($suffix), ['xlsx', 'xls'])) {
            return;
        }
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8;");
        header("Content-Disposition: inline;filename=\"{$fileName}.$suffix\"");
        header('Cache-Control: max-age=0');

        switch (strtolower($suffix)) {
            case 'xlsx':
                $writer = new Xlsx($spreadsheet);
                break;
            case 'xls':
                $writer = new Xls($spreadsheet);
                break;
//            case 'cvs':
//                $writer = new Csv($spreadsheet);
//                break;
            default:
                $writer = '';
        }

        ob_end_clean();
        $writer->save('php://output');
    }
}

