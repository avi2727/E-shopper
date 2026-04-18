<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use Hasfactory;
    public function getStudent()
    {
       $result=  DB::table('users')->get();
       return $result;

    }
    public function addStudent($data)
    {
       $result=  DB::table('students')->insert($data);
       return $result;

    }
    public function deleteData($id)
    {
       $result=  DB::table('students')->where('id',$id)->delete();
       return $result;

    }
    public function editData($id)
    {
       $result=  DB::table('students')->where('id',$id)->first();
       dd($result);
       return $result;

    }
    public function updateStudent($id,$data)
    {
       $result=  DB::table('students')->where('id', $id)->update($data);
       return $result;

    }
  

}
