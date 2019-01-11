<?php

namespace Minmax\Member\Administrator;

use Minmax\Base\Administrator\Repository;
use Minmax\Member\Models\MemberTerm;

/**
 * Class MemberTermRepository
 * @property MemberTerm $model
 * @method MemberTerm find($id)
 * @method MemberTerm one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method MemberTerm|\Illuminate\Database\Eloquent\Builder query()
 * @method MemberTerm saveLanguage($model, $columns = [])
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