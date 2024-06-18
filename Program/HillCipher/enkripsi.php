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



// Fungsi untuk mengubah matriks ke array satu dimensi
function matrixTo1DArray($matrix)
{
  $result = [];
  for ($i = 0; $i < count($matrix); $i++) {
    for ($j = 0; $j < count($matrix[$i]); $j++) {
      $result[] = $matrix[$i][$j];
    }
  }
  return $result;
}

// Fungsi untuk mengembalikan teks dari kode ASCII
function asciiToText($asciiArray)
{
  $result = "";
  for ($i = 0; $i < count($asciiArray); $i++) {
    $char = chr($asciiArray[$i]);
    $result .= $char;
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

// Fungsi mengalikan sekaligus memodulo kunci dengan plaintext yang sudah dibagi per 3 bagian
function perkalian($blok, $key)
{
  $hasil = [];
  for ($i = 0; $i < count($blok); $i++) {
    $hasil[$i] = [];
    for ($j = 0; $j < count($key); $j++) {
      $sum = 0;
      for ($k = 0; $k < count($key); $k++) {
        $sum += $blok[$i][$k] * $key[$j][$k];
      }
      $hasil[$i][$j] = $sum % 128;
    }
  }
  return $hasil;
}



function enkripsiHillCipher($plaintext, $kunci)
{

  $textAngka = textToAscii($plaintext);

  // Penyesuaian jika plaintext tidak bisa dibagi 3
  if (count($textAngka) % 3 == 1) {
    $textAngka[] = 0;
    $textAngka[] = 0;
  } elseif (count($textAngka) % 3 == 2) {
    $textAngka[] = 0;
  }
  $blokMatrik = bagiBlok($textAngka, count($textAngka) / 3, 3);
  $hasilKali = perkalian($blokMatrik, $kunci);
  $arraySatuDimensi = matrixTo1DArray($hasilKali);
  $plaintextDariAscii = asciiToText($arraySatuDimensi);
  return $plaintextDariAscii;
} //Penutup Fungsi pusat
