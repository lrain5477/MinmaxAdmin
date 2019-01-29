<?php

namespace Minmax\Notify\Admin;

use Minmax\Base\Admin\Repository;
use Minmax\Notify\Models\NotifyEmail;

/**
 * Class NotifyEmailRepository
 * @property NotifyEmail $model
 * @method NotifyEmail find($id)
 * @method NotifyEmail one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method NotifyEmail create($attributes)
 * @method NotifyEmail save($model, $attributes)
 * @method NotifyEmail|\Illuminate\Database\Eloquent\Builder query()
 */
class NotifyEmailRepository extends Repository
{
    const MODEL = NotifyEmail::class;

    protected $sort = 'sort';

    protected $languageColumns = [
        'title',
        'custom_subject', 'custom_preheader', 'custom_editor',
        'admin_subject', 'admin_preheader', 'admin_editor',
        'replacements'
    ];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'notify_email';
    }
}