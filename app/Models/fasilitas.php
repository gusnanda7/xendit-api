<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class fasilitas extends Model
{
    use HasFactory;

    public function allData()
    {
        return DB::table('fasilitas')->get();
    }
    public function detailData($id)
    {
        return DB::table('fasilitas')->where('id_fasilitas', $id)->first();
    }
    public function addData($data)
    {
        DB::table('fasilitas')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('fasilitas')->where('id_fasilitas', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('fasilitas')->where('id_fasilitas', $id)->delete();
    }
}
