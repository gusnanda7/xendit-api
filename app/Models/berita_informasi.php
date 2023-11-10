<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class berita_informasi extends Model
{
    public function allData()
    {
        return DB::table('berita_informasis')->selectRaw('id_berita_informasi, judul, gambar, isi, jenis, status_berita_informasi as status, name')->join('users', 'users.id', '=', 'berita_informasis.id_user')->get();
    }
    public function detailData($id)
    {
        return DB::table('berita_informasis')->select('*', 'status_berita_informasi as status')->where('id_berita_informasi', $id)->first();
    }
    public function addData($data)
    {
        DB::table('berita_informasis')->insert($data);
    }
    public function editData($id, $data)
    {
        DB::table('berita_informasis')->where('id_berita_informasi', $id)->update($data);
    }
    public function deleteData($id)
    {
        DB::table('berita_informasis')->where('id_berita_informasi', $id)->delete();
    }
}
