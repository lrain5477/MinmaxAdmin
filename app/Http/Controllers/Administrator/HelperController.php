<?php

namespace App\Http\Controllers\Administrator;

use App\Helpers\CaptchaHelper;
use App\Helpers\ImageHelper;
use App\Models\EditorTemplate;
use Illuminate\Routing\Controller as BaseController;
use Storage;

/**
 * Class HelperController
 */
class HelperController extends BaseController
{
    public function getCaptcha($name, $id = null)
    {
        return CaptchaHelper::createCaptcha('administrator_captcha_' . $name, 4, $id);
    }

    public function getThumbnail($width, $height, $imagePath)
    {
        if($width != $height) abort(404);
        $thumbnailPath = ImageHelper::makeThumbnail($imagePath, $width, $height);
        return Storage::response($thumbnailPath);
    }

    public function getEditorTemplate($category)
    {
        $templates = EditorTemplate::where(['guard' => 'admin', 'lang' => app()->getLocale(), 'category' => $category, 'active' => '1'])
            ->orderBy('sort')
            ->get(['title', 'description', 'editor'])
            ->map(function($item) {
                return [
                    'title' => $item->title,
                    'description' => $item->description,
                    'html' => $item->editor,
                ];
            })
            ->toJson(JSON_UNESCAPED_UNICODE);

        return "CKEDITOR.addTemplates('default',{templates: {$templates} });";
    }
}
