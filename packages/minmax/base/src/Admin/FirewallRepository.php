<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Firewall;

/**
 * Class FirewallRepository
 * @method Firewall find($id)
 * @method Firewall one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method Firewall create($attributes)
 * @method Firewall save($model, $attributes)
 * @method Firewall|\Illuminate\Database\Eloquent\Builder query()
 */
class FirewallRepository extends Repository
{
    const MODEL = Firewall::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'firewall';
    }

    /**
     * Serialize input attributes to a new model
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function serialization(array $attributes)
    {
        $this->clearLanguageBuffer();

        $model = static::MODEL;
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = new $model();

        $primaryKey = $model->incrementing ? null : uuidl();

        if (!$model->incrementing) {
            $model->setAttribute($model->getKeyName(), $primaryKey);
        }

        if ($this->hasSort && array_key_exists('sort', $attributes)) {
            if (is_null($attributes['sort']) || $attributes['sort'] < 1) {
                $attributes['sort'] = 1;
            }
        }

        foreach ($attributes as $column => $value) {
            if (in_array($column, $this->languageColumns)) {
                $model->setAttribute($column, $this->exchangeLanguage($attributes, $column, $primaryKey));
            } else {
                $model->setAttribute($column, $value);
            }
        }

        $model->setAttribute('guard', 'admin');

        return $model;
    }
}