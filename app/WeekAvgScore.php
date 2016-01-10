<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeekAvgScore extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'week_avg_scores';
    
    public function score()
    {
        return $this->HasOne('App\Score', 'score_id', 'id');
    }
}
