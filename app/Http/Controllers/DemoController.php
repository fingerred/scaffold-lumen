<?php declare(strict_types=1);

/**
 * Create by Red.jiang in 10/15/21 at 4:49 PM
 *
 * Email redmadfinger@gmail.com
 */

namespace App\Http\Controllers;

use App\Functions\ErrorCode\CommonErrorCode;
use App\Utils\ExportUtil;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DemoController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnSuccess()
    {
        return successWithData();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function returnError()
    {
        return errorWithData(CommonErrorCode::$errorCode);
    }

    /**
     * 导出excel
     *
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', '商品编号');
        $sheet->setCellValue('B1', '商品名称');
        $sheet->setCellValue('C1', '商品售价');
        $sheet->setCellValue('D1', '销量');

        # way 1
//        $data = [[
//            "abcdefg",
//            "小花猫",
//            "99.99",
//            "666"
//        ]];
//
//        $source = $data;

        # way 2
        $data = [[
            'code' => "abcdefg",
            'name' => "小花猫",
            'sale_price' => "99.99",
            'sale_num' => "666"
        ]];

        $source = [];
        if ($data) {
            foreach ($data as $k =>$v) {
                $source[$k] = [
                    $v['code'],
                    $v['name'],
                    $v['sale_price'],
                    $v['sale_num'],
                ];
            }
        }

        $sheet->fromArray($source, null, 'A2');

        ExportUtil::simpleExport($spreadsheet, date('Y-m-d H:i:s') . '列表', 'xls');
    }
}
