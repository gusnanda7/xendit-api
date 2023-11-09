<!DOCTYPE html>
<html>
<head>
    <title>Decode Base64</title>
</head>
<body>
    <input type="text" id="base64Input" placeholder="Masukkan string Base64">
    <button onclick="decodeBase64()">Dekode</button>
    <p id="decodedText"></p>
    <p id="decodedText2"></p>
    <p id="decodedText3"></p>

    <script>
        function decodeBase64() {
            const base64Input = document.getElementById('base64Input').value;
            const decodedData = document.getElementById('decodedText');
            const decodedData2 = document.getElementById('decodedText2');
            const decodedData3 = document.getElementById('decodedText3');

            // String Base64 yang diambil dari PHP
            var base64DataFromPHP = base64Input;

            // Mendekode Base64 menjadi string JSON
            var decodedJSON = atob(base64DataFromPHP);

            // Parse string JSON menjadi objek JavaScript
            var jsonData = JSON.parse(decodedJSON);
            

            var inputString = JSON.stringify(jsonData.data, null, 2);

            var iv = JSON.stringify(jsonData.iv, null, 2);

            var nqiv = iv.substring(1, iv.length - 1);

            var biv = stringToBinary(nqiv);

            var bin = hex2bin(inputString);
           
            var bbin = bagi256(bin);

            var result ='';

            for(i in bbin){
                if (bbin[i].length !== 256) {
                output1 = 'Masukkan string sepanjang 256 karakter.';
                return;
            }

            var part1 = bbin[i].substring(0, 128);
            var part2 = bbin[i].substring(128);
           
            for (var i = 0; i < 11; i++) {
                part1 = xnorBinary128BitStrings(part1, biv)
            }
            for (var i = 0; i < 11; i++) {
                part2 = xnorBinary128BitStrings(part2, biv)
            }
            var part = part1+part2

            var bkey = textToBinary256('tAik1j0YZCVsKThIeOL28NpRfW7r4Q5V');

            var btext = pengurangan(part, bkey);

            var hasil = binary256ToText(btext);

            if (result == '') {
                result = hasil;
            } else {
                result = result+hasil;
            }

            }

            //  // Mendekode Base64 menjadi string JSON
             var decodedJSON1 = atob(result);

            // // Parse string JSON menjadi objek JavaScript
            var result = JSON.parse(decodedJSON1);

            // const parts = inputString.split(delimiter);

            // Menampilkan data yang telah didekode

            decodedData.textContent = JSON.stringify(result, null, 2);
          
            // decodedData2.textContent = result;
            // decodedData3.textContent = JSON.stringify(result, null, 2);
        }

        function xnorBinary128BitStrings(binaryString1, binaryString2) {
            if (binaryString1.length !== 128 || binaryString2.length !== 128) {
                document.getElementById("result").textContent = "Binary strings must be 128 bits long.";
            } else {
                let result = '';

                for (let i = 0; i < 128; i++) {
                    if (binaryString1[i] == binaryString2[i]) {
                    hex = '0';
                    }else{
                            hex = '1';
                    }
                    if (result == '') {
                        result = hex;
                        }else{
                                result = result+hex;
                        } 
                }

                return result;
            }
        }

        function pengurangan(bin1, bin2){
            let result = '';
            let borrow = 0;

            for (let i = 255; i >= 0; i--) {
                let bit1 = parseInt(bin1[i]);
                let bit2 = parseInt(bin2[i]);

                let diff = bit1 - bit2 - borrow;

                if (diff < 0) {
                    diff += 2;
                    borrow = 1;
                } else {
                    borrow = 0;
                }

                result = diff + result;
            }

            return result;
        }

        function textToBinary256(text) {
        // Membuat instance TextEncoder
        var textEncoder = new TextEncoder();

        // Mengonversi teks ke UTF-8
        var utf8Array = textEncoder.encode(text);

        // Mengonversi UTF-8 ke biner dengan panjang 256 bit
        var binary = '';
        for (var i = 0; i < utf8Array.length; i++) {
            binary += utf8Array[i].toString(2).padStart(8, '0');
        }

        // Pastikan panjang biner adalah 256 bit
        if (binary.length < 256) {
            binary = binary.padEnd(256, '0');
        }

        return binary;
        }

        function binary256ToText(binary) {
        // Pastikan panjang biner adalah 256 bit
        if (binary.length !== 256) {
            return 'Panjang biner harus 256 bit';
        }

        // Mengonversi biner 256-bit ke UTF-8
        var utf8Array = [];
        for (var i = 0; i < 256; i += 8) {
            var byte = binary.substr(i, 8);
            if (byte == '00000000') {
                
            } else {
                utf8Array.push(parseInt(byte, 2));
            }
            
        }

        // Membuat instance TextDecoder
        var textDecoder = new TextDecoder();

        // Mengonversi UTF-8 ke teks
        var text = textDecoder.decode(new Uint8Array(utf8Array));

        return text;
        }

        function stringToBinary(text) {
         
            // Membuat instance TextEncoder
            var textEncoder = new TextEncoder();

            // Mengonversi teks ke UTF-8
            var utf8Array = textEncoder.encode(text);

            // Mengonversi UTF-8 ke biner dengan panjang 256 bit
            var binary = '';
            for (var i = 0; i < utf8Array.length; i++) {
                binary += utf8Array[i].toString(2).padStart(8, '0');
            }

            // Pastikan panjang biner adalah 256 bit
            if (binary.length < 128) {
                binary = binary.padEnd(128, '0');
            }

            return binary;
        }

        function xnor(binary1, binary2) {
            if (binary1.length !== binary2.length) {
                return "Panjang string biner harus sama.";
            }

            var result = '';
            for (var i = 0; i < binary1.length; i++) {
                if (binary1[i] === binary2[i]) {
                    result += '1'; // Bit yang sama
                } else {
                    result += '0'; // Bit yang berbeda
                }
            }

            return result;
        }

        function bagi256(data){
            if (data) {
                const chunkSize = 256;
                const chunks = [];

                for (let i = 0; i < data.length; i += chunkSize) {
                    const chunk = data.substring(i, i + chunkSize);
                    chunks.push(chunk);
                }

                output = chunks;
            } else {
                output = 'Masukkan string.';
            }
            return output;
        }

        function xorBinaryStrings(binary1, binary2) {
            if (binary1.length !== binary2.length) {
                return "Panjang string biner harus sama.";
            }

            let result = '';
            for (let i = 0; i < binary1.length; i++) {
                result += binary1[i] === binary2[i] ? '0' : '1';
            }

            return result;
        }

        function hex2bin(data){
            if (data) {
                let characters = [];
                for (let i = 0; i < data.length; i++) {
                    hasil = hex2binKamus(data[i]);
                    characters.push(hasil);
                }

                output = characters.join('');
            } else {
                output = 'Masukkan string.';
            }
            return output;
        }
       
        function hex2binKamus(indeks) {
        var bin;

        switch (indeks) {
            case '0':
                bin = "0000";
                break;
            case '1':
                bin = "0001";
                break;
            case '2':
                bin = "0010";
                break;
            case '3':
                bin = "0011";
                break;
            case '4':
                bin = "0100";
                break;
            case '5':
                bin = "0101";
                break;
            case '6':
                bin = "0110";
                break;
            case '7':
                bin = "0111";
                break;
            case '8':
                bin = "1000";
                break;
            case '9':
                bin = "1001";
                break;
            case 'A':
                bin = "1010";
                break;
            case 'B':
                bin = "1011";
                break;
            case 'C':
                bin = "1100";
                break;
            case 'D':
                bin = "1101";
                break;
            case 'E':
                bin = "1110";
                break;
            case 'F':
                bin = "1111";
                break;
            }
            return bin;
        }

        // var hariName = getHariName(indeksHari);

    </script>
</body>
</html>
