<?php
$kunci = [
    [21, 31, 23],
    [1, 4, 5],
    [3, 7, 78],
];


// Fungsi merubah plaintext ke kode ASCII
function textToAscii($plaintext)
{
    $result = [];
    for ($i = 0; $i < strlen($plaintext); $i++) {
        $charCode = ord($plaintext[$i]);
        $result[] = $charCode;
    }
    return $result;
}

// Fungsi membagi setiap kode ASCII menjadi matriks
function bagiBlok($arr, $baris, $kolom)
{
  $matrix = [];
  $index = 0;
  for ($i = 0; $i < $baris; $i++) {
    $barisBaru = [];
    for ($j = 0; $j < $kolom; $j++) {
      if ($index < count($arr)) {
        $barisBaru[] = $arr[$index];
        $index++;
      } else {
        $barisBaru[] = null;
      }
    }
    $matrix[] = $barisBaru;
  }
  return $matrix;
}