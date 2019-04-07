<?php
require_once 'crud.php';


//isset()
$value = isset($_POST['tipo']) ? $_POST['tipo'] : '';


switch ($value) {
	case 'editausr':
	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$edt = crud::atualizaUsr($id,$nome);
	if ($edt == true) {
		echo 1;
	}else{
		echo 0;
	}
	break;
	
	case 'criaDemanda':

	$dataAbertura = $_POST['dataAtual'];
	$idLogado = $_POST['idLogado'];
	$titulo = $_POST['titulo'];
	$departamento = $_POST['departamento'];
	$usuarioDestino = $_POST['usuarioDestino'];
	$prioridade = $_POST['prioridade'];
	$ordemServico = $_POST['ordemServico'];
	if ($ordemServico == '') {
		$ordemServico = '';
	}

	$mensagem = $_POST['mensagem'];	
	$status = "Aberto";
	//FUNÇÃO TRIM ELIMINA OS ESPAÇOS DA STRING
	$emailDestino = $_POST['emailDestino'];
	$email = trim($emailDestino);

//ENTRA AQUI SE TIVER ANEXO
	if(!empty($_FILES["file"]["name"])){
		$validextensions = array("jpeg", "jpg", "png","PNG", "JPG", "JPEG", "pdf", "PDF", "docx");
		$temporary = explode(".", $_FILES["file"]["name"]);
		$file_extension = end($temporary);
		$nomeAnexo = md5($dataAbertura).".". $file_extension;

		if (in_array($file_extension, $validextensions)) {
			
			$sourcePath = $_FILES['file']['tmp_name'];
			$targetPath = "../anexos/".md5($dataAbertura).".". $file_extension;
				move_uploaded_file($sourcePath,$targetPath) ; // Move arquivo				
				//SALVA NO BANCO 
				$cdt = crud::criaDemanda($dataAbertura, $idLogado, $titulo, $departamento, $usuarioDestino, $prioridade, $ordemServico, $mensagem, $status, $nomeAnexo);
				if ($cdt == true) {
					echo 1;					
					//enviaEmail();


				}else{
					echo 0;
				}
			}else{
				echo 0;
			}

	//CASO NÃO TENHA ANEXO ENTRA AQUI	
		}else{
			$nomeAnexo = "sem_anexo.php";
			$cdt = crud::criaDemanda($dataAbertura, $idLogado, $titulo, $departamento, $usuarioDestino, $prioridade, $ordemServico, $mensagem, $status, $nomeAnexo);
			if ($cdt == true) {
				echo 1;
			}else{
				echo 0;
			}
		}	


		break;


		case 'atualizaStatus':

		$codigoDemanda = $_POST['codigoDemanda'];
		$status = $_POST['status'];

		$edt = crud::atualizaStatus($codigoDemanda,$status);
		if ($edt == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;

		case 'fechaDemanda':

		$codigoDemanda = $_POST['codigoDemanda'];
		$status = $_POST['status'];
		$dataFechamento = $_POST['dataFechamento'];

		$edt = crud::fechaDemanda($codigoDemanda, $status, $dataFechamento);
		if ($edt == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;


		case 'deletacad':
		$id = $_POST['id'];
		$del = crud::deletaCad($id);
		if ($del == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;

		case 'adicionaMensagem':

		$idLogado = $_POST['idLogado'];
		$dataHora = $_POST['datahora'];
		$codDemanda = $_POST['codDemanda'];
		$mensagem = $_POST['mensagem'];



		$cdt = crud::addMensagem($idLogado, $dataHora, $codDemanda, $mensagem);
		if ($cdt == true) {
			$mudaStatus = crud::dataview("UPDATE demanda SET status='Em atendimento' WHERE id=".$codDemanda);
			echo 1;
		}else{
			echo 0;		
		}

		break;



		case 'cadUsuario':

		$nome = $_POST['nome'];	
		$email = $_POST['email'];
		$nivel = $_POST['nivel'];
		$dep = $_POST['dep'];
		$pass = $_POST['pass'];
		$status = "Ativo";
		$cdt = crud::criaUsr($nome, $email, $nivel, $dep, $status, $pass);
		if ($cdt == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;

		//EDITA USUÁRIO
		case 'editaUsr':

		$id = $_POST['iduser'];	
		$nome = $_POST['edtnome'];	
		$email = $_POST['edtemail'];
		$nivel = $_POST['edtnivelUser'];
		$dep = $_POST['edtdepartamento'];
		$pass = $_POST['edtPass'];
		$status = "Ativo";

		$edt = crud::edtUsr($id, $nome, $email, $nivel, $dep, $status, $pass);
		if ($edt == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;

		case 'excluiUsuario':

		$id = $_POST['idUser'];	
		

		$del = crud::deleteUser($id);
		if ($del == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;


		case 'cadDep':

		$nomeDep = $_POST['nomeDep'];	

		$cdt = crud::criaDep($nomeDep);
		if ($cdt == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;


		case 'EditDep':

		$id = $_POST['id'];	
		$nomeDep = $_POST['nomeDep'];

		$edt = crud::editDep($id, $nomeDep);
		if ($edt == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;


		case 'deleteDep':

		$id = $_POST['id'];	
		

		$del = crud::deleteDep($id);
		if ($del == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;


		//ATUALIZA STATUS DO USUÁRIO PARA DESATIVADO
		case 'desativaUsuario':

		$id = $_POST['id'];
		$status = "Desativado";

		$edt = crud::atualizaStatusUsuario($id,$status);
		if ($edt == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;

		//ATUALIZA STATUS DO USUÁRIO PARA DESATIVADO
		case 'ativaUsuario':

		$id = $_POST['id'];
		$status = "Ativo";

		$edt = crud::atualizaStatusUsuario($id,$status);
		if ($edt == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;


		// MANAGER SLA
		case 'cadSla':

		$descricao = $_POST['descricao'];
		$tempo = $_POST['tempo'];
		$uniTempo = $_POST['unidtempo'];		

		$cad = crud::cadSla($descricao,$tempo,$uniTempo);
		if ($cad == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;

		// MANAGER SLA
		case 'edtSla':

		$descricao = $_POST['edtDescricao'];
		$tempo = $_POST['edtTempo'];
		$uniTempo = $_POST['edtUnidtempo'];		
		$id = $_POST['edtId'];		

		$cad = crud::edtSla($id,$descricao,$tempo,$uniTempo);
		if ($cad == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;

		case 'excluiSla':

		$id = $_POST['idSla'];		

		$exc = crud::excluiSla($id);
		if ($exc == true) {
			echo 1;
		}else{
			echo 0;
		}
		break;

		case '':
		
		break;
	}


	?>

