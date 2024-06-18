<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;

class InsertController extends Controller
{
	protected $todolist;

	public function __construct(Todolist $todolist){
			$this->todolist = $todolist;
	}

	public function read(){
		try{
			$userId = auth()->id();
			
			$activeTodos  = $this->todolist->getActiveListByUser($userId);
			return response()->json([
				"success"	=> true,
				"message"	=> "Data read successfully",
				"data"		=> $activeTodos,
			]);
		}catch(\Exception $e){
			return response()->json([
				"success"	=> false,
				"message"	=> "Failed to read data",
				"error"		=> $e->getMessage(),
			], 500);
		}
	}

	public function insert(Request $req){
		try{
			$data = array(
				"name"				=> strip_tags($req["name"]),
				"created_at"	=> date("Y-m-d H:i:s"),
				"updated_at"	=> date("Y-m-d H:i:s"),
				"expired_at"	=> null,
				"deleted_at"	=> null,
				"user_id"			=> auth()->id(),
			);
			$insert = Todolist::create($data);
			return response()->json([
				"success"	=> true,
				"message"	=> "Data saved successfully",
				"data"		=> $insert,
			]);
		}catch(\Exception $e){
			return response()->json([
				"success"	=> false,
				"message"	=> "Failed to save data",
				"error"		=> $e->getMessage(),
			], 500);
		}
	}

	public function update(Request $req){
		try{
			$data = array(
				"updated_at"	=> date("Y-m-d H:i:s"),
				"expired_at"	=> $req["expired"] ? null : date("Y-m-d H:i:s"),
			);
			$update = Todolist::where('id', $req['id'])->update($data);
			return response()->json([
				"success"	=> true,
				"message"	=> "Data updated successfully",
				"data"		=> $update,
			]);
		}catch(\Exception $e){
			return response()->json([
				"success"	=> false,
				"message"	=> "Failed to update data",
				"error"		=> $e->getMessage(),
			], 500);
		}
	}

	public function delete(Request $req){
		try{
			$userId = auth()->id();
			$data = array(
				"updated_at"	=> date("Y-m-d H:i:s"),
				"deleted_at"	=> date("Y-m-d H:i:s"),
			);
			$update = Todolist::where('id', $req['id'])->update($data);
			return response()->json([
				"success"	=> true,
				"message"	=> "Data deleted successfully",
				"data"		=> $update,
			]);
		}catch(\Exception $e){
			return response()->json([
				"success"	=> false,
				"message"	=> "Failed to delete data",
				"error"		=> $e->getMessage(),
			], 500);
		}
	}

}
