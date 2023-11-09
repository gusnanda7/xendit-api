<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fasilitas;
use App\Http\Controllers\c_encrypt;


class c_fasilitas extends Controller
{
    public function __construct(c_encrypt $encrypt)
    {
        $this->fasilitas = new fasilitas();
        $this->encrypt = $encrypt;
    }

    public function id($data){
        foreach ($data as $item) {
            $item->id_fasilitas = encrypt($item->id_fasilitas);
        }
        return $data;
    }
   
    public function get()
    {
        $fasilitas = $this->fasilitas->allData();
        // return $fasilitas;
        $data = ['fasilitas' => $this->id($fasilitas)];
        return $this->encrypt->encode($data);
    }
    public function store(Request $request)
    {
        $data = ['fasilitas' => $request->fasilitas];
        $this->fasilitas->addData($data);
        return response(['message' => 'fasilitas Berhasil Dibuat'], 201);
    }
    public function show($id)
    {
        $did = decrypt($id);
        $fasilitas = $this->fasilitas->detailData($did);
        $fasilitas->id_fasilitas =  encrypt($fasilitas->id_fasilitas);
        $data = ['fasilitas' => $fasilitas];
        return $this->encrypt->encode($data);
    }
    public function put(Request $request, $id)
    {
        $did = decrypt($id);
        $data = ['fasilitas' => $request->fasilitas];
        $this->fasilitas->editData($did, $data);
        return response(['message' => 'fasilitas Berhasil Diubah'], 201);
    }
    public function delete($id)
    {
        $did = decrypt($id);
        $this->fasilitas->deleteData($did);
        return response(['message' => 'fasilitas Berhasil Dihapus'], 201);
    }
}
