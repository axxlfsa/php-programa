
<?php


include_once 'vrf_lgin.php';
require_once 'cabecalho.php';
include_once '../core/crud.php';

date_default_timezone_set('America/Sao_Paulo');

$logado = $_SESSION['nomeUsuario'];


$app->get("/main/index_user.php", function(){

	User::verifyLogin();

    //$page = new PageAdmin();
  $app =  '../main/index_user.php';
	//$page->setTpl("../main/index_user.php");

});

?>
