<?php

namespace App\Repositories\Admin;

use App\Models\NewsletterTemplate;

/**
 * Class NewsletterTemplateRepository
 * @method NewsletterTemplate find($id)
 * @method NewsletterTemplate one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method NewsletterTemplate create($attributes)
 * @method NewsletterTemplate save($model, $attributes)
 * @method NewsletterTemplate|\Illuminate\Database\Eloquent\Builder query()
 * @method NewsletterTemplate saveLanguage($model, $columns = [])
 */
class NewsletterTemplateRepository extends Repository
{
    const MODEL = NewsletterTemplate::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'newsletter_template';
    }
}