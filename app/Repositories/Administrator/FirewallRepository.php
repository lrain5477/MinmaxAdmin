<?php

namespace App\Repositories\Administrator;

use App\Models\Firewall;

/**
 * Class FirewallRepository
 * @method Firewall find($id)
 * @method Firewall one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method Firewall create($attributes)
 * @method Firewall save($model, $attributes)
 * @method Firewall|\Illuminate\Database\Eloquent\Builder query()
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