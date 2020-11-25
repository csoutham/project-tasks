<?php

namespace App\Models;

use App\Services\ProjectService;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	const STATUS_LIVE = 'live';
	const STATUS_ARCHIVED = 'archived';

	const STATUSES = [
		self::STATUS_LIVE,
		self::STATUS_ARCHIVED,
	];

	public static $createRules = [
		'name' => ['required', 'string', 'min:4', 'max:160'],
		'status' => ['required', 'in:live,archived'],
	];

	public static $updateRules = [
		'name' => ['required', 'string', 'min:4', 'max:160'],
		'status' => ['required', 'in:live,archived'],
	];

	protected $collection = 'clients';
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

	public function getProjectsAttribute()
	{
		$projectService = resolve(ProjectService::class);

		return $projectService->getProjects('client_id', false, ['equalTo' => $this->fid]);
	}
}

