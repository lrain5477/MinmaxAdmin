<?php

namespace Minmax\Member\Admin;

use Minmax\Base\Admin\Repository;
use Minmax\Member\Models\MemberTerm;

/**
 * Class MemberTermRepository
 * @property MemberTerm $model
 * @method MemberTerm find($id)
 * @method MemberTerm one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method MemberTerm create($attributes)
 * @method MemberTerm save($model, $attributes)
 * @method MemberTerm|\Illuminate\Database\Eloquent\Builder query()
 */
class MemberTermRepository extends Repository
{
    const MODEL = MemberTerm::class;

    protected $languageColumns = ['title', 'editor'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'member_term';
    }
}