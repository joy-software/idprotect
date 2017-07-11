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
 * @property int|null $user_id
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Search_Result[] $searchResults
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Search_Result[] $searchResults_A
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Search_Result[] $searchResults_D
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Search_Result[] $searchResults_I
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Search_Result[] $searchResults_S
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Search_Result[] $searchResults_V
 */
class Search extends Model
{
    protected $table = 'search';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the search results for the search query.
     */
    public function searchResults()
    {
        return $this->hasMany('App\Search_Result');
    }

    /**
     * Get the search results for the search query for the category 'all'.
     * @return static
     */
    public function searchResults_A()
    {
       return  $this->hasMany('App\Search_Result')->where('category','all');
    }

    /**
     * Get the search results for the search query for the category 'all'.
     * @return static
     */
    public function searchProfile()
    {
        return  $this->hasMany('App\Search_Result')->where('statut','valid');
    }

    /**
     * Get the search results for the search query for the category 'all'.
     * @return static
     */
    public function searchResults_S()
    {
        return  $this->hasMany('App\Search_Result')->where('category','social');
    }

    /**
     * Get the search results for the search query for the category 'all'.
     * @return static
     */
    public function searchResults_I()
    {
        return  $this->hasMany('App\Search_Result')->where('category','images');
    }

    /**
     * Get the search results for the search query for the category 'all'.
     * @return static
     */
    public function searchResults_V()
    {
        return  $this->hasMany('App\Search_Result')->where('category','video');
    }

    /**
     * Get the search results for the search query for the category 'all'.
     * @return static
     */
    public function searchResults_D()
    {
        return  $this->hasMany('App\Search_Result')->where('category','document');
    }
}
