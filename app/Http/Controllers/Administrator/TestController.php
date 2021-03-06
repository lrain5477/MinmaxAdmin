<?php

namespace App\Http\Controllers\Administrator;

use App\Repositories\Administrator\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use Route;

class TestController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $uri;
    protected $viewData;
    protected $adminData;
    protected $pageData;
    protected $modelName;
    protected $modelRepository;

    public function __construct(Repository $modelRepository)
    {
        $this->middleware('auth:administrator');

        $this->middleware(function($request, $next) {
            $this->adminData = Auth::guard('administrator')->user();
            $this->viewData['adminData'] = $this->adminData;

            return $next($request);
        });
    }

    public function api()
    {
        $parameters = [
            'ID' => '666',
            'Company' => '英創達',
        ];

        $client = new \GuzzleHttp\Client(['base_uri' => env('NEXGEN_API_URL')]);
        $response = $client->put('Test', [
            'headers' => ['Authorization' => env('NEXGEN_API_AUTH_KEY')],
            'json' => $parameters,
        ]);

        echo json_decode($response->getBody()->getContents(), true);
    }
}
