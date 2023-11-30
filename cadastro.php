<?php

require_once("conexao.php");

$id = 0;
$produto = '';
$descricao = 1;


if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    if (!$id) {
        header('Location: index.php');
        exit;
    }

    $stm = $conn->prepare('SELECT * FROM cadastrar_produto  WHERE id=:id');
    $stm->bindValue('id', $id);
    $stm->execute();
    $result = $stm->fetch();


    if (!$result) {
        header('Location: index.php');
        exit;
    }

    $produto = $result['produto'];
    $descricao = $result['descricao'];
};

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Utilize a variável $id apenas se ela estiver definida
    $id = isset($_POST['id']) ? filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT) : null;
    $produto = filter_input(INPUT_POST, "produto", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_NUMBER_INT);
    $valor_unitario = filter_input(INPUT_POST, "valor_unitario", FILTER_SANITIZE_NUMBER_FLOAT);
    $unidade_medida = filter_input(INPUT_POST, "unidade_medida", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!)

    // Verifique se $produto e $descricao não são nulos antes de continuar
    if ($produto !== null && $descricao !== null) {
        $stm = $conn->prepare("INSERT INTO cadastrar_produto (produto, descricao, valor_unitario, unidade_medida) VALUES (:produto, :descricao, :valor_unitario, :unidade_medida)");
        $stm->bindValue(':produto', $produto);
        $stm->bindValue(':descricao', $descricao);
        $stm->bindValue(':valor_unitario', $valor_unitario);
        $stm->bindValue(':unidade_medida', $unidade_medida);
        $stm->execute();

        header('Location: index.php');
        exit;
    } else {
        echo "Erro: Produto, descrição, valor unitário ou unidade de medida não foram recebidos corretamente.";
        // Lide com o erro apropriado aqui, como redirecionar para uma página de erro.
        exit;
    }
}

include_once("./layout/_header.php");
?>

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <!--o id abaixo irá servir como verificação-->
        <h5><?= $id?'Editar cadastrar_produto' . $id:'Adicionar Produto' ?></h5>
    </div>
    <form method="post" autocomplete="off">
        <div class="card-body">
            <!-- Remova o campo input type="hidden" name="id" se não estiver sendo utilizado -->
            <input type="hidden" name="id" value="<?= $id ?>" />
            <div class="form-group">
                <label for="produto">Produto</label>
                <input type="text" class="form-control" id="produto" name="produto" value="<?= $produto ?>" required />
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <select class="form-select" id="descricao" name="descricao" required>
                    <!--bastante atenção com esses selected-->
                    <option value="1" <?= $descricao == 1 ?? 'selected' ?>>Eletrônicos</option>
                    <option value="2" <?= $descricao == 2 ?? 'selected' ?>>Informática</option>
                    <option value="3" <?= $descricao == 3 ?? 'selected' ?>>Domésticos</option>
                    <option value="4" <?= $descricao == 4 ?? 'selected' ?>>Celulares</option>
                    <option value="5" <?= $descricao == 5 ?? 'selected' ?>>Acessórios</option>
                </select>
            </div>
            <div class="form-group">
                <label for="valor_unitario">Valor Unitário</label>
                <input type="text" class="form-control" id="valor_unitario" name="valor_unitario" required />
            </div>
            <div class="form-group">
                <label for="unidade_medida">Unidade de Medida</label>
                <input type="text" class="form-control" id="unidade_medida" name="unidade_medida" required />
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a class="btn btn-primary" href="index.php">Voltar</a>
        </div>
    </form>
</div>

<?php include_once("./layout/_footer.php"); ?>
