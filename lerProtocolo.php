<?php
	// < Inicializacao de variaveis
	$filename = "/home/ubuntu/workspace/arquivos/1.protocolo.txt"; 		   // Arquivo do protocolo
	$file 	  = fopen($filename, "rb"); 						   		   // Abre para leitura
	$fread 	  = str_split(fread ($file, filesize ($filename)), (4096+26)); // Pega os 4096 bytes (Mensagem) + 26 bytes (Protocolo)  (retorna array)
	$msg 	  = "";
	// > Inicializacao de variaveis
	
	// < Percorre
	foreach($fread as $i => $f) {
		
		$i 		 	= $i+1;
		$chr_header = substr($f, 0, 16);
		$chk_header = ord(substr($f, 16, 1));
		$res_header = str_split($chr_header);
		$chr_header = 0;
		
		foreach($res_header as $r) $chr_header ^= ord($r);
			
		$chr_header = (~$chr_header) & 0xff;

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
	
	echo '
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<b>MENSAGEM:</b> '.$msg.'
	</div>
	';

	fclose($file);
?>