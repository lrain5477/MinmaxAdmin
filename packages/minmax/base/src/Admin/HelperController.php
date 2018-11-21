<?php

namespace Minmax\Base\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Minmax\Base\Helpers\Captcha as CaptchaHelper;
use Minmax\Base\Helpers\Image as ImageHelper;
use Minmax\Base\Models\EditorTemplate;

/**
 * Class HelperController
 */
class HelperController extends BaseController
{
    public function getCaptcha($name, $id = null)
    {
        return CaptchaHelper::createCaptcha('admin_captcha_' . $name, 4, $id);
    }

    public function getThumbnail($width, $height, $imagePath)
    {
        if($width != $height) abort(404);
        $thumbnailPath = ImageHelper::makeThumbnail($imagePath, $width, $height);
        return Storage::response($thumbnailPath);
    }

    public function getEditorTemplate($category)
    {
        $templates = EditorTemplate::where(['guard' => 'admin', 'category' => $category, 'active' => '1'])
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
