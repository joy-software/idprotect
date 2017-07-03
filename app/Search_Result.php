<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Search_Result
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string $preview
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Search_Result whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Search_Result whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Search_Result whereLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Search_Result wherePreview($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Search_Result whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Search_Result whereUpdatedAt($value)
 * @property string $source
 * @property int $user_id
 * @method static \Illuminate\Database\Query\Builder|\App\Search_Result whereSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Search_Result whereUserId($value)
 * @property string $links
 * @property string $videoLink
 * @property string $category
 * @property string $statut
 * @property int|null $search_id
 * @property-read \App\Search|null $search
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search_Result whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search_Result whereLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search_Result whereSearchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search_Result whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search_Result whereVideoLink($value)
 */
class Search_Result extends Model
{
    //La table sur laquelle est liée le modèle
    protected $table = 'Search_Result';

    protected $guarded = ['id'];

    public function search()
    {
        return $this->belongsTo(Search::class);
    }

}
