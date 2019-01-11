<?php

namespace Minmax\Member\Admin;

use Minmax\Base\Admin\Repository;
use Minmax\Member\Models\MemberAuthentication;

/**
 * Class MemberAuthenticationRepository
 * @property MemberAuthentication $model
 * @method MemberAuthentication find($id)
 * @method MemberAuthentication one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method MemberAuthentication|\Illuminate\Database\Eloquent\Builder create($attributes)
 * @method MemberAuthentication|\Illuminate\Database\Eloquent\Builder query()
 * @method MemberAuthentication saveLanguage($model, $columns = [])
 */
class MemberAuthenticationRepository extends Repository
{
    const MODEL = MemberAuthentication::class;

    const UPDATED_AT = null;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'member_authentication';
    }

    protected function beforeCreate()
    {
        $this->attributes['token'] = array_get($this->attributes, 'token', uuidl());
    }

    protected function afterCreate()
    {
        $this->model->member()->touch();

        $this->model->member->memberRecords()->create([
            'code' => 'authentication',
            'details' => ['tag' => 'Authentication', 'remark' => 'Make a ' . $this->model->type . ' type authentication.'],
        ]);
    }

    protected function afterSave()
    {
        $this->model->member()->touch();

        $this->model->member->memberRecords()->create([
            'code' => 'authenticated',
            'details' => ['tag' => 'Authenticated', 'remark' => $this->model->type . ' is already authenticated.'],
        ]);
    }
}