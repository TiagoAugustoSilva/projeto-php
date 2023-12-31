<?php

require_once("conexao.php");

//atenção este get está associado ao botão excluir, junto ao get global do código.
if (isset($_GET['excluir'])) {
    $idProduto = filter_input(INPUT_GET, 'excluir', FILTER_SANITIZE_NUMBER_INT);

    if($idProduto);
    $conn->exec('DELETE FROM cadastrar_produto WHERE idProduto=' . $idProduto);

    header('Location: index.php');
    exit;
  
}

$results = $conn->query("select * from cadastrar_produto")->fetchAll();

$arrayDescricao = [1 => 'Eletrônicos', 2 => 'Informática', 3 => 'Domésticos', 4 => 'Celulares', 5 => 'Acessórios'];

include_once("./layout/_header.php");


?>

<?php

require_once("conexao.php");

include_once("./layout/_header.php");

?>

<!-- O mt-4 é o mesmo que margin-top: 4; aplicado ao elemento card -->

<div class="card mt-4">
    <!--justify-content-between joga o botão la no fim Chick D+-->
    <div class="card-header d-flex justify-content-between align-items-center custom-card-header">
        <!-- o text-center my-4 mx-auto é o mesmo que display flex, justify-content-center align-items-center-->
        <h5 class="text-center my-4 h5-striped custom-h5">Mini Faturamento</h5>
        <!--ao utilizar btn-success ele dará a  cor verde ao botão pelo boostrap-->
        <a class="btn btn-success" href="cadastro.php">Adicionar</a>
    </div>
    <!-- Conteúdo do corpo do cartão -->
    <div class="card-body">
        <!--com bootstrap só de por a class="table" ele já ajusta a tabela-->
        <table class="table table-striped custom-table">
            <thead>
                <tr>
                    <th>Código </th>
                    <th>Produto</th>
                    <th>Descrição</th>
                    <th>Valor Unitário</th>
                    <th>Unidade de Medida</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $item) : ?>
                    <tr>
                        <td><?= $item['idProduto'] ?></td>
                        <td><?= $item['produto'] ?></td>
                        <td><?= $arrayDescricao[$item['descricao']] ?></td>
                        <td><?= $item['valor_unitario'] ?></td>
                        <td><?= $item['unidade_medida'] ?></td>
                        <!--área abaixo onde colocamos os nosso btn(Buttons) lembrando que btn-primary botão azul e btn-danger-botão vermelho-->
                        <td>
                            <a class="btn btn-sm btn-primary" href="cadastro.php?id=<?= $item['idProduto'] ?>">Editar</a>
                            <button class="btn btn-sm btn-danger" onclick="excluir(<?=$item['idProduto']?>)">Excluir</button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<script>   
 function excluir(idProduto) {
    if (confirm("Deseja Excluir este cadastro?")) {
        window.location.href = "index.php?excluir=" + idProduto;
    }
 }

</script>

<?php
include_once("./layout/_footer.php");
?>




