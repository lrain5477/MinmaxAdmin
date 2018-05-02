<?php

namespace App\Repositories\Administrator;

class Repository
{
    /**
     * @var string $modelClassName
     */
    protected $modelClassName = null;

    /**
     * @param $modelClassName
     */
    public function setModelClassName($modelClassName)
    {
        $this->modelClassName = $modelClassName;
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return call_user_func_array("App\\Models\\{$this->modelClassName}::rules", []) ?? null;
    }

    public function getIndexKey() {
        return call_user_func_array("App\\Models\\{$this->modelClassName}::getIndexKey", []) ?? null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function new()
    {
        return app()->make("App\\Models\\{$this->modelClassName}") ?? null;
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Query\Builder
     */
    public function query($where = [])
    {
        return call_user_func_array("App\\Models\\{$this->modelClassName}::where", [$where]) ?? null;
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function one($where = [])
    {
        return call_user_func_array("App\\Models\\{$this->modelClassName}::where", [$where])->first() ?? null;
    }

    /**
     * @param array $where
     * @return \Illuminate\Support\Collection
     */
    public function all($where = [])
    {
        return call_user_func_array("App\\Models\\{$this->modelClassName}::where", [$where])->get() ?? null;
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        foreach($data as $key => $value) {
            if(is_null($value)) unset($data[$key]);
            if(is_array($value)) $data[$key] = implode(',', $value);
        }
        return call_user_func_array("App\\Models\\{$this->modelClassName}::create", [$data]) ?? null;
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

    /**
     * @param array $data
     * @param array $where
     * @return bool
     */
    public function update($data, $where = [])
    {
        foreach($data as $key => $value) {
            if(is_array($value)) $data[$key] = implode(',', $value);
        }
        return call_user_func_array("App\\Models\\{$this->modelClassName}::where", [$where])->update($data) ?? false;
    }

    /**
     * @param array $where
     * @return bool
     */
    public function delete($where = [])
    {
        try {
            return call_user_func_array("App\\Models\\{$this->modelClassName}::where", [$where])->delete();
        } catch (\Exception $e) {
            return false;
        }
    }
}