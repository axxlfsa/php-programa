<?php

//use main\Controller\PedidoController;

include_once 'vrf_lgin.php';
require_once 'cabecalho.php';
include_once '../core/crud.php';
include_once 'Models/DAO/StatusDAO.php';
include_once './Models/DAO/PedidoDAO.php';

date_default_timezone_set('America/Bahia');

//DEFINIÇÃO DO NOME DO ANEXO
$nomeAnexo = date('Y-m-d-H:i');
$dataMsg = date('d/m/Y - H:i');
$novoNomeAnexo = md5($nomeAnexo);

$idLogado = $_SESSION['usuarioID'];
$logado         = $_SESSION['nomeUsuario'];
$emailLogado    = $_SESSION['emailUsuario'];
$instituicao    = $_SESSION['instituicaoUsuario'];

$queryDepart    = "SELECT * FROM departamentos";
$queryCliente   = "SELECT * FROM cliente";
$queryStatus   = "SELECT * FROM status";
/*
echo " Andre  $andre<br/> ";

echo " segundos  $segundos<br/> ";
echo " registro $registro<br/> ";
echo " limite $limite<br/> ";
if($logado != 1){$logado2 = 600;
    echo "<meta HTTP-EQUIV='refresh' CONTENT='$logado2;'>";//atualizacao automatica
}
*/

?>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12">

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="container">
    <div id="andre"></div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-success waves-effect waves-light" type="button" data-toggle="modal" data-target="#modalCadastrarPedido" data-whatever="@getbootstrap"><span class="btn-label"><i class="fa fa-plus"></i></span>Cadastrar Pedido</button>
            <button class="btn btn-success waves-effect waves-light" type="button"  onclick="window.location.href = 'pedidoHome.php'" data-whatever="@getbootstrap"><span class="btn-label"><i class="fa fa-home"></i></span>Home</button>
        </div>
        <form id="frmIndex" method="post">
        <div class="row">
            <div class="col-sm-12">
                <div id="dado"></div>
                <div class="white-box">
                    <div class="col-sm-6">
                        <h3>Pedidos Atendidos</h3>
                    </div>
                    
                    <table id="tabela" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Tipo</th>                               
                                <th>Licitação</th>
                                <th>Pedido</th>
                                <th>Valor</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Garantia</th>
                                <th>Decorridos</th>
                                <th>Anexo</th>
                                <th>Alterar</th>
                                <th>Detalhes</th>
                            </tr>
                        <tfoot>
                            <tr>
                                <th>Cliente</th>
                                <th>Tipo</th>
                                <th>Licitação</th>                                
                                <th>Pedido</th>
                                <th>Valor</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Garantia</th>
                                <th>Decorridos</th>
                                <th>Anexo</th>
                                <th>Alterar</th>
                                <th>Detalhes</th>
                            </tr>
                        </tfoot>
                        </thead>
                        <tbody>
                            <?php
                            $dados = PedidoDAO::listarPedidoAtendidos($idInstituicao);
                            $totalPedido = 0;
                            $teste = 0;
                            if ($dados->rowCount() > 0) {
                                while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
                                    $valorPedido = $row['valorPedido'];

                                    $totalPedido  += $valorPedido;
                                    $teste = $teste + 1;

                                    $dataCriada = $row['dataCadastro'];
                                    $dataAtual = date('Y-m-d H:i:s');

                                    $datatime1 = new DateTime($row['dataCadastro']);
                                    $datatime2 = new DateTime($dataAtual);
                                    $codStatus = $row['codStatus'];
                                    if($codStatus == "16" || $codStatus == "7" || $codStatus == "2"){
                                        $datatime2 =  new DateTime($row['dataFechamento']);
                                    }
                                           
                                    $data1  = $datatime1->format('Y-m-d H:i');
                                    $data2  = $datatime2->format('Y-m-d H:i');

                                    $criada = strtotime($data1);
                                    $atual = strtotime($data2);

                                    $intervalo = ($atual - $criada) / 60;

                                    $horas = (int)($intervalo / 60);
                                    $minutos = $intervalo % 60;

                                    ?>
                                    <tr>
                                        <td style="text-transform: uppercase;">
                                            <?php print($row['nomeCliente']); ?></td>
                                        <td><?php print($row['tipoCliente']); ?></td>
                                        <td><?php print($row['numeroPregao']); ?></td>
                                        <td><?php print($row['numeroAf']); ?></td>
                                        <td> R$<?php print(number_format($row['valorPedido'], 2, ',', '.')); ?></td>
                                        <td><?php print(crud::formataData($row['dataCadastro'])); ?></td>
                                        <td id="statusControle"><?php print($row['nomeStatus']); ?></td>
                                        <td id="statusGarantia"><?php print($row['garantia']); ?></td>
                                        <td><?php print($horas .   'hs ' . 'e ' .  $minutos . 'm'); ?></td>

                                        <td><a class="btn btn-primary waves-effect waves-light" id="btnAnexo" target="_blank" href="../anexos/<?php print($row['anexo']); ?>">Anexo</a></td>
                                        <td><a class="btn btn-primary waves-effect waves-light" type="button" id="btnPedidoAlterar" data-toggle="modal" data-target="#modalPedidoAlterar" data-whatever="@getbootstrap" target="_blank" data-statusalterar="<?php print($row['codStatus']); ?>" data-mensagemalterar="<?php print($row['observacao']); ?>" 
                                        data-codigocontrolealterar="<?php print($row['codControle']); ?>" data-dataalteracao="<?php print($row['dataAlteracao']); ?>"  data-anexoalterar="<?php print($row['anexo']); ?>"
                                        data-garantia="<?php print($row['garantia']); ?>"  data-nomeusuario="<?php print($row['nomeUsuario']); ?>" data-idusuario="<?php print($row['fk_idUsuarioPed']); ?>"  data-idinstituicaoalterar="<?php print($row['fk_idInstituicao']); ?>"  data-nomesatus="<?php print($row['nomeStatus']); ?>" data-nomealterar="<?php print($row['nomeCliente']); ?>" data-datafechamento="<?php print($row['dataFechamento']); ?>">Alterar</a></td>
                                            
                                            <td><a class="btn btn-success waves-effect waves-light" type="button" id="btnPedidoDetalhes" data-toggle="modal" data-target="#modalDetPedido" data-whatever="@getbootstrap" 
                                            data-garantia="<?php print($row['garantia']); ?>"   data-codigocontroledet="<?php print($row['codControle']); ?>" data-nomeclientedet="<?php print($row['nomeCliente']); ?>" 
                                            data-tipoclientedet="<?php print($row['tipoCliente']); ?>" data-numeropregaodet="<?php print($row['numeroPregao']); ?>" 
                                            data-numeropedidodet="<?php print($row['numeroAf']); ?>" data-valorpedidodet="R$<?php print(number_format($row['valorPedido'], 2, ',', '.')); ?>" 
                                            data-statuscontroledet="<?php print($row['nomeStatus']); ?>" data-datacadastrodet="<?php print(crud::formataData($row['dataCadastro'])); ?>"
                                            data-datafechamento="<?php print(crud::formataData($row['dataFechamento'])); ?>"  data-dataalteracao="<?php print(crud::formataData($row['dataAlteracao'])); ?>" 
                                            data-nomeusuario="<?php print($row['nomeUsuario']); ?>" data-idusuario="<?php print($row['fk_idUsuarioPed']); ?>"       data-mensagem="<?php print($row['observacao']); ?>">Detalhes</a></td>
                                        </tr>
                                <?php
                            }
                            echo "Qtde pedidos nao atendidos:  " . $teste . " - ";
                            echo "Valor Total Pedido R$" . number_format($totalPedido, 2, ',', '.');
                        } else {
                            echo "<p class='text-danger'>Sem Pedidos Cadastrados</p>";
                        }
                        ?>
                        </tbody>
                    </table>
               
                </div>
            </div>
         
        </div>
        </form>
    </div>
    <!-- /.row -->
</div>



<?php
require_once "rodape.php";
include_once "pedidoModais.php";
?>
<script src="js/pedido.js"></script>