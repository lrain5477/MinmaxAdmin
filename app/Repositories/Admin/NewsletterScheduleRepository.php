<?php

namespace App\Repositories\Admin;

use App\Models\NewsletterSchedule;

/**
 * Class NewsletterScheduleRepository
 * @method NewsletterSchedule find($id)
 * @method NewsletterSchedule one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method NewsletterSchedule create($attributes)
 * @method NewsletterSchedule save($model, $attributes)
 * @method NewsletterSchedule|\Illuminate\Database\Eloquent\Builder query()
 * @method NewsletterSchedule saveLanguage($model, $columns = [])
 */
class NewsletterScheduleRepository extends Repository
{
    const MODEL = NewsletterSchedule::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'newsletter_schedule';
    }
}