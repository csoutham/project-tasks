<?php

namespace App\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;

class Task extends Model
{
	use SoftDeletes, GeneratesUuid, HasTags;

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
		'title' => ['required', 'string', 'min:4', 'max:160'],
		'description' => ['required', 'string', 'min:4'],
		'status' => ['required', 'in:draft,backlog,progress,review,completed,archived'],
	];

	public static $updateRules = [
		'title' => ['required', 'string', 'min:4', 'max:160'],
		'description' => ['required', 'string', 'min:4'],
        'status' => ['required', 'in:draft,backlog,progress,review,completed,archived'],
	];

    protected $table = 'tasks';
    
	protected $uuidVersion = 'ordered';
	
	protected $guarded = [
	    //
	];
	
	protected $hidden = [
		'deleted_at',
	];

    protected $casts = [
        //
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

	public function getRouteKeyName()
	{
		return 'uuid';
	}

	public function scopeFilterBy($query, $column, $value)
    {
        if ((is_null($value) || empty($value)) && $value !== '0') {
            return $query;
        }

        return $query->where($column, $value);
    }

    public function scopeSearchableProperties($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where('name', 'like', '%' . $search . '%');
    }
}

