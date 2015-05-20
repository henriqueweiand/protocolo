<div class="form-group col-md-12">
    <?php 
    $files = scandir($_SERVER['DOCUMENT_ROOT']."/arquivos/"); // Arquivos da pasta
    unset($files[0]);
    unset($files[1]);
    sort($files); // Reordena o array
    
    // < Verifica se já foi enviado arquivos
    if(!empty($files)) {
        
        // < Percorre os arquivos enviados
        foreach($files as $file) {
            list($data['grupo'], $data['nome'], $data['extensao']) = explode('.', $file);
            
            if($data['grupo'] != @$grupo) {
                $grupo = $data['grupo'];
                echo '
                <div class="list-group" style="margin-top:15px; margin-bottom:0px">
                    <a class="list-group-item active">Arquivo processado</a>
                ';
            }
            
            echo '
            <a class="list-group-item" target="_blank" href="/arquivos/'.$data['grupo'].'.'.$data['nome'].'.'.$data['extensao'].'">
                <span class="glyphicon glyphicon-download" aria-hidden="true" title="Baixar" data-toggle="tooltip" data-placement="top"></span>
                '.$data['nome'].'.'.$data['extensao'].'
            </a>';
            
            if($data['grupo'] != @$grupo) echo '</div>';
        }
        // < Percorre os arquivos enviados
        
    } else {
        // Nao foi enviado nada ainda
    }
    // > Verifica se já foi enviado arquivos
    ?>
    
</div>