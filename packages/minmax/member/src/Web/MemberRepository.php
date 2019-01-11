<?php

namespace Minmax\Member\Web;

use Minmax\Base\Web\Repository;
use Minmax\Member\Models\Member;

/**
 * Class MemberRepository
 * @property Member $model
 * @method Member find($id)
 * @method Member one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method Member create($attributes)
 * @method Member save($model, $attributes)
 * @method Member|\Illuminate\Database\Eloquent\Builder query()
 */
class MemberRepository extends Repository
{
    const MODEL = Member::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'member';
    }
}