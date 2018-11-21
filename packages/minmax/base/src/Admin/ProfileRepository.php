<?php

namespace App\Repositories\Admin;

use App\Models\Admin;

class ProfileRepository
{
    protected $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function one($where = [])
    {
        return $this->model->where($where)->first() ?? null;
    }

    /**
     * @param array $data
     * @param array $where
     * @return bool
     */
    public function save($data, $where = [])
    {
        $thisRow = $this->one($where);

        foreach($data as $key => $value) {
            $thisRow->$key = is_array($value) ? implode(config('app.separate_string'), $value) : $value;
        }

        return $thisRow->save();
    }
}