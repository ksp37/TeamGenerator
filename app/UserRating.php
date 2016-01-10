<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRating extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_ratings';
    
    public function score()
    {
        return $this->HasOne('App\Score', 'score_id', 'id');
    }
}
