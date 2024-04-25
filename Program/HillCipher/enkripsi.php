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
