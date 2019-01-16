<?php

namespace Minmax\Member\Admin;

use Minmax\Base\Admin\Repository;
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

    protected $roleSelected = [];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'member';
    }

    protected function beforeCreate()
    {
        $this->attributes['password'] = \Hash::make('123456');

        $this->roleSelected = array_pull($this->attributes, 'role_id', []);
    }

    protected function afterCreate()
    {
        $this->model->syncRoles($this->roleSelected);

        $this->model->memberDetail()->create([
            'name' => ['full_name' => $this->model->name, 'nickname' => $this->model->name],
            'contact' => ['email' => $this->model->email],
        ]);

        $this->model->memberAuthentications()->create([
            'type' => 'email',
            'token' => \Illuminate\Support\Str::uuid(),
        ]);

        $this->model->memberRecords()->create([
            'code' => 'created',
            'details' => ['tag' => 'Created', 'remark' => 'New member ' . $this->model->username . ' is created.'],
        ]);

        sendNotifyEmail('registered', $this->model->email, [$this->model]);
    }

    protected function beforeSave()
    {
        if ($password = array_pull($this->attributes, 'password')) {
            if ($password != '') {
                $this->attributes['password'] = \Hash::make($password);
            }
        }

        array_forget($this->attributes, 'password_confirmation');

        $this->roleSelected = array_pull($this->attributes, 'role_id', []);
    }

    protected function afterSave()
    {
        $this->model->syncRoles($this->roleSelected);

        $this->model->memberRecords()->create([
            'code' => 'updated',
            'details' => ['tag' => 'Updated', 'remark' => 'Member account is updated.'],
        ]);
    }

    protected function afterDelete()
    {
        \DB::table('role_user')->where(['user_id' => $this->model->getKey(), 'user_type' => get_class($this->model)])->delete();
        \DB::table('permission_user')->where(['user_id' => $this->model->getKey(), 'user_type' => get_class($this->model)])->delete();

        $this->model->memberRecords()->create([
            'code' => 'deleted',
            'details' => ['tag' => 'Deleted', 'remark' => 'Member account is deleted.'],
        ]);
    }
}