<?php

namespace App\Repositories\Admin;

use App\Models\NewsletterGroup;

/**
 * Class NewsletterGroupRepository
 * @method NewsletterGroup find($id)
 * @method NewsletterGroup one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method NewsletterGroup create($attributes)
 * @method NewsletterGroup save($model, $attributes)
 * @method NewsletterGroup|\Illuminate\Database\Eloquent\Builder query()
 * @method NewsletterGroup saveLanguage($model, $columns = [])
 */
class NewsletterGroupRepository extends Repository
{
    const MODEL = NewsletterGroup::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'newsletter_group';
    }
}