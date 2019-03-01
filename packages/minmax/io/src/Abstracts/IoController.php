<?php

namespace Minmax\Io\Abstracts;

use Illuminate\Http\Request;

/**
 * Abstract class IoController
 */
abstract class IoController
{
    /** @var string $packagePrefix */
    protected $packagePrefix = '';

    /** @var string $guard */
    protected $guard = '';

    /** @var string $uri */
    protected $uri;

    /** @var string $ioUri */
    protected $ioUri = 'io-data';

    /** @var string $uri */
    protected $rootUri = 'siteadmin';

    /** @var \Illuminate\Support\Collection|\Minmax\Base\Models\WorldLanguage[] $languageData */
    protected $languageData;

    /** @var \Illuminate\Support\Collection|\Minmax\Base\Models\WorldLanguage[] $languageActive */
    protected $languageActive;

    /** @var array $viewData */
    protected $viewData;

    /** @var array $systemMenu */
    protected $systemMenu;

    /** @var \Minmax\Base\Models\WebData $webData */
    protected $webData;

    /** @var \Minmax\Base\Models\AdminMenu $pageData */
    protected $pageData;

    /** @var \Minmax\Base\Models\Admin $adminData */
    protected $adminData;

    /**
     * IoControllerInterface constructor.
     * @param  Request $request
     * @param  string $guard
     */
    public function __construct(Request $request, $guard)
    {
        $this->guard = $guard;

        switch ($this->guard) {
            case 'admin':
                $this->ioUri = 'io-data';
                break;
            case 'administrator':
                $this->ioUri = 'io-construct';
                break;
        }

        $this->setAttributes($request->get('controllerAttributes'));

        $this->setDefaultViewData();
    }

    /**
     * Set this controller object attributes
     *
     * @param  array $attributes
     * @return void
     */
    protected function setAttributes($attributes)
    {
        foreach ($attributes ?? [] as $attribute => $value) {
            $this->{$attribute} = $value;
        }
    }

    /**
     * Set default view data.
     */
    protected function setDefaultViewData()
    {
        $this->viewData['languageData'] = $this->languageData;
        $this->viewData['languageActive'] = $this->languageActive;
        $this->viewData['webData'] = $this->webData;
        $this->viewData['systemMenu'] = $this->systemMenu;
        $this->viewData['pageData'] = $this->pageData;
        $this->viewData['adminData'] = $this->adminData;
        $this->viewData['rootUri'] = ($this->webData->system_language == app()->getLocale() ? '' : (app()->getLocale() . '/')) . $this->rootUri;
    }

    /**
     * @param  \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @param  array $range eq: [1, 1, 6, 6]
     * @param  array $styles
     * @return \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
     */
    protected function setSheetStyle($sheet, $range, $styles = [])
    {
        $styles = empty($styles)
            ? [
                'font' => [
                    'size' => 10,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '888888'],
                    ]
                ],
            ]
            : $styles;

        $sheet->getStyleByColumnAndRow(...$range)->applyFromArray($styles);

        return $sheet;
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @param  string $fieldName
     * @param  integer|string $sheetIndex
     * @param  integer $exceptRows
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    protected function getSheetFromFile(Request $request, $fieldName, $sheetIndex = 0, $exceptRows = 0)
    {
        if ($request->hasFile($fieldName) && $request->file($fieldName)->isValid() && $file = $request->file($fieldName)) {
            if (strtolower($file->extension()) == 'xlsx') {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

                if (is_string($sheetIndex)) {
                    $sheetCollection = collect($spreadsheet->getSheetByName($sheetIndex)->toArray());
                } else {
                    $sheetCollection = collect($spreadsheet->getSheet($sheetIndex)->toArray());
                }

                return $exceptRows > 0 ? $sheetCollection->except($exceptRows - 1) : $sheetCollection;
            }
        }

        return null;
    }

    /**
     * @param  integer $id
     * @return mixed
     * @throws \Exception
     */
    abstract public function example($id);

    /**
     * @param  \Illuminate\Http\Request $request
     * @param  integer $id
     * @return mixed
     * @throws \Exception
     */
    abstract public function import(Request $request, $id);

    /**
     * @param  \Illuminate\Http\Request $request
     * @param  integer $id
     * @return mixed
     * @throws \Exception
     */
    abstract public function export(Request $request, $id);
}