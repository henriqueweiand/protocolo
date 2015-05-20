<?php

	require_once('inc.php');

	// < Obtem valores $_POST
	$origem  = isset($_POST["origem"])   ? $_POST["origem"]   : "";
	$destino = isset($_POST["destino"])  ? $_POST["destino"]  : "";

	switch($_POST['tipoRequisicao']) {
		case '#enviarProtocolo':
			
			@unlink(FILE_PROTOCOL);
		
			if(copy($_FILES['arquivoProtocolo']['tmp_name'], FILE_PROTOCOL)) {
				exit('
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Arquivo recebido com sucesso.
				</div>');
			} else {
				exit('
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					ERRO - Houve um problema ao receber o arquivo, tente novamente.
				</div>');
			}
			
		break;
		
		case '#mensagem':
			$msg = $_POST["mensagem"];
		break;
		
		case '#enviarArquivo':
			$msg = fread(fopen($_FILES['file']['tmp_name'], 'rb'), filesize($_FILES['file']['tmp_name']));
		break;
	}

	// > Obtem valores $_POST

	$file = fopen(FILE_PROTOCOL, "wb");
	// < Valores fixos
	$soh  = hexdec("0x01");
	$syn  = hexdec("0x16");
	$si   = hexdec("0x0f");
	$so   = hexdec("0x0E");
	$stx  = hexdec("0x02");
	$etx  = hexdec("0x03");
	$eot  = hexdec("0x04");
	// > Valores fixos

	// < Inicializacao de variaveis
	$or   = null;
	$de   = null;
	$tm   = 0;
	$sq   = 0;
	$chk1 = null;
	$chk2 = null;
	// > Inicializacao de variaveis
	
	// < Check se existe mensagem
	if(empty($msg)) {
		exit('
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			ERRO - Você deve informar uma mensagem para enviar.
		</div>
		');
	}
	// > Check se existe mensagem
	
	// < Check ip valido
	if(!filter_var($origem, FILTER_VALIDATE_IP) !== false) {
		exit('
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			A origem nao eh um IP valido.
		</div>
		');
	}
	// > Check ip valido
	
	// < Check ip valido
	if(!filter_var($destino, FILTER_VALIDATE_IP) !== false) {
		exit('
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			O destino nao eh um IP valido.
		</div>
		');
	}
	// > Check ip valido
	
	// < Inverte os IP's
	$origem  = array_reverse(explode(".",  $origem));
	$destino = array_reverse(explode(".",  $destino));
	// > Inverte os IP's
	$a_m 	 = str_split($msg, 4095); // Permite apenas 4095 bytes da mensagem (Retorna array)

	// < Percorre as partes da mensagem
	foreach($a_m as $i => $a) {

		$tm = dechex(strlen($a)); // Decimal para hexadecimal
		$sq = dechex($i+1);
		$or = $origem;
		$de = $destino;
		
		// <
		for($i=0; $i < 5; $i++) {
			if(strlen($tm) < 3)	$tm = "0".$tm;
			if(strlen($sq) < 5) $sq = "0".$sq;
		}
		// >

		$z 	  = array_map("hexdec", array_reverse(str_split($tm.$sq, 2))); // tamanho e sequencia juntos
		
		$chk1 = ~($soh^$syn^$si^$or[0]^$or[1]^$or[2]^$or[3]^$de[0]^$de[1]^$de[2]^$de[3]^$so^$z[0]^$z[1]^$z[2]^$z[3]) & 0xff;
		$msg  = array_map("ord", str_split($a));
		$chk2 = $soh + $syn + $si + $or[0] + $or[1] + $or[2] + $or[3] + $de[0] + $de[1] + $de[2] + $de[3] + $so + $z[0] + $z[1] + $z[2] + $z[3] + $chk1 + $stx + $eot + $etx;
		
		foreach($msg as $b)	$chk2 += $b;

		$chk2 	   = array_map("hexdec", array_reverse(str_split(dechex((~$chk2) & 0xffff), 2)));
		$protocolo = chr($soh).chr($syn).chr($si).implode("", array_map("chr", $or)).implode("", array_map("chr", $de)).chr($so).implode("", array_map("chr", $z)).chr($chk1).chr($stx).implode("", array_map("chr", $msg)).chr($etx).chr($eot).implode("", array_map("chr", $chk2));

		fwrite($file, $protocolo); // Insere o conteudo no arquivo
		
		$protocolo = implode(" => ", array_map("dechex",array_map("ord", str_split($protocolo))));

	}
	// > Percorre as partes da mensagem

	echo '
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		Recebido com sucesso.
	</div>
	';

	fclose($file);
?>