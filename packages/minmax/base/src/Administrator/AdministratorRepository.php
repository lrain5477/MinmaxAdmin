<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\Administrator;

/**
 * Class AdministratorRepository
 * @property Administrator $model
 * @method Administrator find($id)
 * @method Administrator one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method Administrator|\Illuminate\Database\Eloquent\Builder query()
 * @method Administrator saveLanguage($model, $columns = [])
 */
class AdministratorRepository extends Repository
{
    const MODEL = Administrator::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'administrator';
    }

    protected function beforeCreate()
    {
        $this->attributes['password'] = \Hash::make('123456');
    }

    protected function beforeSave()
    {
        if ($password = array_pull($this->attributes, 'password')) {
            if ($password != '') {
                $this->attributes['password'] = \Hash::make($password);
            }
        }

        array_forget($this->attributes, 'password_confirmation');
    }
}