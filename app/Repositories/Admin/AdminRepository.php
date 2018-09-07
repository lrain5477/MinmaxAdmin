<?php

namespace App\Repositories\Admin;

use App\Models\Admin;

/**
 * Class AdminRepository
 * @method Admin create($attributes)
 * @method Admin save($model, $attributes)
 */
class AdminRepository extends Repository
{
    const MODEL = Admin::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'admin';
    }
}