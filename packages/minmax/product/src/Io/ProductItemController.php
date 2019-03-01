<?php

namespace Minmax\Product\Io;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Minmax\Base\Helpers\Seeder as SeederHelper;
use Minmax\Io\Abstracts\IoController;
use Minmax\Io\Admin\IoConstructRepository;
use Minmax\Io\Models\IoRecord;
use Minmax\Product\Admin\ProductItemRepository;
use Minmax\World\Admin\WorldCurrencyRepository;

/**
 * Class ProductItemController
 */
class ProductItemController extends IoController
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
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.sku') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.serial'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.title') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(20);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.pic'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(20);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.details.description'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(25);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.details.editor'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(25);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.cost'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.price'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.qty_enable') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.qty_safety'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.qty'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.active') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);

        $dataColumnIndex = 0;
        $dataRowIndex = 2;
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'DEMO001', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'demo-001', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'This is a demo product', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'images/4K_486863608.jpg', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'Some words here', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '<p>Any html code here</p>', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'TWD:200', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'TWD:300', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '1', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '5', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '50', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '1', 's');

        // Set sheet style
        $this->setSheetStyle($sheet, [1, 1, $dataColumnIndex, $dataRowIndex]);
        $this->setSheetStyle($sheet, [1, 1, $titleColumnIndex, $titleRowIndex], [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFEFEF']]
        ]);

        // Use sheet 1
        $sheet = $spreadsheet->createSheet(1);
        $sheet->setTitle(__("MinmaxProduct::{$this->guard}.form.ProductItem.currency"));

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

        $fileField = 'ProductItem.file';

        $sheetData = $this->getSheetFromFile($request, $fileField, 'import', 1);

        if (is_null($sheetData)) {
            return redirect(langRoute("{$this->guard}.{$this->ioUri}.config", ['id' => $id]))
                ->withErrors([__("MinmaxIo::{$this->guard}.form.message.import_error", ['title' => $ioData->title])]);
        }

        // Insert data
        $timestamp = date('Y-m-d H:i:s');
        $skuPool = DB::table('product_item')->pluck('sku')->toArray();
        $insertData = [];
        $insertLanguage = [];
        $insertQty = [];
        $updateData = [];
        $updateQty = [];
        $languageResourceData = [];
        $errorRecord = [];
        foreach ($sheetData as $rowIndex => $rowData) {
            $duplicate = false;
            $errorCounter = 0;

            if (empty($rowData[0] ?? '')) {
                $errorRecord[] = ['row' => $rowIndex, 'message' => __('validation.required', ['attribute' => __('MinmaxProduct::models.ProductItem.sku')])];
                $errorCounter++;
            }

            if (in_array($rowData[0] ?? '', $skuPool) || collect($insertData)->where('sku', $rowData[0] ?? '')->count() > 0) {
                if (intval($request->input('ProductItem.override', 0)) == 1 && ! array_key_exists($rowData[0], $updateData)) {
                    $duplicate = true;
                } else {
                    $errorRecord[] = ['row' => $rowIndex, 'message' => __('validation.unique', ['attribute' => __('MinmaxProduct::models.ProductItem.sku')])];
                    $errorCounter++;
                }
            }

            if (empty($rowData[2] ?? '')) {
                $errorRecord[] = ['row' => $rowIndex, 'message' => __('validation.required', ['attribute' => __('MinmaxProduct::models.ProductItem.title')])];
                $errorCounter++;
            }

            if ($errorCounter > 0) continue;

            if ($duplicate) {
                $updateData[$rowData[0]] = [
                    'serial' => $rowData[1],
                    'title' => $rowData[2],
                    'pic' => collect(explode(',', $rowData[3] ?? ''))->map(function ($item) { return ['path' => '/files/' . $item]; })->toArray(),
                    'details' => ['description' => $rowData[4], 'editor' => $rowData[5]],
                    'cost' => collect(explode(',', $rowData[6] ?? ''))->mapWithKeys(function ($item) { $set = explode(':', $item); return [$set[0] => $set[1]]; })->toArray(),
                    'price' => collect(explode(',', $rowData[7] ?? ''))->mapWithKeys(function ($item) { $set = explode(':', $item); return [$set[0] => $set[1]]; })->toArray(),
                    'qty_enable' => boolval($rowData[8] ?? 0),
                    'qty_safety' => intval($rowData[9] ?? 0),
                    'active' => boolval($rowData[11] ?? 0),
                ];

                if (boolval($rowData[8] ?? 0)) {
                    $updateQty[$rowData[0]] = [
                        'amount' => intval($rowData[10] ?? 0),
                        'remark' => __("MinmaxProduct::{$this->guard}.form.ProductItem.messages.manual_update_qty"),
                        'summary' => intval($rowData[10] ?? 0),
                    ];
                }
            } else {
                $insertData[] = [
                    'id' => $rowId = uuidl(),
                    'sku' => $rowData[0],
                    'serial' => $rowData[1],
                    'title' => 'product_item.title.' . $rowId,
                    'pic' => collect(explode(',', $rowData[3] ?? ''))->map(function ($item) { return ['path' => '/files/' . $item]; })->toJson(),
                    'details' => 'product_item.details.' . $rowId,
                    'cost' => collect(explode(',', $rowData[6] ?? ''))->mapWithKeys(function ($item) { $set = explode(':', $item); return [$set[0] => $set[1]]; })->toJson(),
                    'price' => collect(explode(',', $rowData[7] ?? ''))->mapWithKeys(function ($item) { $set = explode(':', $item); return [$set[0] => $set[1]]; })->toJson(),
                    'qty_enable' => boolval($rowData[8] ?? 0),
                    'qty_safety' => intval($rowData[9] ?? 0),
                    'active' => boolval($rowData[11] ?? 0),
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
                $insertLanguage[] = ['id' => $rowId, 'title' => $rowData[2], 'details' => json_encode(['description' => $rowData[4], 'editor' => $rowData[5]])];

                if (boolval($rowData[8] ?? 0)) {
                    $insertQty[] = [
                        'item_id' => $rowId,
                        'amount' => intval($rowData[10] ?? 0),
                        'remark' => __("MinmaxProduct::{$this->guard}.form.ProductItem.messages.manual_update_qty"),
                        'summary' => intval($rowData[10] ?? 0),
                    ];
                }
            }
        }

        try {
            DB::beginTransaction();

            if (count($insertData) < 1 && count($updateData) < 1) throw new \Exception;

            DB::table('product_item')->insert($insertData);

            DB::table('product_quantity')->insert($insertQty);

            $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('product_item', $insertLanguage, 1));
            $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('product_item', $insertLanguage, 2));
            $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('product_item', $insertLanguage, 3));
            $languageResourceData = array_merge($languageResourceData, SeederHelper::getLanguageResourceArray('product_item', $insertLanguage, 4));

            DB::table('language_resource')->insert($languageResourceData);

            if (count($updateData) > 0) {
                $repository = new ProductItemRepository();
                foreach ($updateData as $updateSku => $updateAttribute) {
                    if ($productData = $repository->one('sku', $updateSku)) {
                        $model = $repository->save($productData, $updateAttribute);
                        if ($model && array_key_exists($updateSku, $updateQty)) {
                            $qtyData = array_get($updateQty, $updateSku);
                            if (intval($qtyData['amount']) != $model->qty) {
                                $qtyData['amount'] = $qtyData['amount'] - $model->qty;
                                $model->productQuantities()->create($qtyData);
                            }
                        }
                    }
                }
            }

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

        $itemQuery = (new ProductItemRepository)->query()
            ->with(['productQuantities'])
            ->where(function ($query) use ($request) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                if ($createdAtStart = $request->input('ProductItem.created_at.start')) {
                    $query->where('created_at', '>=', "{$createdAtStart} 00:00:00");
                }
                if ($createdAtEnd = $request->input('ProductItem.created_at.end')) {
                    $query->where('created_at', '<=', "{$createdAtEnd} 23:59:59");
                }
                if ($updatedAtStart = $request->input('ProductItem.updated_at.start')) {
                    $query->where('updated_at', '>=', "{$updatedAtStart} 00:00:00");
                }
                if ($updatedAtEnd = $request->input('ProductItem.updated_at.end')) {
                    $query->where('updated_at', '<=', "{$updatedAtEnd} 23:59:59");
                }
                if (! is_null($active = $request->input('ProductItem.active'))) {
                    $query->where('active', boolval($active));
                }
            });

        if ($sortBy = $request->input('ProductItem.sort')) {
            $itemQuery->orderBy($sortBy, $request->input('ProductItem.arrange', 'asc'));
        } else {
            $itemQuery->orderBy('created_at', $request->input('ProductItem.arrange', 'asc'));
        }

        $itemData = $itemQuery->get();

        $filename = ($ioData->filename ?? $ioData->title) . ' (' . date('YmdHis') . ')';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Use sheet 0
        $sheet = $spreadsheet->getSheet(0);
        $sheet->setTitle('import');

        $titleColumnIndex = 0;
        $titleRowIndex = 1;
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.sku') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.serial'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.title') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(20);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.pic'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(20);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.details.description'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(25);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.details.editor'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(25);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.cost'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.price'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.qty_enable'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.qty_safety'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.qty'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductItem.active'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);

        $dataColumnIndex = 0;
        $dataRowIndex = 1;
        foreach ($itemData as $rowData) {
            /** @var \Minmax\Product\Models\ProductItem $rowData */
            $dataRowIndex++;
            $dataColumnIndex = 0;
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->sku, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->serial, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->title, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, collect($rowData->pic)->map(function ($item) { return preg_replace('/^\/files\//i', '', $item['path'] ?? ''); })->implode(','), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, array_get($rowData->details ?? [], 'description'), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, array_get($rowData->details ?? [], 'editor'), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, collect($rowData->cost)->map(function ($item, $key) { return "{$key}:{$item}"; })->implode(','), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, collect($rowData->price)->map(function ($item, $key) { return "{$key}:{$item}"; })->implode(','), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, intval($rowData->qty_enable), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->qty_safety, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->qty, 's');
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
            'total' => $itemData->count(),
            'success' => $itemData->count(),
            'result' => true,
            'file' => "{$filename}.xlsx",
        ]);

        session()->flash('success', __("MinmaxIo::{$this->guard}.form.message.export_success", ['title' => $ioData->title]));

        return $response;
    }
}
