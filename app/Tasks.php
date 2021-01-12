<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tasks extends Model
{
    protected $fillable = [
        "subject" , "description" , "category_id" ,"subcategory_id","usernote", "status_id", "company_id", "developer_id", "user_id"
    ];

     function get_status($status_id){

     	switch ($status_id) {
     		case 1:
     			return array('name' => 'Completed', 'color' => 'green');
     			break;

     		case 2:
     			return array('name' => 'Doing', 'color' => 'blue');
     			break;

     		case 3:
     			return array('name' => 'Pending', 'color' => 'red');
     			break;		
     		
     		default:
     			// code...
     			break;
     	}


     }

     function get_developer($id, $onlyname=true){
        $developer = DB::table('developers')->where('id', '=', $id)->first();
        if ($onlyname) {
            return $developer ? "$developer->firstname $developer->lastname" : 'Not Found';
        }else{
            return $developer ? $developer : 'Not Found';
        }

     }
}
