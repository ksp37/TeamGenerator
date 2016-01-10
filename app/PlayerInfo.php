<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerInfo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'player_info';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    
    public function weeklyRatings()
    {
        return $this->HasMany('App\UserRating', 'player_id', 'id');
    }
}
