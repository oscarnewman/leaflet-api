<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;

/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    // tell Eloquent that uuid is a string, not an integer
    protected $keyType = 'string';

    public $incrementing = true;

    public function findOrFail($id)
    {
        if (!Uuid::isValid($id)) {
            throw (new ModelNotFoundException())->setModel(this::class, $id);
        }

        return parent::findOrFail($id);
    }
}
