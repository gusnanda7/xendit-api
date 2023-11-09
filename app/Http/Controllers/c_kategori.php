<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategori;
use App\Http\Controllers\c_encrypt;


class c_kategori extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->kategori = new kategori();
        $this->encrypt = $encrypt;
    }

    public function id($data){
        foreach ($data as $item) {
            $item->id_kategori = encrypt($item->id_kategori);
        }
        return $data;
    }
   
    public function get()
    {
        $kategori = $this->kategori->allData();
        // return $kategori;
        $data = ['kategori' => $this->id($kategori)];
        return $this->encrypt->encode($data);
    }
    public function store(Request $request)
    {
        $data = ['kategori' => $request->kategori];
        $this->kategori->addData($data);
        return response(['message' => 'Kategori Berhasil Dibuat'], 201);
    }
    public function show($id)
    {
        $did = decrypt($id);
        $kategori = $this->kategori->detailData($did);
        $kategori->id_kategori =  encrypt($kategori->id_kategori);
        $data = ['kategori' => $kategori];
        return $this->encrypt->encode($data);
    }
    public function put(Request $request, $id)
    {
        $did = decrypt($id);
        $data = ['kategori' => $request->kategori];
        $this->kategori->editData($did, $data);
        return response(['message' => 'Kategori Berhasil Diubah'], 201);
    }
    public function delete($id)
    {
        $did = decrypt($id);
        $this->kategori->deleteData($did);
        return response(['message' => 'Kategori Berhasil Dihapus'], 201);
    }
}
