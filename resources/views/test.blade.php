<!DOCTYPE html>
<html>
<head>
  <title>Konversi Teks ke Biner 256-bit dan Kembali</title>
</head>
<body>
  <script>

// Fungsi untuk mengonversi teks ke biner 256-bit (UTF-8)
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




// Fungsi untuk mengonversi biner 256-bit kembali ke teks (UTF-8)
function binary256ToText(binary) {
  // Pastikan panjang biner adalah 256 bit
  if (binary.length !== 256) {
    return 'Panjang biner harus 256 bit';
  }

  // Mengonversi biner 256-bit ke UTF-8
  var utf8Array = [];
  for (var i = 0; i < 256; i += 8) {
    var byte = binary.substr(i, 8);
    utf8Array.push(parseInt(byte, 2));
  }

  // Membuat instance TextDecoder
  var textDecoder = new TextDecoder();

  // Mengonversi UTF-8 ke teks
  var text = textDecoder.decode(new Uint8Array(utf8Array));

  return text;
}



    // Teks yang ingin diubah menjadi biner 256-bit
    var teksAsli = '"LQBlertrSnuHz9wP"';
    
    // Mengonversi teks ke biner 256-bit
    var biner256 = textToBinary256(teksAsli);

    // Mengonversi biner 256-bit kembali ke teks
    var teksKembali = binary256ToText(biner256);

    console.log('Teks Asli: ' + teksAsli);
    console.log('Teks dalam bentuk biner (256 bit): ' + biner256);
    console.log('Teks Kembali: ' + teksKembali);
  </script>
</body>
</html>
