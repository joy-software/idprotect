<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Profile
 *
 * @property int $id
 * @property int $p_name
 * @property int|null $p_email
 * @property int|null $p_nickname
 * @property int|null $p_profession
 * @property int|null $p_occupation
 * @property int|null $p_avatar
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile wherePAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile wherePEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile wherePName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile wherePNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile wherePOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile wherePProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereUserId($value)
 * @mixin \Eloquent
 */
class Profile extends Model
{
    protected $table = 'profile';

    protected $guarded = ['id','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
