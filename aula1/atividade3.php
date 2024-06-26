<?php
function verificaIntervalo($numero) {
    return $numero >= 10 && $numero <= 20 ? "O numero esta entre 10 e 20\n" : " O numero não esta entre 10 e 20\n";
}
$numero = readline("Digite um valor valido: ");
$resultado = verificaIntervalo($numero);
echo $resultado;
?>