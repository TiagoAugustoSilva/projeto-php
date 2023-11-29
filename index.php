<?php

require_once("conexao.php");

$results = $conn->query("select * from cadastrar_produtos")->fetchAll();

include_once("layout/_header.php");

?>

<?php

require_once("conexao.php");

include_once("layout/_header.php");

?>

<!-- O mt-4 é o mesmo que margin-top: 4; aplicado ao elemento card -->

<div class="card mt-4">
    <!--justify-content-between joga o botão la no fim Chick D+-->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Mini Faturamento</h5>
        <!--ao utilizar btn-success ele dará a  cor verde ao botão pelo boostrap-->
        <a class="btn btn-success" href="cadastro.php">Adicionar</a>
    </div>
    <!-- Conteúdo do corpo do cartão -->
    <div class="card-body">
        <!--com bootstrap só de por a class="table" ele já ajusta a tabela-->
        <table class="table table-striped custom-table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Descrição</th>
                    <th>Valor Unitário</th>
                    <th>Unidade de Medida</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($results as $item): ?>
                    <tr>
                          <td><?= $item['produto']?></td>
                          <td><?= $item['descricao']?></td>
                          <td>

                          </td>
                        
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<?php
include_once("layout/_footer.php");
?>




<?php
include_once("layout/_footer.php"); ?>