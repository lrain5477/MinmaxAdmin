<?php

namespace Minmax\Ad\Web;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

/**
 * Class HelperController
 */
class HelperController extends BaseController
{
    /**
     * @param  Request $request
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function advertisingRedirect(Request $request, $id = null)
    {
        if ($advertisingModel = (new AdvertisingRepository)->find($id)) {
            $trackData = [
                'advertising_id' => $advertisingModel->getKey(),
                'ip' => $request->ip(),
                'click_at' => date('Y-m-d'),
            ];

            if (DB::table('advertising_track')->where($trackData)->count() < 1) {
                DB::table('advertising_track')->insert($trackData);
            }

            if (filter_var($advertisingModel->link, FILTER_VALIDATE_URL)) {
                return redirect($advertisingModel->link);
            }
        }
        return redirect(\URL::previous());
    }
}
