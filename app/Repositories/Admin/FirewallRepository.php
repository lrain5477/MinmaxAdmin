<?php

namespace App\Repositories\Admin;

use App\Models\Firewall;

/**
 * Class FirewallRepository
 * @method Firewall create($attributes)
 * @method Firewall save($model, $attributes)
 */
class FirewallRepository extends Repository
{
    const MODEL = Firewall::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'firewall';
    }
}