<?php

namespace App\Models;

use App\Services\TaskService;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	const STATUS_LIVE = 'live';
	const STATUS_ARCHIVED = 'archived';

	const STATUSES = [
		self::STATUS_LIVE,
		self::STATUS_ARCHIVED,
	];

	public static $createRules = [
		'client_id' => ['required', 'string'],
		'name' => ['required', 'string', 'min:4', 'max:160'],
		'status' => ['required', 'in:live,archived'],
	];

	public static $updateRules = [
		'client_id' => ['required', 'string'],
		'name' => ['required', 'string', 'min:4', 'max:160'],
		'status' => ['required', 'in:live,archived'],
	];

	protected $collection = 'projects';
	protected $guarded = [];
	protected $hidden = ['deleted_at',];
	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
	];

	public static function getCollectionName()
	{
		return with(new static)->collection;
	}

	public function getRouteKeyName()
	{
		return 'fid';
	}

	public function save(array $options = [])
	{
		return null;
	}

	public function getTasksAttribute()
	{
		$taskService = resolve(TaskService::class);

		return $taskService->getTasks('project_id', false, ['equalTo' => $this->fid]);
	}
}

