<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Repositories\Admin\NewsletterSubscribeRepository;
use Illuminate\Http\Request;

class NewsletterSubscribeController extends Controller
{
    public function __construct(Request $request, NewsletterSubscribeRepository $newsletterSubscribeRepository)
    {
        $this->modelRepository = $newsletterSubscribeRepository;

        parent::__construct($request);
    }

    public function export()
    {
        $this->checkPermissionShow();

        $subscribeData = $this->modelRepository->query()->orderBy('created_at')->get();

        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

            // 寫入工作表1
            $sheet = $spreadsheet->getSheet(0);
            $sheet->setTitle('電子報訂閱名單');

            // 設定標頭
            $sheet->setCellValue('A1', 'Email');
            $sheet->setCellValue('B1', '訂閱時間');

            // 填入資料
            $rowIndex = 2;
            foreach($subscribeData as $subscribeItem) {
                $sheet->setCellValueExplicit('A' . $rowIndex, $subscribeItem->email, 's');
                $sheet->setCellValueExplicit('B' . $rowIndex, $subscribeItem->created_at, 's');
                $rowIndex++;
            }

            // 寫入檔案並輸出
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

            LogHelper::system('admin', $this->uri, 'export', '', $this->adminData->username, 1, __('admin.form.message.export_success'));

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="export_newsletter_subscribe_' . date('YmdHi') . '.xlsx"');

            $writer->save('php://output');
        } catch (\Exception $e) {
            return redirect(langRoute("admin.{$this->uri}.export"))->withErrors([__('admin.form.message.export_error')]);
        }
    }
}
