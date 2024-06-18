<?php
$kunci = [
  [21, 31, 23],
  [1, 4, 5],
  [3, 7, 78],
];


// Fungsi merubah plaintext ke kode ASCII
function textToAsciii($plaintext)
{
  $result = [];
  for ($i = 0; $i < strlen($plaintext); $i++) {
    $charCode = ord($plaintext[$i]);
    $result[] = $charCode;
  }
  return $result;
}



// Fungsi untuk mengubah matriks ke array satu dimensi
function matrixTo1DArrayy($matrix)
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
function asciiToTextt($asciiArray)
{
  $result = "";
  for ($i = 0; $i < count($asciiArray); $i++) {
    $char = chr($asciiArray[$i]);
    $result .= $char;
  }
  return $result;
}


// Fungsi membagi setiap kode ASCII menjadi matriks
function bagiBlokk($arr, $baris, $kolom)
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

// Fungsi untuk menghitung gcd($a, $m) menggunakan Algoritma Euclidean
function gcdExtended($a, $b)
{
  if ($a === 0) {
    return [$b, 0, 1];
  }

  list($gcd, $x1, $y1) = gcdExtended($b % $a, $a);

  $x = $y1 - floor($b / $a) * $x1;
  $y = $x1;

  return [$gcd, $x, $y];
}

// Fungsi mencari N x N di mod 128 hasilnya 1 (Algoritma Euclidean)
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

function kaliDekrip($ciper, $invers)
{
  $hasil = [];
  for ($i = 0; $i < count($ciper); $i++) {
    $hasil[$i] = [];
    for ($j = 0; $j < count($invers); $j++) {
      $sum = 0;
      for ($k = 0; $k < count($invers); $k++) {
        $sum += $ciper[$i][$k] * $invers[$j][$k];
      }
      $hasil[$i][$j] = $sum;
    }
  }
  return $hasil;
}



//fungsi memodulus hasil kali (cipher x invers)
function modDekrip($dekripSementara)
{
  $hasil = [];
  for ($i = 0; $i < count($dekripSementara); $i++) {
    $hasil[$i] = [];
    for ($j = 0; $j < 3; $j++) {
      if ($dekripSementara[$i][$j] < 0) {
        $value = $dekripSementara[$i][$j];
        $modulus = 128;
        $hasil[$i][$j] = (($value % $modulus) + $modulus) % $modulus;
      } else {
        $hasil[$i][$j] = $dekripSementara[$i][$j] % 128;
      }
    }
  }
  return $hasil;
}


// Fungsi mengalikan hasil persamaan modulo dengan adjoin
function modAdj($determinanMod, $adjoin)
{
  $hasil = [];
  for ($i = 0; $i < count($adjoin); $i++) {
    $hasil[$i] = [];
    for ($j = 0; $j < count($adjoin); $j++) {
      $hasil[$i][$j] = ($adjoin[$i][$j] * $determinanMod) % 128;
    }
  }
  return $hasil;
}


function DekripsiHillCipher($cipertext, $kunci)
{

  $AngkaText = textToAsciii($cipertext);
  if (count($AngkaText) % 3 == 1) {
    $AngkaText[] = 0;
    $AngkaText[] = 0;
  } elseif (count($AngkaText) % 3 == 2) {
    $AngkaText[] = 0;
  }
  $hslDeterminan = determinannnn($kunci);
  $modDeterminan = $hslDeterminan % 128;
  $konv = kofaktort($kunci);
  $adj = adjoinn($konv);
  $modDet = findModuloResult($modDeterminan, 128);
  $hslInvers = modAdj($modDet, $adj);
  $blokMatrik = bagiBlokk($AngkaText, count($AngkaText) / 3, 3);
  $dekripSementara = kaliDekrip($blokMatrik, $hslInvers);
  $arraySatuDimensi = matrixTo1DArrayy(modDekrip($dekripSementara));
  $plaintextDariAscii = asciiToTextt($arraySatuDimensi);
  return $plaintextDariAscii;
}
