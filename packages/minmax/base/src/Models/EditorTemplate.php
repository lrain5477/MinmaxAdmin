<?php

namespace Minmax\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EditorTemplate
 * @property integer $id
 * @property string $guard
 * @property string $category
 * @property string $title
 * @property string $description
 * @property string $editor
 * @property integer $sort
 * @property integer $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class EditorTemplate extends Model
{
    protected $table = 'editor_template';
    protected $guarded = [];
}
