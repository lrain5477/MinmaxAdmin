<?php

namespace App\Repositories\Administrator;

use App\Models\EditorTemplate;

/**
 * Class EditorTemplateRepository
 * @method EditorTemplate find($id)
 * @method EditorTemplate one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method EditorTemplate create($attributes)
 * @method EditorTemplate save($model, $attributes)
 * @method EditorTemplate|\Illuminate\Database\Eloquent\Builder query()
 * @method EditorTemplate saveLanguage($model, $columns = [])
 */
class EditorTemplateRepository extends Repository
{
    const MODEL = EditorTemplate::class;

    protected $hasSort = true;

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