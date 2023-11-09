<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class kategori extends Model
{
    use HasFactory;

    public function allData()
    {
        return DB::table('kategoris')->get();
    }
    public function detailData($id)
    {
        return DB::table('kategoris')->where('id_kategori', $id)->first();
    }
    public function addData($data)
    {
        DB::table('kategoris')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('kategoris')->where('id_kategori', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('kategoris')->where('id_kategori', $id)->delete();
    }
}
