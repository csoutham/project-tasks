<?php

namespace App\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
	use SoftDeletes, GeneratesUuid;

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

    protected $table = 'clients';
    
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
    
    public function projects() {
    	return $this->hasMany('App\Models\Project');
    }
}

