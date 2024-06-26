<?php

// Conexão com o banco de dados SQLite
$db = new SQLite3('produto.sqlite');

// Criar tabela 'produtos' se não existir
$db->exec("CREATE TABLE IF NOT EXISTS produtos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    preco REAL NOT NULL,
    data_criacao TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TEXT
)");

//limpar terminal
function limpar() {
    popen('cls || clear','w');
}
limpar();

// Função para validar entradas do usuário
function validarEntrada($mensagem) {
    while (true) {
        $entrada = readline($mensagem);
        if (!empty(trim($entrada))) {
            return $entrada;
        }
        else {
            echo "Entrada inválida. Tente novamente." . PHP_EOL;
        }
    }
}

// Função para exibir um produto
function exibirProduto($produto) {
    echo "ID: " . $produto['id'] . PHP_EOL;
    echo "Nome: " . $produto['nome'] . PHP_EOL;
    echo "Preço: R$" . number_format($produto['preco'], 2, ',', '.') . PHP_EOL;
    echo "Data de Criação: " . $produto['data_criacao'] . PHP_EOL;
    echo "Data de Atualização: " . ($produto['data_atualizacao'] ?? 'Nunca atualizado') . PHP_EOL;
    echo "------------------------" . PHP_EOL;
}

//função para mostrar o menu
function mostrarMenu(){
    echo "=============== MENU DE PRODUTO ===============" . PHP_EOL;
    echo "||    1- Cadastrar um produto                ||" . PHP_EOL;
    echo "||    2- Listar todos os produtos            ||" . PHP_EOL;
    echo "||    3- Listar um produto pelo ID           ||" . PHP_EOL;
    echo "||    4- Atualizar um produto pelo ID        ||" . PHP_EOL; 
    echo "||    5- Excluir um produto pelo ID          ||" . PHP_EOL; 
    echo "||    6- Limpar tabela de produtos           ||" . PHP_EOL;
    echo "||    7- Sair                                ||" . PHP_EOL;
    echo "===============================================" . PHP_EOL;
    echo PHP_EOL;
}
// função para cadastrar produto
function cadastrarProduto($db){ 
    $nome = validarEntrada("Digite o nome do produto: ");
    $preco = floatval(validarEntrada("Digite o preço do produto: "));
    $stmt = $db->prepare("INSERT INTO produtos (nome, preco) VALUES (:nome, :preco)");
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':preco', $preco);
    $stmt->execute();
    echo "Produto cadastrado com sucesso!" . PHP_EOL;
    sleep(2);
    limpar();
    return;
}

//função para listar todos os produtos
function listarProdutos($db){
    $resultados = $db->query("SELECT * FROM produtos");
    $resultado = $db->querySingle("SELECT COUNT(*) FROM produtos");
    $numRows = intval($resultado);
    if ($numRows > 0) {
        while ($row = $resultados->fetchArray(SQLITE3_ASSOC)) {
            exibirProduto($row);
        }
    }
    else {
        echo "Nenhum produto cadastrado." . PHP_EOL;
        sleep(2);
        limpar();
    }
}

//função para listar produto pelo ID
function listarProdutoId($db){
    $id = validarEntrada("Digite o ID do produto: ");
    limpar();
    $stmt = $db->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->bindValue(':id', $id);
    $resultado = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
    if ($resultado) {
        exibirProduto($resultado);
    }
    else {
        echo "Nenhum produto encontrado com esse ID." . PHP_EOL;
        sleep(2);
        limpar();
    }
}

//função para editar produto
function editarProduto($db){
    $id = validarEntrada("Digite o ID do produto que deseja atualizar: ");
    echo "Digite o novo nome do produto (deixe em branco para não alterar): ";
    $nome = readline();
    echo "Digite o novo preço do produto (deixe em branco para não alterar): ";
    $preco = readline();

    $sql = "UPDATE produtos SET ";
    $parametros = [];
    if (!empty($nome)) {
        $sql .= "nome = :nome, ";
        $parametros[':nome'] = $nome;
    }
    if (!empty($preco)) {
        $sql .= "preco = :preco, ";
        $parametros[':preco'] = floatval($preco);
    }
    $sql .= "data_atualizacao = CURRENT_TIMESTAMP WHERE id = :id";
    $parametros[':id'] = $id;

    $stmt = $db->prepare($sql);
    foreach ($parametros as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();

    echo "Produto atualizado com sucesso!" . PHP_EOL;
    sleep(2);
    limpar();
}

//função para excluir produto
function excluirProduto($db) {
    $id = validarEntrada("Digite o ID do produto que deseja excluir: ");
    $stmt = $db->prepare("DELETE FROM produtos WHERE id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    echo "Produto excluído com sucesso!" . PHP_EOL;
    sleep(2);
    limpar();
}

//função para limpar toda a tebela
function limparTabela($db) {
    if (strtolower(validarEntrada("Tem certeza que deseja limpar a tabela? (s/n): ")) === 's') {
        $db->exec("DELETE FROM produtos");
        echo "Tabela limpa com sucesso!" . PHP_EOL;
        sleep(2);
        limpar();
    }
    else {
        echo "Operação cancelada." . PHP_EOL;
        sleep(2);
        limpar();
    }
}

while(true) {
    mostrarMenu();

    $opcao = validarEntrada('Escolha uma opção: ');
    switch($opcao) {
        case 1:
            limpar();
            $produtos = cadastrarProduto($db);
            break;
        case 2:
            limpar();
            listarProdutos($db);
            break;
        case 3:
            limpar();
            listarProdutoId($db);
            break;
        case 4:
            limpar();
            editarProduto($db);
            break;
        case 5:
            limpar();
            excluirProduto($db);
            break;
        case 6:
            limpar();
            limparTabela($db);
            break;
        case 7:
            echo"Saindo..." . PHP_EOL;
            exit;
        default:
            echo "Opção inválida. Tente novamente." . PHP_EOL;
    }
}
?>