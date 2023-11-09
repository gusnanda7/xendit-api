<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class pembayaran extends Model
{
    use HasFactory;

    function addData($data){
        DB::table('pembayarans')->insert($data);
    }
    function editData($id, $data)
    {
        DB::table('pembayarans')->where('external_id', $id)->update($data);
    }
}
