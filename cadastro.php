<?php

require_once("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Utilize a variável $id apenas se ela estiver definida
    $id = isset($_POST['id']) ? filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT) : null;
    
    // Corrija a captura de valores para $produto e $descricao
    $produto = filter_input(INPUT_POST, "produto", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_NUMBER_INT);

    // Verifique se $produto e $descricao não são nulos antes de continuar
    if ($produto !== null && $descricao !== null) {
        $stm = $conn->prepare("INSERT INTO cadastrar_produtos (produto, descricao) VALUES (:produto, :descricao)");
        $stm->bindValue(':produto', $produto);
        $stm->bindValue(':descricao', $descricao);
        $stm->execute();

        header('Location: index.php');
        exit;
    } else {
        echo "Erro: Produto ou descrição não foram recebidos corretamente.";
        // Lide com o erro apropriado aqui, como redirecionar para uma página de erro.
        exit;
    }
}

include_once("layout/_header.php");
?>

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Adicionar Produto</h5>
    </div>
    <form method="post" autocomplete="off">
        <div class="card-body">
            <!-- Remova o campo input type="hidden" name="id" se não estiver sendo utilizado -->
            <div class="form-group">
                <label for="produto">Produto</label>
                <input type="text" class="form-control" id="produto" name="produto" required />
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <select class="form-select" id="descricao" name="descricao" required>
                    <option value="1">Aberta</option>
                    <option value="2">Em andamento</option>
                    <option value="3">Realizada</option>
                </select>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-success">Salvar</button>
            <a class="btn btn-primary" href="index.php">Voltar</a>
        </div>
    </form>
</div>

<?php include_once("layout/_footer.php");
?>
