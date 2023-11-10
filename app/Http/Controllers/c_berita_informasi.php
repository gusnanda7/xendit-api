<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\berita_informasi;
use App\Http\Controllers\c_encrypt;
use Auth;


class c_berita_informasi extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->berita_informasi = new berita_informasi();
        $this->encrypt = $encrypt;
    }

    public function id($data){
        foreach ($data as $item) {
            $item->id_berita_informasi = encrypt($item->id_berita_informasi);
        }
        return $data;
    }
   
    public function get()
    {
        $berita_informasi = $this->berita_informasi->allData();
        $data = ['berita_informasi' => $this->id($berita_informasi)];
        return $this->encrypt->encode($data);
    }
    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        $d = date("Y-m-d");
        $file  = $request->gambar;
        $filename = $request->judul.'_'.$d.'_'.Auth::user()->id.'.'.$file->extension();
        $file->move(public_path('gambar'),$filename);
        $data = [
            'judul' => $request->judul,
            'id_user' => Auth::user()->id,
            'gambar' => $filename,
            'isi' => $request->isi,
            'status_berita_informasi' => 'Aktif',
            'jenis' => $request->jenis];
        $this->berita_informasi->addData($data);
        return response(['message' => 'berita_informasi Berhasil Dibuat'], 201);
    }
    public function show($id)
    {
        $did = decrypt($id);
        $berita_informasi = $this->berita_informasi->detailData($did);
        $berita_informasi->id_berita_informasi =  encrypt($berita_informasi->id_berita_informasi);
        $data = ['berita_informasi' => $berita_informasi];
        return $this->encrypt->encode($data);
    }
    public function put(Request $request, $id)
    {
        $did = decrypt($id);
        if ($request->gambar <> null) {
            $berita_informasi = $this->berita_informasi->detailData($did);
            unlink(public_path('gambar'). '/' .$berita_informasi->gambar);
            date_default_timezone_set("Asia/Jakarta");
            $d = date("Y-m-d");
            $file  = $request->gambar;
            $filename = $request->judul.'_'.$d.'_'.Auth::user()->id.'.'.$file->extension();
        }
        $data = [
            'judul' => $request->judul,
            'id_user' => Auth::user()->id,
            'isi' => $request->isi,
            'jenis' => $request->jenis];
        $this->berita_informasi->editData($did, $data);
        return response(['message' => 'berita_informasi Berhasil Diubah'], 201);
    }
    public function aktif($id)
    {
        $did = decrypt($id);
        $data = [
            'status_berita_informasi' => 'Aktif',
            'id_user' => Auth::user()->id,];
        $this->berita_informasi->editData($did, $data);
        return response(['message' => 'berita_informasi Berhasil Diaktifkan'], 201);
    }
    public function nonaktif($id)
    {
        $did = decrypt($id);
        $data = [
            'status_berita_informasi' => 'Tidak Aktif',
            'id_user' => Auth::user()->id,];
        $this->berita_informasi->editData($did, $data);
        return response(['message' => 'berita_informasi Berhasil Di Non Aktifkan'], 201);
    }
    public function delete($id)
    {
        $did = decrypt($id);
        $berita_informasi = $this->berita_informasi->detailData($did);
        unlink(public_path('gambar'). '/' .$berita_informasi->gambar);
        $this->berita_informasi->deleteData($did);
        return response(['message' => 'berita_informasi Berhasil Dihapus'], 201);
    }
}
