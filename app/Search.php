<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Search
 *
 * @property int $id
 * @property string $keywords
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Search whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Search whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Search whereKeywords($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Search whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Search extends Model
{
    protected $table = 'search';

    protected $guarded = ['id'];
}
