<?php
function verificaNumero($numero) {
    return $numero >= 0 ? "Positivo\n" : "Negativo\n";
}
$resultado = verificaNumero(-1);
echo $resultado;