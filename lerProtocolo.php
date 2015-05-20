<?php
	require_once('inc.php');

	// < Inicializacao de variaveis
	$filename = FILE_PROTOCOL; 											   // Arquivo do protocolo
	$file 	  = fopen($filename, "rb"); 						   		   // Abre para leitura
	$fread 	  = str_split(fread ($file, filesize ($filename)), (4095+22)); // Pega os 4096 bytes (Mensage) + 26 bytes (Protocolo)  (retorna array)
	$msg 	  = "";
	// > Inicializacao de variaveis
	
	// < Percorre os arquivos do protocolo
	foreach($fread as $i => $f) {

		$i 		 	= $i+1;
		$chr_header = substr($f, 0, 16); /* pega os 16 bytes do cabeçalho */
		$chk_header = ord(substr($f, 16, 1)); /* pega o checksum do cabeçalho */
		$res_header = str_split($chr_header); /* quebra os 16 bytes em um array */
		$chr_header = 0;
		
		foreach($res_header as $r) $chr_header ^= ord($r); // quebra os 16 bytes em um array
			
		$chr_header = (~$chr_header) & 0xff; /* inverso do valor */

		// < Checagem do header
		if($chr_header != $chk_header) {
			exit('
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				O checksum do header da sequencia '.$i.' esta errado.
			</div>
			');
		}
		// > Checagem do header
		
		$chr_f = substr($f, 0, -2);
		$chk_f = ord(substr($f, -2, 1)).ord(substr($f, -1, 1));
		$res_f = str_split($chr_f);

		foreach($res_f as $r) $chr_f += ord($r);
			
		$chr_f = (~$chr_f) & 0xffff;
		$chr_f = implode("", array_map("hexdec", array_reverse(str_split(dechex($chr_f), 2))));

		// < Checagem do checksum final
		if($chr_f != $chk_f) {
			exit('
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				O checksum final da sequencia '.$i.' esta errado.
			</div>
			');
		}
		// > Checagem do checksum final
		
		$msg.= substr($f, 18, -4);
	}
	
	$tmp = fopen("tmp.txt", "wb");
	
	fwrite($tmp, $msg);
	
	if(@!$image = getimagesize("tmp.txt")) {
	
		echo '
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>MENSAGEM:</b> '.$msg.'
		</div>
		';
	
	} else {
		echo '
		<div class="col-md-12" style="margin-bottom:10px;">
			<center>
				<img src="'.('data:image/'.explode("/", $image["mime"])[1].';base64,'.base64_encode($msg)).'">
			</center>
		</div>
		';
	}
	
	fclose($tmp);
	unlink("tmp.txt");

	fclose($file);
?>