<?php

namespace Minmax\Base\Admin;

/**
 * Class FileManagerController
 */
class FileManagerController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    protected function checkPermissionShow($type = 'web')
    {
        if($this->adminData->can('systemUpload') === false) abort(404);
    }
}
