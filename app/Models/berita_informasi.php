<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class berita_informasi extends Model
{
    public function allData()
    {
        return DB::table('berita_informasis')->get();
    }
    public function detailData($id)
    {
        return DB::table('berita_informasis')->where('id_berita_informasis', $id)->first();
    }
    public function addData($data)
    {
        DB::table('berita_informasis')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('berita_informasis')->where('id_berita_informasis', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('berita_informasis')->where('id_berita_informasis', $id)->delete();
    }
}
