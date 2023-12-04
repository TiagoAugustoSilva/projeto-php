<?php

require_once("conexao.php");

$idProduto = 0;
$produto = '';
$descricao = '';
$valor_unitario = '';
$unidade_medida = '';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idProduto = isset($_POST['idProduto']) ? filter_input(INPUT_POST, "idProduto", FILTER_SANITIZE_NUMBER_INT) : null;
    $produto = filter_input(INPUT_POST, "produto", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_NUMBER_INT);
    $valor_unitario = filter_input(INPUT_POST, "valor_unitario", FILTER_SANITIZE_NUMBER_FLOAT);
    $unidade_medida = filter_input(INPUT_POST, "unidade_medida", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    if ($produto !== null && $descricao !== null) {
        if ($idProduto) {
            // Se estiver adicionando, insira os dados
            $stm = $conn->prepare("INSERT INTO cadastrar_produto (produto, descricao, valor_unitario, unidade_medida) VALUES (:produto, :descricao, :valor_unitario, :unidade_medida)");
        } else {
            // Se estiver editando, atualize os dados
            $stm = $conn->prepare("UPDATE cadastrar_produto SET produto=:produto, descricao=:descricao, valor_unitario=:valor_unitario, unidade_medida=:unidade_medida WHERE idProduto=:idProduto");
            $stm->bindValue(':idProduto', $idProduto);
        }

        // Adicione as linhas de vinculação abaixo para garantir que todos os parâmetros sejam vinculados corretamente
        $stm->bindValue(':produto', $produto);
        $stm->bindValue(':descricao', $descricao);
        $stm->bindValue(':valor_unitario', $valor_unitario);
        $stm->bindValue(':unidade_medida', $unidade_medida);

        $stm->execute();



        header('Location: index.php');
        exit;
    } else {
        echo "Erro: Produto, descrição, valor unitário ou unidade de medida não foram recebidos corretamente.";
        exit;
    }
}

if (isset($_GET['idProduto'])) {
    $idProduto = filter_input(INPUT_GET, "idProduto", FILTER_SANITIZE_NUMBER_INT);


    if (!$idProduto) {
        header('Location: index.php');
        exit;
    }
    $stm = $conn->prepare('SELECT * FROM cadastrar_produto WHERE idProduto=:idProduto');
    $stm->bindValue(':idProduto', $idProduto);
    $stm->execute();
    $result = $stm->fetch();

    if (!$result) {
        header('Location: index.php');
        exit;
    }

    $idProduto = $result['idProduto'];
    $produto = $result['produto'];
    $descricao = $result['descricao'];
    $valor_unitario = $result['valor_unitario'];
    $unidade_medida = $result['unidade_medida'];
}

include_once("./layout/_header.php");
?>

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5><?= $idProduto ? 'ID ' . $idProduto . ': Editar cadastrar_produto ' . $idProduto : 'Adicionar Produto' ?></h5>
        <?php if ($idProduto) : ?>
            <a class="btn btn-warning" href="editar.php?idProduto=<?= $idProduto ?>">Editar</a>
        <?php endif; ?>
    </div>

    <form method="post" autocomplete="off">
        <div class="card-body">
            <input type="hidden" name="idProduto" value="<?= $idProduto ?>" />
            <!-- Adicione esta parte para exibir o idProduto -->
            <div class="form-group">
                <label for="idProduto">Código Produto</label>
                <input type="text" class="form-control" id="idProduto" name="idProduto" value="<?= $idProduto ?>" required />
            </div>

            <div class="form-group">
                <label for="produto">Produto</label>
                <input type="text" class="form-control" id="produto" name="produto" value="<?= $produto ?>" required />
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <select class="form-select" id="descricao" name="descricao" required>
                    <option value="1" <?= $descricao == 1 ? 'selected' : '' ?>>Eletrônicos</option>
                    <option value="2" <?= $descricao == 2 ? 'selected' : '' ?>>Informática</option>
                    <option value="3" <?= $descricao == 3 ? 'selected' : '' ?>>Domésticos</option>
                    <option value="4" <?= $descricao == 4 ? 'selected' : '' ?>>Celulares</option>
                    <option value="5" <?= $descricao == 5 ? 'selected' : '' ?>>Acessórios</option>
                </select>
            </div>
            <div class="form-group">
                <label for="valor_unitario">Valor Unitário</label>
                <input type="text" class="form-control" id="valor_unitario" name="valor_unitario" value="<?= $valor_unitario ?>" required />
            </div>
            <div class="form-group">
                <label for="unidade_medida">Unidade de Medida</label>
                <input type="text" class="form-control" id="unidade_medida" name="unidade_medida" value="<?= $unidade_medida ?>" required />
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a class="btn btn-primary" href="index.php">Voltar</a>
        </div>
    </form>
