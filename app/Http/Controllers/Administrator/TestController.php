<?php

namespace App\Http\Controllers\Administrator;

use App\Models\WebData;
use App\Repositories\Administrator\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;

/**
 * Class TestController
 * @property \App\Models\Administrator $adminData
 */
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
        $this->middleware(function($request, $next) {
            $this->adminData = Auth::guard('administrator')->user();
            $this->viewData['adminData'] = $this->adminData;
            $this->viewData['webData'] = WebData::where(['lang' => app()->getLocale(), 'website_key' => 'administrator'])->first();

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
