<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\EditorTemplate;

/**
 * Class EditorTemplateRepository
 * @property EditorTemplate $model
 * @method EditorTemplate find($id)
 * @method EditorTemplate one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method EditorTemplate create($attributes)
 * @method EditorTemplate save($model, $attributes)
 * @method EditorTemplate|\Illuminate\Database\Eloquent\Builder query()
 */
class EditorTemplateRepository extends Repository
{
    const MODEL = EditorTemplate::class;

    protected $hasSort = true;

    protected $languageColumns = ['title', 'description', 'editor'];

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'editor_template';
    }
}