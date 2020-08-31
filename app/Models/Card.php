<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


class Card extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'board_list_id',
        'team_id',
        'board_id',
        'user_story_id',
        'title',
        'link',
        'position',
        'members',
        'labels'
    ];
    protected $appends = ['id'];
    protected $hidden = ['_id', 'board_list']; //esse segundo n sei como parar de mandar a parada kkk

    //relacionamento com members????????
    //relacionamento com labels????????
    
    public function boardList()
    {
        return $this->belongsTo('App\Models\BoardList');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }

    public function userStory()
    {
        return $this->belongsTo('App\Models\Card');
    }

    public function board()
    {
        return $this->belongsTo('App\Models\Board');
    }
}