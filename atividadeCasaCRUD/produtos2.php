<?php

// echo "=============== MENU DE PRODUTO ===============\n";
// echo "||    1-Cadastrar um produto                 ||
// ||    2-Listar todos os produtos             ||
// ||    3-Listar um produto pelo ID            ||
// ||    4-Atualizar um produto pelo ID         ||
// ||    5-Excluir um produto pelo ID           ||
// ||    6-Limpar tabela de produtos            ||
// ||    0- Sair                                ||
// ===============================================\n";
// $opcao = readline("Escola a opção que deseja executar: ");

?>

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

// Função para validar entradas do usuário
function validarEntrada($mensagem) {
    while (true) {
        $entrada = readline($mensagem);
        if (!empty(trim($entrada))) {
            return $entrada;
        } else {
            echo "Entrada inválida. Tente novamente.\n";
        }
    }
}

// Função para exibir um produto
function exibirProduto($produto) {
    echo "ID: " . $produto['id'] . "\n";
    echo "Nome: " . $produto['nome'] . "\n";
    echo "Preço: R$" . number_format($produto['preco'], 2, ',', '.') . "\n";
    echo "Data de Criação: " . $produto['data_criacao'] . "\n";
    echo "Data de Atualização: " . ($produto['data_atualizacao'] ?? 'Nunca atualizado') . "\n";
    echo "------------------------\n";
}

// Loop principal do menu interativo
while (true) {
    // Exibir opções do menu
    echo "\nMenu de Operações CRUD:\n";
    echo "1. Cadastrar um produto\n";
    echo "2. Listar todos os produtos\n";
    echo "3. Listar um produto pelo ID\n";
    echo "4. Atualizar um produto pelo ID\n";
    echo "5. Excluir um produto pelo ID\n";
    echo "6. Limpar tabela de produtos\n";
    echo "7. Sair\n";

    // Obter a escolha do usuário
    $opcao = validarEntrada("Escolha uma opção: ");

    // Executar a ação correspondente à opção escolhida
    switch ($opcao) {
        case 1: // Cadastrar Produto
            $nome = validarEntrada("Digite o nome do produto: ");
            $preco = floatval(validarEntrada("Digite o preço do produto: "));
            $stmt = $db->prepare("INSERT INTO produtos (nome, preco) VALUES (:nome, :preco)");
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':preco', $preco);
            $stmt->execute();
            echo "Produto cadastrado com sucesso!\n";
            break;

        case 2: // Listar Todos os Produtos
            $resultados = $db->query("SELECT * FROM produtos");
            if ($resultados->numColumns() > 0) {
                while ($row = $resultados->fetchArray(SQLITE3_ASSOC)) {
                    exibirProduto($row);
                }
            } else {
                echo "Nenhum produto cadastrado.\n";
            }
            break;

        case 3: // Listar Produto por ID
            $id = validarEntrada("Digite o ID do produto: ");
            $stmt = $db->prepare("SELECT * FROM produtos WHERE id = :id");
            $stmt->bindValue(':id', $id);
            $resultado = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
            if ($resultado) {
                exibirProduto($resultado);
            } else {
                echo "Nenhum produto encontrado com esse ID.\n";
            }
            break;

        case 4: // Atualizar Produto
            $id = validarEntrada("Digite o ID do produto que deseja atualizar: ");
            $nome = validarEntrada("Digite o novo nome do produto (deixe em branco para não alterar): ");
            $preco = validarEntrada("Digite o novo preço do produto (deixe em branco para não alterar): ");

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

            echo "Produto atualizado com sucesso!\n";
            break;

        case 5: // Excluir Produto
            $id = validarEntrada("Digite o ID do produto que deseja excluir: ");
            $stmt = $db->prepare("DELETE FROM produtos WHERE id = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            echo "Produto excluído com sucesso!\n";
            break;

        case 6: // Limpar Tabela
            if (strtolower(validarEntrada("Tem certeza que deseja limpar a tabela? (s/n): ")) === 's') {
                $db->exec("DELETE FROM produtos");
                echo "Tabela limpa com sucesso!\n";
            } else {
                echo "Operação cancelada.\n";
            }
            break;

        case 7: // Sair
            echo "Saindo...\n";
            exit;

        default:
            echo "Opção inválida. Tente novamente.\n";
    }
}

$db->close();