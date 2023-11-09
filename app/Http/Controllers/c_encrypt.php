<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class c_encrypt extends Controller
{
    public function __construct()
    {
        $this->key = 'tAik1j0YZCVsKThIeOL28NpRfW7r4Q5V';
    }

    public function encode($data)
    {
        $json = base64_encode(json_encode($data, JSON_UNESCAPED_SLASHES));
        return $this->encrypt($json);
    }
    public function encrypt($data)
    {
        $iv = $this->generateRandomString(16);
        $biv = $this->stringtobiner2($iv);
        $key = $this->stringtobiner($this->key);
        $text = $this->splitStringInto32Characters($data);
        
        $hasil = [];
        foreach ($text as $item) {
            $bin = $this->stringtobiner($item);
            // return $bin;
            $tambah = $this->addBinary256Bit($bin, $key);
            
            list($part1, $part2) = $this->splitStringIntoTwo($tambah);
            
            $test = $tambah;

            for ($i=0; $i < 11; $i++) { 
                $part1 = $this->xorBinary128BitStrings($part1, $biv);
            }
            for ($i=0; $i < 11; $i++) { 
                $part2 = $this->xorBinary128BitStrings($part2, $biv);
            }
            $result = $part1.$part2;

            $hasil[]=$result;
        }
       
        $akhir = '';
        foreach ($hasil as $isi) {
            if ($akhir == '') {
                $akhir = $isi;
            } else {
                $akhir = $akhir.$isi;
            }
        }
        $hexString = $this->bin2hex($akhir);

        $data = ['iv' => $iv,
                 'data' => $hexString];
        $json = base64_encode(json_encode($data, JSON_UNESCAPED_SLASHES));    
        return $json;
    }

    function bin2hex($data)
    {
        $var = $this->splitStringIntoArray($data, 4);
        $result = '';
        foreach ($var as $item) {
           $hex = $this->bin2hexkamus($item);
           if ($result == '') {
                $result = $hex;
           }else{
                $result = $result.$hex;
           }
        }
        return $result;
    }

    function bin2hexkamus($data)
        {
            switch ($data) {
                case '0000':
                    $hex = '0';
                    break;
                case '0001':
                    $hex = '1';
                    break;
                case '0010':
                    $hex = '2';
                    break;
                case '0011':
                    $hex = '3';
                    break;
                case '0100':
                    $hex = '4';
                    break;
                case '0101':
                    $hex = '5';
                    break;
                case '0110':
                    $hex = '6';
                    break;
                case '0111':
                    $hex = '7';
                    break;
                case '1000':
                    $hex = '8';
                    break;
                case '1001':
                    $hex = '9';
                    break;
                case '1010':
                    $hex = 'A';
                    break;
                case '1011':
                    $hex = 'B';
                    break;
                case '1100':
                    $hex = 'C';
                    break;
                case '1101':
                    $hex = 'D';
                    break;
                case '1110':
                    $hex = 'E';
                    break;
                case '1111':
                    $hex = 'F';
                    break;
            }
            return $hex;
        }

    function xnorBinary128BitStrings($binaryString1, $binaryString2) {
        // Pastikan kedua string memiliki panjang yang sama (128 bit)
        if (strlen($binaryString1) != 128 || strlen($binaryString2) != 128) {
            return "Panjang string biner harus 128 bit.";
        }
    
        $result = '';
        
        for ($i = 0; $i < 128; $i++) {
            // XNOR setiap bit dan tambahkan hasilnya ke hasil
            $result .= ($binaryString1[$i] == $binaryString2[$i]) ? '1' : '0'; // Kita menggunakan '1' jika sama, '0' jika berbeda
        }
    
        return $result;
    }  

    function xorBinary128BitStrings($binaryString1, $binaryString2) {
        // Pastikan kedua string memiliki panjang yang sama (128 bit)
        if (strlen($binaryString1) != 128 || strlen($binaryString2) != 128) {
            return "Panjang string biner harus 128 bit.";
        }

        $var = $this->splitStringIntoArray($binaryString1, 1);
        $var1 = $this->splitStringIntoArray($binaryString2, 1);
        $result = '';
        for ($i=0; $i < 128 ; $i++) { 
            if ($var[$i] == $var1[$i]) {
                $hex = '0';
           }else{
                $hex = '1';
           }
           if ($result == '') {
            $result = $hex;
            }else{
                    $result = $result.$hex;
            }
        }
        return $result;
    }

    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
    
        return $randomString;
    }

    function splitStringIntoTwo($inputString) {
        if (strlen($inputString) != 256) {
            return "String input harus memiliki panjang 256 karakter.";
        }
    
        $part1 = substr($inputString, 0, 128);
        $part2 = substr($inputString, 128, 128);
    
        return array($part1, $part2);
    }

    function stringtobiner($text)
    {
        // Mengonversi teks ke UTF-8
        $utf8 = mb_convert_encoding($text, 'UTF-8');
    
        // Mengonversi UTF-8 ke biner dengan panjang 256 bit
        $binary = '';
        $len = strlen($utf8);
        for ($i = 0; $i < $len; $i++) {
            $binary .= str_pad(decbin(ord($utf8[$i])), 8, '0', STR_PAD_LEFT);
        }
    
        // Pastikan panjang biner adalah 256 bit
        if (strlen($binary) < 256) {
            $binary = str_pad($binary, 256, '0', STR_PAD_RIGHT);
        }

        $hasil = $binary;
    
        return $hasil; 
    }
    function splitStringIntoArray($inputString, $chunkSize) {
        $inputLength = strlen($inputString);
        $result = [];
    
        for ($i = 0; $i < $inputLength; $i += $chunkSize) {
            $chunk = substr($inputString, $i, $chunkSize);
            $result[] = $chunk;
        }
    
        return $result;
    }
    function stringtobiner2($text)
     {
         // Mengonversi teks ke UTF-8
         $utf8 = mb_convert_encoding($text, 'UTF-8');
    
         // Mengonversi UTF-8 ke biner dengan panjang 256 bit
         $binary = '';
         $len = strlen($utf8);
         for ($i = 0; $i < $len; $i++) {
             $binary .= str_pad(decbin(ord($utf8[$i])), 8, '0', STR_PAD_LEFT);
         }
     
         // Pastikan panjang biner adalah 256 bit
         if (strlen($binary) < 128) {
             $binary = str_pad($binary, 128, '0', STR_PAD_RIGHT);
         }
 
         $hasil = $binary;
     
         return $hasil; 
    }
    

    function binary256BitToString($binaryString) {
        if (strlen($binaryString) % 8 != 0) {
            return strlen($binaryString);
        }
    
        $textString = '';
        $binaryArray = str_split($binaryString, 8);
    
        foreach ($binaryArray as $binaryChar) {
            $textString .= chr(bindec($binaryChar));
        }
    
        return $textString;
    }

    function splitStringInto32Characters($inputString) {
        $result = [];
        $stringLength = strlen($inputString);
        
        for ($i = 0; $i < $stringLength; $i += 32) {
            $segment = substr($inputString, $i, 32);
            $result[] = $segment;
        }
        
        return $result;
    }

    function addBinary256Bit($binary1, $binary2) {
        $result = '';
        $carry = 0;
        
        for ($i = 255; $i >= 0; $i--) {
            $bit1 = (int)$binary1[$i];
            $bit2 = (int)$binary2[$i];
            
            $sum = $bit1 + $bit2 + $carry;
            
            $result = ($sum % 2) . $result;
            
            $carry = (int)($sum / 2);
        }
        
        return $result;
    }
}
