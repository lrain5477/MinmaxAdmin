<?php

namespace App\Http\Controllers\Administrator;

use App\Repositories\Administrator\EditorTemplateRepository;
use Illuminate\Http\Request;

class EditorTemplateController extends Controller
{
    public function __construct(Request $request, EditorTemplateRepository $editorTemplateRepository)
    {
        $this->modelRepository = $editorTemplateRepository;

        parent::__construct($request);
    }
}
