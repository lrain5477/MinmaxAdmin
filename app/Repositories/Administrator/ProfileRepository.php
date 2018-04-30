<?php

namespace App\Repositories\Administrator;

use App\Models\Administrator;

class ProfileRepository
{
    protected $model;

    public function __construct(Administrator $model)
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
            $thisRow->$key = is_array($value) ? implode(',', $value) : $value;
        }

        return $thisRow->save();
    }
}