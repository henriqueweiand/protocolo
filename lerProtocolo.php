<?php
	
	$filename = "/home/ubuntu/workspace/arquivos/1.protocolo.txt";

	$file = fopen($filename, "rb");

	$fread = str_split(fread ($file, filesize ($filename)), (4096+26));
	
	$msg = "";
	
	foreach($fread as $i=>$f) {
		
		$i = $i+1;
		
		$chr_header = substr($f, 0, 16);
		$chk_header = ord(substr($f, 16, 1));

		$res_header = str_split($chr_header);
		
		$chr_header = 0;
		
		foreach($res_header as $r)
			$chr_header^= ord($r);
			
		$chr_header = (~$chr_header) & 0xff;

		if($chr_header != $chk_header)
			exit("o checksum do header da sequencia ".$i." esta errado.");
		
		$chr_f = substr($f, 0, -2);
		$chk_f = ord(substr($f, -2, 1)).ord(substr($f, -1, 1));
		$res_f = str_split($chr_f);

		foreach($res_f as $r)
			$chr_f+= ord($r);
			
		$chr_f = (~$chr_f) & 0xffff;
		
		$chr_f = implode("", array_map("hexdec", array_reverse(str_split(dechex($chr_f), 2))));

		if($chr_f != $chk_f)
			exit("o checksum final da sequencia ".$i." esta errado.");
		
		$msg.= substr($f, 18, -4);
	}
	
	echo "A mensagem: ".$msg;

	fclose($file);

?>