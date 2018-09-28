<?php

namespace App\Repositories\Admin;

use App\Models\NewsletterSubscribe;

/**
 * Class NewsletterSubscribeRepository
 * @method NewsletterSubscribe find($id)
 * @method NewsletterSubscribe one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method NewsletterSubscribe create($attributes)
 * @method NewsletterSubscribe save($model, $attributes)
 * @method NewsletterSubscribe|\Illuminate\Database\Eloquent\Builder query()
 * @method NewsletterSubscribe saveLanguage($model, $columns = [])
 */
class NewsletterSubscribeRepository extends Repository
{
    const MODEL = NewsletterSubscribe::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'newsletter_subscribe';
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

        foreach ($attributes as $column => $value) {
            $model->setAttribute($column, $value);
        }

        return $model;
    }
}