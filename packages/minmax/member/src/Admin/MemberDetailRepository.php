<?php

namespace Minmax\Member\Admin;

use Minmax\Base\Admin\Repository;
use Minmax\Member\Models\MemberDetail;

/**
 * Class MemberDetailRepository
 * @property MemberDetail $model
 * @method MemberDetail find($id)
 * @method MemberDetail one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method MemberDetail|\Illuminate\Database\Eloquent\Builder query()
 * @method MemberDetail saveLanguage($model, $columns = [])
 */
class MemberDetailRepository extends Repository
{
    const MODEL = MemberDetail::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'member_detail';
    }

    protected function beforeSave()
    {
        $this->attributes['name'] = array_get($this->attributes, 'name');
        $this->attributes['contact'] = array_get($this->attributes, 'contact');
        $this->attributes['social'] = array_get($this->attributes, 'social');
        $this->attributes['profile'] = array_get($this->attributes, 'profile');
    }

    protected function afterSave()
    {
        $this->model->member()->touch();

        $this->model->member->memberRecords()->create([
            'code' => 'updated',
            'details' => ['tag' => 'Updated', 'remark' => 'Member profile is updated.'],
        ]);
    }
}