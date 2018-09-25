<?php

namespace App\Http\Controllers\Administrator;

use App\Repositories\Administrator\WorldLanguageRepository;
use Illuminate\Http\Request;

class WorldLanguageController extends Controller
{
    public function __construct(Request $request, WorldLanguageRepository $worldLanguageRepository)
    {
        $this->modelRepository = $worldLanguageRepository;

        parent::__construct($request);
    }
}
