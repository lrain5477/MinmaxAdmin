<?php

namespace Minmax\Product\Io;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Minmax\Base\Helpers\Seeder as SeederHelper;
use Minmax\Io\Abstracts\IoController;
use Minmax\Io\Admin\IoConstructRepository;
use Minmax\Io\Models\IoRecord;
use Minmax\Product\Admin\ProductPackageRepository;
use Minmax\World\Admin\WorldCurrencyRepository;

/**
 * Class ProductPackageController
 */
class ProductPackageController extends IoController
{
    protected $packagePrefix = 'MinmaxProduct::';

    public function example($id)
    {
        $ioData = (new IoConstructRepository)->find($id) ?? abort(404);

        $filename = ($ioData->filename ?? $ioData->title) . ' (Sample)';

        $currenciesSet = (new WorldCurrencyRepository)->getSelectParameters('active', true);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Use sheet 0
        $sheet = $spreadsheet->getSheet(0);
        $sheet->setTitle('import');

        $titleColumnIndex = 0;
        $titleRowIndex = 1;
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.set_sku') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.item_sku') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.amount') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.limit'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.description'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(25);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.price_advice') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.price_sell') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.start_at'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(17);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.end_at'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(17);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.sort'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.active') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);

        $dataColumnIndex = 0;
        $dataRowIndex = 2;
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'DEMO001', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'DEMO001', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '1', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'This is a demo package', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'TWD:699', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'TWD:350', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, date('Y-m-d H:i:s'), 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '1', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '1', 's');

        // Set sheet style
        $this->setSheetStyle($sheet, [1, 1, $dataColumnIndex, $dataRowIndex]);
        $this->setSheetStyle($sheet, [1, 1, $titleColumnIndex, $titleRowIndex], [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFEFEF']]
        ]);

        // Use sheet 1
        $sheet = $spreadsheet->createSheet(1);
        $sheet->setTitle(__("MinmaxProduct::{$this->guard}.form.ProductPackage.currency"));

        $titleColumnIndex = 0;
        $titleRowIndex = 1;
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxWorld::models.WorldCurrency.code'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(20);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __("MinmaxProduct::{$this->guard}.form.ProductItem.currency"), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(50);

        $dataColumnIndex = 0;
        $dataRowIndex = 1;
        foreach ($currenciesSet as $currencyCode => $currencyData) {
            $dataColumnIndex = 0;
            $dataRowIndex++;
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $currencyCode, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, array_get($currencyData, 'title', ''), 's');
        }

        // Set sheet style
        $this->setSheetStyle($sheet, [1, 1, $dataColumnIndex, $dataRowIndex]);
        $this->setSheetStyle($sheet, [1, 1, $titleColumnIndex, $titleRowIndex], [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFEFEF']]
        ]);

        $spreadsheet->setActiveSheetIndex(0);

        // 寫入檔案並輸出
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $response = response()->streamDownload(
            function () use ($writer) { $writer->save('php://output'); },
            "{$filename}.xlsx",
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'Cache-Control' => 'max-age=0']
        );

        return $response;
    }

    public function import(Request $request, $id)
    {
        $ioData = (new IoConstructRepository)->find($id) ?? abort(404);

        $fileField = 'ProductPackage.file';

        $sheetData = $this->getSheetFromFile($request, $fileField, 'import', 1);

        if (is_null($sheetData)) {
            return redirect(langRoute("{$this->guard}.{$this->ioUri}.config", ['id' => $id]))
                ->withErrors([__("MinmaxIo::{$this->guard}.form.message.import_error", ['title' => $ioData->title])]);
        }

        // Insert data
        $timestamp = date('Y-m-d H:i:s');
        $setSkuPool = DB::table('product_set')->pluck('sku')->toArray();
        $itemSkuPool = DB::table('product_item')->pluck('sku')->toArray();
        $packageSkuPool = DB::table('product_package')->pluck('set_sku')->toArray();
        $rowId = $rowStartId = array_get(DB::select("show table status like 'product_package'"), '0.Auto_increment', 1);
        $rowId--;
        $insertData = [];
        $updateSkuSet = [];
        $insertLanguage = [];
        $languageResourceData = [];
        $errorRecord = [];
        foreach ($sheetData as $rowIndex => $rowData) {
            $errorCounter = 0;

            if (empty($rowData[0] ?? '')) {
                $errorRecord[] = ['row' => $rowIndex, 'message' => __('validation.required', ['attribute' => __('MinmaxProduct::models.ProductPackage.set_sku')])];
                $errorCounter++;
            }

            if (! in_array($rowData[0] ?? '', $setSkuPool)) {
                $errorRecord[] = ['row' => $rowIndex, 'message' => __('validation.exists', ['attribute' => __('MinmaxProduct::models.ProductPackage.set_sku')])];
                $errorCounter++;
            }

            if (empty($rowData[1] ?? '')) {
                $errorRecord[] = ['row' => $rowIndex, 'message' => __('validation.required', ['attribute' => __('MinmaxProduct::models.ProductPackage.item_sku')])];
                $errorCounter++;
            }

            if (! in_array($rowData[1] ?? '', $itemSkuPool)) {
                $errorRecord[] = ['row' => $rowIndex, 'message' => __('validation.exists', ['attribute' => __('MinmaxProduct::models.ProductPackage.item_sku')])];
                $errorCounter++;
            }

            if (empty($rowData[2] ?? '')) {
                $errorRecord[] = ['row' => $rowIndex, 'message' => __('validation.required', ['attribute' => __('MinmaxProduct::models.ProductPackage.amount')])];
                $errorCounter++;
            }

            if ($errorCounter > 0) continue;

            if (intval($request->input('ProductPackage.override', 0)) == 1 && in_array($rowData[0], $packageSkuPool)) {
                if (! in_array($rowData[0], $updateSkuSet)) {
                    $updateSkuSet = $rowData[0];
                }
            }

            $insertData[] = [
                'set_sku' => $rowData[0],
                'item_sku' => $rowData[1],
                'amount' => intval($rowData[2] ?? 1),
                'limit' => intval($rowData[3] ?? 0),
                'description' => 'product_package.description.' . ++$rowId,
                'price_advice' => collect(explode(',', $rowData[5] ?? ''))->mapWithKeys(function ($item) { $set = explode(':', $item); return [$set[0] => $set[1]]; })->toJson(),
                'price_sell' => collect(explode(',', $rowData[6] ?? ''))->mapWithKeys(function ($item) { $set = explode(':', $item); return [$set[0] => $set[1]]; })->toJson(),
                'start_at' => isset($rowData[7]) ? $rowData[7] : $timestamp,
                'end_at' => $rowData[8] ?? null,
                'sort' => isset($rowData[9]) ? intval($rowData[9]) : 1,
                'active' => boolval($rowData[10] ?? 0),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
            $insertLanguage[] = ['description' => $rowData[4] ?? null];
        }

        try {
            DB::beginTransaction();

            if (count($insertData) < 1) throw new \Exception;

            if (count($updateSkuSet) > 0) {
                $packageRepository = new ProductPackageRepository();
                foreach ($updateSkuSet as $removeSku) {
                    foreach ($packageRepository->all('set_sku', $removeSku) as $removeModel) {
                        $packageRepository->delete($removeModel);
                    }
                }
            }

            DB::table('product_package')->insert($insertData);

            $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('product_package', $insertLanguage, 1, $rowStartId));
            $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('product_package', $insertLanguage, 2, $rowStartId));
            $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('product_package', $insertLanguage, 3, $rowStartId));
            $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('product_package', $insertLanguage, 4, $rowStartId));

            DB::table('language_resource')->insert($languageResourceData);

            DB::commit();

            // Import record
            IoRecord::create([
                'title' => $ioData->title,
                'uri' => $ioData->uri,
                'type' => 'import',
                'errors' => $errorRecord,
                'total' => count($sheetData),
                'success' => count($sheetData) - count($errorRecord),
                'result' => true,
                'file' => $request->file($fileField)->getClientOriginalName(),
            ]);

            return redirect(langRoute("{$this->guard}.{$this->ioUri}.config", ['id' => $id]))->with('success', __("MinmaxIo::{$this->guard}.form.message.import_success", ['title' => $ioData->title]));
        } catch (\Exception $e) {
            DB::rollBack();

            // Import record
            IoRecord::create([
                'title' => $ioData->title,
                'uri' => $ioData->uri,
                'type' => 'import',
                'errors' => $errorRecord,
                'total' => count($sheetData),
                'success' => 0,
                'result' => false,
                'file' => $request->file($fileField)->getClientOriginalName(),
            ]);

            throw new \Exception;
        }
    }

    public function export(Request $request, $id)
    {
        $ioData = (new IoConstructRepository)->find($id) ?? abort(404);

        $packageData = (new ProductPackageRepository)->query()
            ->where(function ($query) use ($request) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                if ($setSku = $request->input('ProductPackage.set_sku')) {
                    $query->where('set_sku', '=', $setSku);
                }
                if ($itemSku = $request->input('ProductPackage.item_sku')) {
                    $query->where('item_sku', '=', $itemSku);
                }
                if ($createdAtStart = $request->input('ProductPackage.created_at.start')) {
                    $query->where('created_at', '>=', "{$createdAtStart} 00:00:00");
                }
                if ($createdAtEnd = $request->input('ProductPackage.created_at.end')) {
                    $query->where('created_at', '<=', "{$createdAtEnd} 23:59:59");
                }
                if ($updatedAtStart = $request->input('ProductPackage.updated_at.start')) {
                    $query->where('updated_at', '>=', "{$updatedAtStart} 00:00:00");
                }
                if ($updatedAtEnd = $request->input('ProductPackage.updated_at.end')) {
                    $query->where('updated_at', '<=', "{$updatedAtEnd} 23:59:59");
                }
                if (! is_null($active = $request->input('ProductPackage.active'))) {
                    $query->where('active', boolval($active));
                }
            })
            ->orderBy('set_sku')
            ->orderBy('sort')
            ->get();

        $filename = ($ioData->filename ?? $ioData->title) . ' (' . date('YmdHis') . ')';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Use sheet 0
        $sheet = $spreadsheet->getSheet(0);
        $sheet->setTitle('import');

        $titleColumnIndex = 0;
        $titleRowIndex = 1;
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.set_sku') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.item_sku') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.amount') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.limit'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.description'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(25);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.price_advice') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.price_sell') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.start_at'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(17);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.end_at'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(17);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.sort'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductPackage.active') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);

        $dataColumnIndex = 0;
        $dataRowIndex = 1;
        foreach ($packageData as $rowData) {
            /** @var \Minmax\Product\Models\ProductPackage $rowData */
            $dataRowIndex++;
            $dataColumnIndex = 0;
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->set_sku, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->item_sku, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->amount, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->getAttribute('limit'), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->description, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, collect($rowData->price_advice)->map(function ($item, $key) { return "{$key}:{$item}"; })->implode(','), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, collect($rowData->price_sell)->map(function ($item, $key) { return "{$key}:{$item}"; })->implode(','), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->start_at->format('Y-m-d H:i:s'), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->end_at->format('Y-m-d H:i:s'), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->sort, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, intval($rowData->active), 's');
        }

        // Set sheet style
        $this->setSheetStyle($sheet, [1, 1, $dataColumnIndex < 1 ? $titleColumnIndex : $dataColumnIndex, $dataRowIndex]);
        $this->setSheetStyle($sheet, [1, 1, $titleColumnIndex, $titleRowIndex], [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFEFEF']]
        ]);

        // 寫入檔案並輸出
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $response = response()->streamDownload(
            function () use ($writer) { $writer->save('php://output'); },
            "{$filename}.xlsx",
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'Cache-Control' => 'max-age=0', 'refresh' => '2; url=' . url('')]
        );

        // Export record
        IoRecord::create([
            'title' => $ioData->title,
            'uri' => $ioData->uri,
            'type' => 'export',
            'errors' => [],
            'total' => $packageData->count(),
            'success' => $packageData->count(),
            'result' => true,
            'file' => "{$filename}.xlsx",
        ]);

        session()->flash('success', __("MinmaxIo::{$this->guard}.form.message.export_success", ['title' => $ioData->title]));

        return $response;
    }
}
