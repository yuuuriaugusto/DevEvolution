<?php
function calculaMedia($nota1, $nota2, $nota3) {
    $mediaFinal = ($nota1 + $nota2 + $nota3)/3;
    return $mediaFinal;
}

$media = calculaMedia(10, 15, 20);

echo "Media final: $media\n";
?>