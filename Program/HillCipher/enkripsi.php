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

// Fungsi membagi setiap kode ASCII menjadi matriks array 2d
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

// Fungsi untuk mengubah matriks array 2d ke array satu dimensi
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

// Fungsi mencari determinan
function determinannnn($key)
{
  return (
    $key[0][0] * $key[1][1] * $key[2][2] +
    $key[0][1] * $key[1][2] * $key[2][0] +
    $key[0][2] * $key[1][0] * $key[2][1] -
    ($key[2][0] * $key[1][1] * $key[0][2] +
      $key[2][1] * $key[1][2] * $key[0][0] +
      $key[2][2] * $key[1][0] * $key[0][1])
  );
}

//Fungsi untuk mencari kofaktor kunci
function kofaktort($key)
{
  $hasilKofaktor = [];
  for ($i = 0; $i < 3; $i++) {
    $hasilKofaktor[$i] = [];
  }
  $a = $key[1][1] * $key[2][2] - $key[2][1] * $key[1][2];
  $b = - ($key[1][0] * $key[2][2] - $key[2][0] * $key[1][2]);
  $c = $key[1][0] * $key[2][1] - $key[2][0] * $key[1][1];
  $d = - ($key[0][1] * $key[2][2] - $key[2][1] * $key[0][2]);
  $e = $key[0][0] * $key[2][2] - $key[2][0] * $key[0][2];
  $f = - ($key[0][0] * $key[2][1] - $key[2][0] * $key[0][1]);
  $g = $key[0][1] * $key[1][2] - $key[1][1] * $key[0][2];
  $h = - ($key[0][0] * $key[1][2] - $key[1][0] * $key[0][2]);
  $i = $key[0][0] * $key[1][1] - $key[1][0] * $key[0][1];

  $hasilKofaktor[0][0] = $a;
  $hasilKofaktor[0][1] = $b;
  $hasilKofaktor[0][2] = $c;
  $hasilKofaktor[1][0] = $d;
  $hasilKofaktor[1][1] = $e;
  $hasilKofaktor[1][2] = $f;
  $hasilKofaktor[2][0] = $g;
  $hasilKofaktor[2][1] = $h;
  $hasilKofaktor[2][2] = $i;
  return $hasilKofaktor;
}

// Fungsi mencari hasil Adjoin dari kunci. Adjoin = (transpose hasil konfaktor kunci)
function adjoinn($kofaktor)
{
  $hasilAdj = [];
  for ($i = 0; $i < 3; $i++) {
    $hasilAdj[$i] = [];
    for ($j = 0; $j < 3; $j++) {
      $hasilAdj[$i][$j] = $kofaktor[$j][$i];
    }
  }
  return $hasilAdj;
}

// Fungsi untuk mencari N? x N? di mod 128 hasilnya 1 (Menggunakan Algoritma Euclidean)
function findModuloResult($a, $m)
{

  list($gcd, $x, $y) = gcdExtended($a, $m);

  if ($gcd !== 1) {
    return -1; // Nilai -1 untuk menunjukkan bahwa solusi tidak ada
  } else {
    // Pastikan $x positif
    if ($x < 0) {
      $x += $m;
    }

    return $x; // Kembalikan nilai $x sebagai angka
  }
}


// membuat fungsi enkripsi HillCipher
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
}