<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
	use HasFactory;

	protected $fillable = [
		"name",
		"created_at",
		"updated_at",
		"expired_at",
		"deleted_at",
		"user_id",
	];

	public function getActiveListByUser($userId){
		return $this->where('user_id', $userId)
								->whereNull('deleted_at')
								->orderBy('created_at', 'desc')
								->get();
	}
}
