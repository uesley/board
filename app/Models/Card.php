<?php

namespace App\Models;

use App\User;
use App\Constants\CardTypes;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Card extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'board_list_id',
		'number',
		'team_id',
		'board_id',
		'user_story_id',
		'title',
		'link',
		'position',
		'members',
		'labels',
		'backlog_labels',
		'acceptance_criteria',
		'artifacts',
		'checklist',
		'type',
		'workspace_id',
		'description',
		'rating',
		'bimester_goal',
		'is_recurrent',
		'is_technical_work',
		'user_id',
		'estimated',
		'status',
	];

	protected $appends = ['id', 'is_user_story', 'is_not_prioritized', 'is_task'];
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

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function userStory()
	{
		return $this->belongsTo('App\Models\Card');
	}

	public function board()
	{
		return $this->belongsTo('App\Models\Board');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function getIsUserStoryAttribute()
	{
		return $this->type === CardTypes::USER_STORY;
	}

	public function getIsTaskAttribute()
	{
		return $this->type === CardTypes::TASK;
	}

	public function getIsNotPrioritizedAttribute()
	{
		return $this->type === CardTypes::NOT_PRIORITIZED;
	}
}
