<?php

	 function datadma($data){
		if($data!=""){
		  $dataArray = explode("-",$data); 
		  $data = $dataArray[2]."/".$dataArray[1]."/".$dataArray[0];
		}
	   return $data;	 
	 }
	 
	 function dataamd($data){
		if($data!=""){
		  $dataArray = explode("/",$data); 
		  $data = $dataArray[2]."-".$dataArray[1]."-".$dataArray[0];
		} 
		return $data; 
	 }
	 
	function FormatValor($valor) {
		$valor = preg_replace("/[^0-9\.]/", "", str_replace(',','.',$valor));
		if (substr($valor,-3,1)=='.') {
			$sents = '.'.substr($valor,-2);
			$valor = substr($valor,0,strlen($valor)-3);
		} elseif (substr($valor,-2,1)=='.') {
			$sents = '.'.substr($valor,-1);
			$valor = substr($valor,0,strlen($valor)-2);
		} else {
			$sents = '.00';
		}
		$valor = preg_replace("/[^0-9]/", "", $valor);
		return number_format($valor.$sents,2,'.','');
	}

	function deletarDiretorio($dir) { 
      $files = array_diff(scandir($dir), array('.','..')); 
      foreach ($files as $file) { 
        (is_dir("$dir/$file")) ? deletarDiretorio("$dir/$file") : unlink("$dir/$file"); 
      } 
      return rmdir($dir); 
    }
 
?>