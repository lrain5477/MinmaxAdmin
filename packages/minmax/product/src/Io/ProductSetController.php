<?php

namespace Minmax\Product\Io;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Minmax\Base\Admin\ColumnExtensionRepository;
use Minmax\Base\Admin\SiteParameterGroupRepository;
use Minmax\Io\Abstracts\IoController;
use Minmax\Io\Admin\IoConstructRepository;
use Minmax\Io\Models\IoRecord;
use Minmax\Product\Admin\ProductBrandRepository;
use Minmax\Product\Admin\ProductCategoryRepository;
use Minmax\Product\Admin\ProductSetRepository;

/**
 * Class ProductSetController
 */
class ProductSetController extends IoController
{
    protected $packagePrefix = 'MinmaxProduct::';

    public function example($id)
    {
        $ioData = (new IoConstructRepository)->find($id) ?? abort(404);

        $filename = ($ioData->filename ?? $ioData->title) . ' (Sample)';

        // Data sets
        $brandsSet = (new ProductBrandRepository)->getSelectParameters();
        $categoriesSet = (new ProductCategoryRepository)->getSelectParameters(false, true);
        $tagsSet = siteParam('tags');
        $specificationsGroupSet = (new SiteParameterGroupRepository)->all(['category' => 'spec', 'active' => true]);
        $specificationsSet = siteParam(null, null, 'spec');
        $propertiesSet = siteParam('property');

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Use sheet 0
        $sheet = $spreadsheet->getSheet(0);
        $sheet->setTitle('import');

        $titleColumnIndex = 0;
        $titleRowIndex = 1;
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.sku') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.sku'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.serial'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.title') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(20);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.title'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.brand_id'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(17);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.brand_id'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.categories') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(17);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.categories'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.pic'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(20);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.pic'))->getFont()->setSize(9);

        $detailsColumns = (new ColumnExtensionRepository)->getFields('product_set', 'details');
        foreach ($detailsColumns as $columnData) {
            $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, $columnData->title . (array_get($columnData->options, 'required', false) == true ? ' *' : ''), 's')
                ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(25);
            if (array_get($columnData->options, 'method') == 'getFieldEditor') {
                $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.html'))->getFont()->setSize(9);
            }
        }

        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.rank') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.rank'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.tags'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(15);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.tags'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.spec_group'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.spec_group'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.specifications'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.specifications'))->getFont()->setSize(9);

        if (in_array(\Minmax\Ecommerce\ServiceProvider::class, config('app.providers'))) {
            $ecParamColumns = (new ColumnExtensionRepository)->getFields('product_set', 'ec_parameters');
            foreach ($ecParamColumns as $columnData) {
                $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, $columnData->title . (array_get($columnData->options, 'required', false) == true ? ' *' : ''), 's')
                    ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
                if (array_get($columnData->options, 'required', false) == true) {
                    $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.required'))->getFont()->setSize(9);
                }
                $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.ec_parameters'))->getFont()->setSize(9);
                if (in_array(array_get($columnData->options, 'method', ''), ['getFieldCheckbox', 'getFieldMultiSelection'])) {
                    $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.multiple'))->getFont()->setSize(9);
                }
            }
        }

        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.properties'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.properties'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.start_at'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(17);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.start_at'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.end_at'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(17);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.end_at'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.searchable') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.searchable'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.visible') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.visible'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.sort'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(6);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.active') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.active'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.seo.meta_description'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(15);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.seo.meta_keywords'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(15);

        $dataColumnIndex = 0;
        $dataRowIndex = 2;
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'DEMO001', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'demo-001', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'This is a demo product', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, collect($brandsSet)->keys()->first(), 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, collect($categoriesSet)->keys()->take(2)->implode(','), 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'images/4K_486863608.jpg', 's');

        foreach ($detailsColumns as $columnData) {
            switch (array_get($columnData->options, 'method')) {
                case 'getFieldText':
                case 'getFieldTextarea':
                    $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'Some words here', 's');
                    break;
                case 'getFieldEditor':
                    $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '<p>Any html code here</p>', 's');
                    break;
                default:
                    $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '', 's');
            }
        }

        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '0', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, collect($tagsSet)->pluck('title')->take(2)->implode(','), 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '', 's');

        if (in_array(\Minmax\Ecommerce\ServiceProvider::class, config('app.providers')) && isset($ecParamColumns)) {
            foreach ($ecParamColumns as $columnData) {
                switch (array_get($columnData->options, 'method')) {
                    case 'getFieldText':
                    case 'getFieldTextarea':
                        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'Some words here', 's');
                        break;
                    case 'getFieldEditor':
                        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '<p>Any html code here</p>', 's');
                        break;
                    case 'getFieldCheckbox':
                    case 'getFieldMultiSelection':
                        $paramSet = [];
                        if (array_key_exists('siteParam', $columnData->options)) {
                            $paramSet = siteParam(array_get($columnData->options, 'siteParam'));
                        } elseif (array_key_exists('systemParam', $columnData->options)) {
                            $paramSet = systemParam(array_get($columnData->options, 'systemParam'));
                        }
                        if (count($paramSet) > 0) {
                            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, collect($paramSet)->keys()->take(2)->implode(','), 's');
                        } else {
                            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '', 's');
                        }
                        break;
                    case 'getFieldSelection':
                    case 'getFieldRadio':
                        $paramSet = [];
                        if (array_key_exists('siteParam', $columnData->options)) {
                            $paramSet = siteParam(array_get($columnData->options, 'siteParam'));
                        } elseif (array_key_exists('systemParam', $columnData->options)) {
                            $paramSet = systemParam(array_get($columnData->options, 'systemParam'));
                        }
                        if (count($paramSet) > 0) {
                            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, collect($paramSet)->keys()->first(), 's');
                        } else {
                            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '0', 's');
                        }
                        break;
                    default:
                        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '', 's');
                }
            }
        }

        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, collect($propertiesSet)->keys()->take(2)->implode(','), 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, today()->format('Y-m-d H:i:s'), 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, today()->addMonth()->format('Y-m-d H:i:s'), 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '1', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '1', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '1', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '1', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'SEO description', 's');
        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, 'keyword1,keyword2', 's');

        // Set sheet style
        $this->setSheetStyle($sheet, [1, 1, $dataColumnIndex, $dataRowIndex]);
        $this->setSheetStyle($sheet, [1, 1, $titleColumnIndex, $titleRowIndex], [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFEFEF']]
        ]);

        // Use sheet 1
        $sheet = $spreadsheet->createSheet(1);
        $sheet->setTitle(__('MinmaxProduct::models.ProductSet.brand_id'));

        $titleColumnIndex = 0;
        $titleRowIndex = 1;
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductBrand.id'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(20);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductBrand.title'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(50);

        $dataColumnIndex = 0;
        $dataRowIndex = 1;
        foreach ($brandsSet as $brandId => $brandData) {
            $dataColumnIndex = 0;
            $dataRowIndex++;
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $brandId, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, array_get($brandData, 'title', ''), 's');
        }

        // Set sheet style
        $this->setSheetStyle($sheet, [1, 1, $dataColumnIndex, $dataRowIndex]);
        $this->setSheetStyle($sheet, [1, 1, $titleColumnIndex, $titleRowIndex], [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFEFEF']]
        ]);

        // Use sheet 2
        $sheet = $spreadsheet->createSheet(2);
        $sheet->setTitle(__('MinmaxProduct::models.ProductSet.categories'));

        $titleColumnIndex = 0;
        $titleRowIndex = 1;
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductCategory.id'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(20);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductCategory.title'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(50);

        $dataColumnIndex = 0;
        $dataRowIndex = 1;
        foreach ($categoriesSet as $categoryId => $categoryData) {
            $dataColumnIndex = 0;
            $dataRowIndex++;
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $categoryId, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, array_get($categoryData, 'title', ''), 's');
        }

        // Set sheet style
        $this->setSheetStyle($sheet, [1, 1, $dataColumnIndex, $dataRowIndex]);
        $this->setSheetStyle($sheet, [1, 1, $titleColumnIndex, $titleRowIndex], [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFEFEF']]
        ]);

        // Use sheet 3
        $sheet = $spreadsheet->createSheet(3);
        $sheet->setTitle(__('MinmaxProduct::models.ProductSet.tags'));

        $titleColumnIndex = 0;
        $titleRowIndex = 1;
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.tags'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(40);

        $dataColumnIndex = 0;
        $dataRowIndex = 1;
        foreach ($tagsSet as $tagData) {
            $dataColumnIndex = 0;
            $dataRowIndex++;
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, array_get($tagData, 'title', ''), 's');
        }

        // Set sheet style
        $this->setSheetStyle($sheet, [1, 1, $dataColumnIndex, $dataRowIndex]);
        $this->setSheetStyle($sheet, [1, 1, $titleColumnIndex, $titleRowIndex], [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFEFEF']]
        ]);

        // Use sheet 4
        $sheet = $spreadsheet->createSheet(4);
        $sheet->setTitle(__('MinmaxProduct::models.ProductSet.specifications'));

        $titleColumnIndex = 0;
        $titleRowIndex = 1;
        foreach ($specificationsGroupSet as $specificationGroupData) {
            if ($titleColumnIndex > 0) {
                $sheet->getColumnDimensionByColumn($titleColumnIndex)->setWidth(2);
            }

            $sheet->setCellValueExplicitByColumnAndRow($titleColumnIndex + 1, $titleRowIndex, 'ID', 's')
                ->getColumnDimensionByColumn($titleColumnIndex + 1)->setWidth(7);
            $sheet->setCellValueExplicitByColumnAndRow($titleColumnIndex + 2, $titleRowIndex, $specificationGroupData->title, 's')
                ->getColumnDimensionByColumn($titleColumnIndex + 2)->setWidth(25);

            $dataColumnIndex = $titleColumnIndex;
            $dataRowIndex = 1;
            foreach (array_get($specificationsSet, $specificationGroupData->code, []) as $specKey => $specData) {
                $dataColumnIndex = $titleColumnIndex;
                $dataRowIndex++;
                $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $specKey, 's');
                $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, array_get($specData, 'title', ''), 's');
            }

            // Set sheet style
            $this->setSheetStyle($sheet, [$titleColumnIndex + 1, 1, $dataColumnIndex, $dataRowIndex]);
            $this->setSheetStyle($sheet, [$titleColumnIndex + 1, 1, $titleColumnIndex + 2, 1], [
                'font' => ['bold' => true],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFEFEF']]
            ]);

            $titleColumnIndex = $titleColumnIndex + 3;
        }

        $sheet->setSelectedCellByColumnAndRow(1, 1);

        // Use sheet 5
        if (in_array(\Minmax\Ecommerce\ServiceProvider::class, config('app.providers')) && isset($ecParamColumns)) {
            $sheet = $spreadsheet->createSheet(5);
            $sheet->setTitle(__('MinmaxProduct::models.ProductSet.ec_parameters'));

            $titleColumnIndex = 0;
            $titleRowIndex = 1;
            foreach ($ecParamColumns as $columnData) {
                $paramSet = [];
                if (array_key_exists('siteParam', $columnData->options)) {
                    $paramSet = siteParam(array_get($columnData->options, 'siteParam'));
                } elseif (array_key_exists('systemParam', $columnData->options)) {
                    $paramSet = systemParam(array_get($columnData->options, 'systemParam'));
                }

                if (count($paramSet) > 0) {
                    if ($titleColumnIndex > 0) {
                        $sheet->getColumnDimensionByColumn($titleColumnIndex)->setWidth(2);
                    }

                    $sheet->setCellValueExplicitByColumnAndRow($titleColumnIndex + 1, $titleRowIndex, 'ID', 's')
                        ->getColumnDimensionByColumn($titleColumnIndex + 1)->setWidth(7);
                    $sheet->setCellValueExplicitByColumnAndRow($titleColumnIndex + 2, $titleRowIndex, $columnData->title, 's')
                        ->getColumnDimensionByColumn($titleColumnIndex + 2)->setWidth(25);

                    $dataColumnIndex = $titleColumnIndex;
                    $dataRowIndex = 1;
                    foreach ($paramSet as $paramKey => $paramData) {
                        $dataColumnIndex = $titleColumnIndex;
                        $dataRowIndex++;
                        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $paramKey, 's');
                        $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, array_get($paramData, 'title', ''), 's');
                    }

                    // Set sheet style
                    $this->setSheetStyle($sheet, [$titleColumnIndex + 1, 1, $dataColumnIndex, $dataRowIndex]);
                    $this->setSheetStyle($sheet, [$titleColumnIndex + 1, 1, $titleColumnIndex + 2, 1], [
                        'font' => ['bold' => true],
                        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFEFEF']]
                    ]);

                    $titleColumnIndex = $titleColumnIndex + 3;
                }
            }

            $sheet->setSelectedCellByColumnAndRow(1, 1);
        }

        // Use sheet 6
        $sheet = $spreadsheet->createSheet(6);
        $sheet->setTitle(__('MinmaxProduct::models.ProductSet.properties'));

        $titleColumnIndex = 0;
        $titleRowIndex = 1;
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, 'ID', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(20);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.properties'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(50);

        $dataColumnIndex = 0;
        $dataRowIndex = 1;
        foreach ($propertiesSet as $propertyKey => $propertyData) {
            $dataColumnIndex = 0;
            $dataRowIndex++;
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $propertyKey, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, array_get($propertyData, 'title', ''), 's');
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

        $fileField = 'ProductSet.file';

        $sheetData = $this->getSheetFromFile($request, $fileField, 'import', 1);

        if (is_null($sheetData)) {
            return redirect(langRoute("{$this->guard}.{$this->ioUri}.config", ['id' => $id]))
                ->withErrors([__("MinmaxIo::{$this->guard}.form.message.import_error", ['title' => $ioData->title])]);
        }

        // Insert data
        $skuPool = DB::table('product_set')->pluck('sku')->toArray();
        $insertData = [];
        $updateData = [];
        $errorRecord = [];
        foreach ($sheetData as $rowIndex => $rowData) {
            $duplicate = false;
            $errorCounter = 0;

            if (empty($rowData[0] ?? '')) {
                $errorRecord[] = ['row' => $rowIndex, 'message' => __('validation.required', ['attribute' => __('MinmaxProduct::models.ProductSet.sku')])];
                $errorCounter++;
            }

            if (in_array($rowData[0] ?? '', $skuPool) || collect($insertData)->where('sku', $rowData[0] ?? '')->count() > 0) {
                if (intval($request->input('ProductSet.override', 0)) == 1 && ! array_key_exists($rowData[0], $updateData)) {
                    $duplicate = true;
                } else {
                    $errorRecord[] = ['row' => $rowIndex, 'message' => __('validation.unique', ['attribute' => __('MinmaxProduct::models.ProductSet.sku')])];
                    $errorCounter++;
                }
            }

            if (empty($rowData[2] ?? '')) {
                $errorRecord[] = ['row' => $rowIndex, 'message' => __('validation.required', ['attribute' => __('MinmaxProduct::models.ProductSet.title')])];
                $errorCounter++;
            }

            if ($errorCounter > 0) continue;

            $colIndex = 0;
            if ($duplicate) {
                $rowUpdateData = [];
                $rowUpdateData['serial'] = $rowData[++$colIndex];
                $rowUpdateData['title'] = $rowData[++$colIndex];
                $rowUpdateData['brand_id'] = $rowData[++$colIndex] ?? null;
                $rowUpdateData['categories'] = explode(',', $rowData[++$colIndex] ?? '');
                $rowUpdateData['pic'] = collect(explode(',', $rowData[++$colIndex] ?? ''))->map(function ($item) { return ['path' => '/files/' . $item]; })->toArray();

                $rowDetails = [];
                $detailsColumns = (new ColumnExtensionRepository)->getFields('product_set', 'details');
                foreach ($detailsColumns as $columnData) {
                    switch (array_get($columnData->options, 'method')) {
                        case 'getFieldCheckbox':
                        case 'getFieldMultiSelection':
                            $rowDetails[$columnData->sub_column_name] = explode(',', $rowData[++$colIndex] ?? '');
                            break;
                        default:
                            $rowDetails[$columnData->sub_column_name] = $rowData[++$colIndex] ?? null;
                    }
                }
                $rowUpdateData['details'] = $rowDetails;

                $rowUpdateData['rank'] = $rowData[++$colIndex] ?? 0;
                $rowUpdateData['tags'] = explode(',', $rowData[++$colIndex] ?? '');
                $rowUpdateData['spec_group'] = $rowData[++$colIndex] ?? '';
                $rowUpdateData['specifications'] = explode(',', $rowData[++$colIndex] ?? '');

                $rowEcParameters = [];
                if (in_array(\Minmax\Ecommerce\ServiceProvider::class, config('app.providers'))) {
                    $ecParamColumns = (new ColumnExtensionRepository)->getFields('product_set', 'ec_parameters');
                    foreach ($ecParamColumns as $columnData) {
                        $colEcParameter = $rowData[++$colIndex];
                        switch (array_get($columnData->options, 'method')) {
                            case 'getFieldRadio':
                            case 'getFieldSelection':
                                if (array_key_exists('siteParam', $columnData->options)) {
                                    $paramSet = siteParam(array_get($columnData->options, 'siteParam'));
                                    if (array_get($columnData->options, 'required', false) == true
                                        && (is_null($colEcParameter) || $colEcParameter == '' || !array_key_exists($colEcParameter, $paramSet))) {
                                        $rowEcParameters[$columnData->sub_column_name] = collect($paramSet)->keys()->first();
                                    } else {
                                        $rowEcParameters[$columnData->sub_column_name] = $colEcParameter;
                                    }
                                } elseif (array_key_exists('systemParam', $columnData->options)) {
                                    $paramSet = systemParam(array_get($columnData->options, 'systemParam'));
                                    if (array_get($columnData->options, 'required', false) == true
                                        && (is_null($colEcParameter) || $colEcParameter == '' || !array_key_exists($colEcParameter, $paramSet))) {
                                        $rowEcParameters[$columnData->sub_column_name] = collect($paramSet)->keys()->first();
                                    } else {
                                        $rowEcParameters[$columnData->sub_column_name] = $colEcParameter;
                                    }
                                } else {
                                    $rowEcParameters[$columnData->sub_column_name] = $colEcParameter;
                                }
                                break;
                            case 'getFieldCheckbox':
                            case 'getFieldMultiSelection':
                                $rowEcParameters[$columnData->sub_column_name] = explode(',', $colEcParameter ?? '');
                                break;
                            default:
                                $rowEcParameters[$columnData->sub_column_name] = $colEcParameter ?? null;
                        }
                    }
                }
                $rowUpdateData['ec_parameters'] = $rowEcParameters;

                $rowUpdateData['properties'] = explode(',', $rowData[++$colIndex] ?? '');
                $rowUpdateData['start_at'] = isset($rowData[++$colIndex]) ? date('Y-m-d H:i:s', strtotime($rowData[$colIndex])) : date('Y-m-d H:i:s');
                $rowUpdateData['end_at'] = isset($rowData[++$colIndex]) ? date('Y-m-d H:i:s', strtotime($rowData[$colIndex])) : null;
                $rowUpdateData['searchable'] = boolval($rowData[++$colIndex] ?? 1);
                $rowUpdateData['visible'] = boolval($rowData[++$colIndex] ?? 1);
                $rowUpdateData['sort'] = isset($rowData[++$colIndex]) ? intval($rowData[$colIndex]) : null;
                $rowUpdateData['active'] = boolval($rowData[++$colIndex] ?? 1);
                $rowUpdateData['seo'] = [
                    'description' => $rowData[++$colIndex],
                    'keywords' => $rowData[++$colIndex],
                ];

                $updateData[$rowData[0]] = $rowUpdateData;
            } else {
                $rowInsertData = [];
                $rowInsertData['sku'] = $rowData[$colIndex];
                $rowInsertData['serial'] = $rowData[++$colIndex];
                $rowInsertData['title'] = $rowData[++$colIndex];
                $rowInsertData['brand_id'] = $rowData[++$colIndex] ?? null;
                $rowInsertData['categories'] = explode(',', $rowData[++$colIndex] ?? '');
                $rowInsertData['pic'] = collect(explode(',', $rowData[++$colIndex] ?? ''))->map(function ($item) { return ['path' => '/files/' . $item]; })->toArray();

                $rowDetails = [];
                $detailsColumns = (new ColumnExtensionRepository)->getFields('product_set', 'details');
                foreach ($detailsColumns as $columnData) {
                    switch (array_get($columnData->options, 'method')) {
                        case 'getFieldCheckbox':
                        case 'getFieldMultiSelection':
                            $rowDetails[$columnData->sub_column_name] = explode(',', $rowData[++$colIndex] ?? '');
                            break;
                        default:
                            $rowDetails[$columnData->sub_column_name] = $rowData[++$colIndex] ?? null;
                    }
                }
                $rowInsertData['details'] = $rowDetails;

                $rowInsertData['rank'] = $rowData[++$colIndex] ?? 0;
                $rowInsertData['tags'] = explode(',', $rowData[++$colIndex] ?? '');
                $rowInsertData['spec_group'] = $rowData[++$colIndex] ?? '';
                $rowInsertData['specifications'] = explode(',', $rowData[++$colIndex] ?? '');

                $rowEcParameters = [];
                if (in_array(\Minmax\Ecommerce\ServiceProvider::class, config('app.providers'))) {
                    $ecParamColumns = (new ColumnExtensionRepository)->getFields('product_set', 'ec_parameters');
                    foreach ($ecParamColumns as $columnData) {
                        $colEcParameter = $rowData[++$colIndex];
                        switch (array_get($columnData->options, 'method')) {
                            case 'getFieldRadio':
                            case 'getFieldSelection':
                                if (array_key_exists('siteParam', $columnData->options)) {
                                    $paramSet = siteParam(array_get($columnData->options, 'siteParam'));
                                    if (array_get($columnData->options, 'required', false) == true
                                        && (is_null($colEcParameter) || $colEcParameter == '' || !array_key_exists($colEcParameter, $paramSet))) {
                                        $rowEcParameters[$columnData->sub_column_name] = collect($paramSet)->keys()->first();
                                    } else {
                                        $rowEcParameters[$columnData->sub_column_name] = $colEcParameter;
                                    }
                                } elseif (array_key_exists('systemParam', $columnData->options)) {
                                    $paramSet = systemParam(array_get($columnData->options, 'systemParam'));
                                    if (array_get($columnData->options, 'required', false) == true
                                        && (is_null($colEcParameter) || $colEcParameter == '' || !array_key_exists($colEcParameter, $paramSet))) {
                                        $rowEcParameters[$columnData->sub_column_name] = collect($paramSet)->keys()->first();
                                    } else {
                                        $rowEcParameters[$columnData->sub_column_name] = $colEcParameter;
                                    }
                                } else {
                                    $rowEcParameters[$columnData->sub_column_name] = $colEcParameter;
                                }
                                break;
                            case 'getFieldCheckbox':
                            case 'getFieldMultiSelection':
                                $rowEcParameters[$columnData->sub_column_name] = explode(',', $colEcParameter ?? '');
                                break;
                            default:
                                $rowEcParameters[$columnData->sub_column_name] = $colEcParameter ?? null;
                        }
                    }
                }
                $rowInsertData['ec_parameters'] = $rowEcParameters;

                $rowInsertData['properties'] = explode(',', $rowData[++$colIndex] ?? '');
                $rowInsertData['start_at'] = isset($rowData[++$colIndex]) ? date('Y-m-d H:i:s', strtotime($rowData[$colIndex])) : date('Y-m-d H:i:s');
                $rowInsertData['end_at'] = isset($rowData[++$colIndex]) ? date('Y-m-d H:i:s', strtotime($rowData[$colIndex])) : null;
                $rowInsertData['searchable'] = boolval($rowData[++$colIndex] ?? 1);
                $rowInsertData['visible'] = boolval($rowData[++$colIndex] ?? 1);
                $rowInsertData['sort'] = isset($rowData[++$colIndex]) ? intval($rowData[$colIndex]) : null;
                $rowInsertData['active'] = boolval($rowData[++$colIndex] ?? 1);
                $rowInsertData['seo'] = [
                    'description' => $rowData[++$colIndex],
                    'keywords' => $rowData[++$colIndex],
                ];

                $insertData[$rowIndex] = $rowInsertData;
            }
        }

        try {
            DB::beginTransaction();

            if (count($insertData) < 1 && count($updateData) < 1) throw new \Exception;

            $repository = new ProductSetRepository();
            foreach ($insertData as $rowIndex => $insertAttributes) {
                if (is_null($repository->create($insertAttributes))) {
                    $errorRecord[] = ['row' => $rowIndex, 'message' => 'Insert data failed.'];
                }
            }

            if (count($updateData) > 0) {
                foreach ($updateData as $updateSku => $updateAttributes) {
                    if ($productData = $repository->one('sku', $updateSku)) {
                        $repository->save($productData, $updateAttributes);
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

        $itemQuery = (new ProductSetRepository)->query()
            ->with(['productCategories'])
            ->where(function ($query) use ($request) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                if ($createdAtStart = $request->input('ProductSet.created_at.start')) {
                    $query->where('created_at', '>=', "{$createdAtStart} 00:00:00");
                }
                if ($createdAtEnd = $request->input('ProductSet.created_at.end')) {
                    $query->where('created_at', '<=', "{$createdAtEnd} 23:59:59");
                }
                if ($updatedAtStart = $request->input('ProductSet.updated_at.start')) {
                    $query->where('updated_at', '>=', "{$updatedAtStart} 00:00:00");
                }
                if ($updatedAtEnd = $request->input('ProductSet.updated_at.end')) {
                    $query->where('updated_at', '<=', "{$updatedAtEnd} 23:59:59");
                }
                if (! is_null($active = $request->input('ProductSet.active'))) {
                    $query->where('active', boolval($active));
                }
            });

        if ($sortBy = $request->input('ProductSet.sort')) {
            $itemQuery->orderBy($sortBy, $request->input('ProductSet.arrange', 'asc'));
        } else {
            $itemQuery->orderBy('created_at', $request->input('ProductSet.arrange', 'asc'));
        }

        $itemData = $itemQuery->get();

        $filename = ($ioData->filename ?? $ioData->title) . ' (' . date('YmdHis') . ')';

        // Data sets
        $tagsSet = siteParam('tags');

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Use sheet 0
        $sheet = $spreadsheet->getSheet(0);
        $sheet->setTitle('import');

        $titleColumnIndex = 0;
        $titleRowIndex = 1;
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.sku') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.sku'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.serial'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.title') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(20);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.title'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.brand_id'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(17);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.brand_id'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.categories') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(17);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.categories'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.pic'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(20);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.pic'))->getFont()->setSize(9);

        $detailsColumns = (new ColumnExtensionRepository)->getFields('product_set', 'details');
        foreach ($detailsColumns as $columnData) {
            $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, $columnData->title . (array_get($columnData->options, 'required', false) == true ? ' *' : ''), 's')
                ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(25);
            if (array_get($columnData->options, 'method') == 'getFieldEditor') {
                $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.html'))->getFont()->setSize(9);
            }
        }

        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.rank') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.rank'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.tags'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(15);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.tags'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.spec_group'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.spec_group'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.specifications'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(12);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.specifications'))->getFont()->setSize(9);

        if (in_array(\Minmax\Ecommerce\ServiceProvider::class, config('app.providers'))) {
            $ecParamColumns = (new ColumnExtensionRepository)->getFields('product_set', 'ec_parameters');
            foreach ($ecParamColumns as $columnData) {
                $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, $columnData->title . (array_get($columnData->options, 'required', false) == true ? ' *' : ''), 's')
                    ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
                if (array_get($columnData->options, 'required', false) == true) {
                    $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.required'))->getFont()->setSize(9);
                }
                $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.ec_parameters'))->getFont()->setSize(9);
                if (in_array(array_get($columnData->options, 'method', ''), ['getFieldCheckbox', 'getFieldMultiSelection'])) {
                    $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.multiple'))->getFont()->setSize(9);
                }
            }
        }

        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.properties'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.properties'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.start_at'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(17);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.start_at'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.end_at'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(17);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.end_at'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.searchable') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.searchable'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.visible') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.visible'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.sort'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(6);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.active') . ' *', 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(10);
        $sheet->getCommentByColumnAndRow($titleColumnIndex, $titleRowIndex)->getText()->createTextRun(__('MinmaxProduct::io.ProductSet.export.comments.active'))->getFont()->setSize(9);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.seo.meta_description'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(15);
        $sheet->setCellValueExplicitByColumnAndRow(++$titleColumnIndex, $titleRowIndex, __('MinmaxProduct::models.ProductSet.seo.meta_keywords'), 's')
            ->getColumnDimensionByColumn($titleColumnIndex)->setWidth(15);

        $dataColumnIndex = 0;
        $dataRowIndex = 1;
        foreach ($itemData as $rowData) {
            /** @var \Minmax\Product\Models\ProductSet $rowData */
            $dataRowIndex++;
            $dataColumnIndex = 0;
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->sku, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->serial, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->title, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->brand_id, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->productCategories->pluck('id')->implode(','), 's');
            $rowPics = collect($rowData->pic ?? [])->map(function ($item) { return preg_replace("/^\/files\//i", '', array_get($item, 'path', '')); })->implode(',');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowPics, 's');

            foreach ($detailsColumns as $columnData) {
                $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, array_get($rowData->details, $columnData->sub_column_name, ''), 's');
            }

            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->rank, 's');
            $rowTags = collect($rowData->tags ?? [])->filter(function ($item) use ($tagsSet) { return array_key_exists($item, $tagsSet); })->map(function ($item) use ($tagsSet) { return array_get($tagsSet, "{$item}.title"); })->implode(',');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowTags, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->spec_group, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, implode(',', $rowData->specifications ?? []), 's');

            if (in_array(\Minmax\Ecommerce\ServiceProvider::class, config('app.providers')) && isset($ecParamColumns)) {
                $rowEcParameters = $rowData->ec_parameters ?? [];
                foreach ($ecParamColumns as $columnData) {
                    switch (array_get($columnData->options, 'method')) {
                        case 'getFieldText':
                        case 'getFieldTextarea':
                        case 'getFieldEditor':
                            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, array_get($rowEcParameters, $columnData->sub_column_name, ''), 's');
                            break;
                        case 'getFieldRadio':
                        case 'getFieldSelection':
                            $rowEcParam = array_get($rowEcParameters, $columnData->sub_column_name);
                            if (array_key_exists('siteParam', $columnData->options)) {
                                $paramSet = siteParam(array_get($columnData->options, 'siteParam'));
                                $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowEcParam ?? collect($paramSet)->keys()->first(), 's');
                            } elseif (array_key_exists('systemParam', $columnData->options)) {
                                $paramSet = systemParam(array_get($columnData->options, 'systemParam'));
                                $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowEcParam ?? collect($paramSet)->keys()->first(), 's');
                            } else {
                                $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowEcParam, 's');
                            }
                            break;
                        case 'getFieldCheckbox':
                        case 'getFieldMultiSelection':
                            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, implode(',', array_get($rowEcParameters, $columnData->sub_column_name, []) ?? []), 's');
                            break;
                        default:
                            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, '', 's');
                    }
                }
            }

            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, implode(',', $rowData->properties ?? []), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->start_at, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->end_at, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, intval($rowData->searchable), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, intval($rowData->visible), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, $rowData->sort, 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, intval($rowData->active), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, array_get($rowData->seo, 'description', ''), 's');
            $sheet->setCellValueExplicitByColumnAndRow(++$dataColumnIndex, $dataRowIndex, array_get($rowData->seo, 'keywords', ''), 's');
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
