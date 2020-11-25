<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	const STATUS_DRAFT = 'draft';
	const STATUS_BACKLOG = 'backlog';
	const STATUS_PROGRESS = 'progress';
	const STATUS_REVIEW = 'review';
	const STATUS_COMPLETED = 'completed';
	const STATUS_ARCHIVED = 'archived';

	const STATUSES = [
		self::STATUS_DRAFT,
		self::STATUS_BACKLOG,
		self::STATUS_PROGRESS,
		self::STATUS_REVIEW,
		self::STATUS_COMPLETED,
		self::STATUS_ARCHIVED,
	];

	public static $createRules = [
		'project_id' => ['required', 'string'],
		'title' => ['required', 'string', 'min:4', 'max:160'],
		'description' => ['required', 'string', 'min:4'],
		'status' => ['required', 'in:draft,backlog,progress,review,completed,archived'],
	];

	public static $updateRules = [
		'project_id' => ['required', 'string'],
		'title' => ['required', 'string', 'min:4', 'max:160'],
		'description' => ['required', 'string', 'min:4'],
		'status' => ['required', 'in:draft,backlog,progress,review,completed,archived'],
	];

	protected $collection = 'tasks';
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
}

