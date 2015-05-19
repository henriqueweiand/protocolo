<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt_BR">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta property="og:title" content="Sistema de protocolo - CNEC Osório"/>
        <meta property="og:type" content="website"/>
        <meta property="og:site_name" content="Sistema de protocolo - CNEC Osório"/>
        <meta name="robots" content="index, follow" />
        <meta name="keywords" content="Faculdade Cenecista de Osório, CNEC, FACOS, cenecista, Universidade, Faculdade, Curso, Osório, RS, EAD, Informatica, licenciatura, educacao, aula, trabalho" />
        <meta name="author" content="Henrique Weiand" />
        <meta property="og:description" content="Sistema desenvolvido na disciplina de Redes, simulando um protocolo"/>
        <meta name="title" content="Sistema protocolo" />
        <meta name="description" content="Sistema desenvolvido na disciplina de Redes, simulando um protocolo" />
        
        <link type="image/x-icon" rel="icon" href="/favicon.ico">
		<link type="image/x-icon" rel="shortcut icon" href="/favicon.ico" >

        <script src="framework/jquery-1.11.2.min.js"></script>
        <script src="framework/index.js"></script>
        <script src="framework/bootstrap/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="framework/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="framework/bootstrap/css/bootstrap-theme.min.css">

        <title>Sistema Protocolo</title>
    </head>
    <body>

        <form data-ajax="true" progressbar=".progressbarFile" name="formProtocolo" id="formProtocolo" method="POST" action="montaProtocolo.php" onsubmit="return false;" enctype="multipart/form-data">

            <div class="container-fluid">

                <div class="row">

                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <h1 class="panel-title">Protocolo</h1>
                        </div>
                        <!-- END .panel-headering -->

                        <div class="panel-body">
                            
                            <div class="col-md-12" id="result"></div>
                            
                            <div class="form-group col-md-6">
                                <label for="">Endereço de origem</label>
                                <input type="text" class="form-control" name="origem" maxlength="32" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Endereço destino</label>
                                <input type="text" class="form-control" name="destino" maxlength="32" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
                            </div>

                            <div role="tabpanel">
                                <ul id="tabs" class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#mensagem" aria-controls="mensagem" role="tab" data-toggle="tab">Enviar Mensagem</a></li>
                                    <li role="presentation"><a href="#enviarArquivo" aria-controls="enviarArquivo" role="tab" data-toggle="tab">Enviar Arquivo</a></li>
                                    <li role="presentation"><a href="#arquivo" aria-controls="arquivo" role="tab" data-toggle="tab">Processar Arquivo</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="mensagem">

                                        <div class="form-group col-md-12" style="padding-top:10px">
                                            <label for="">Mensagem</label>
                                            <textarea class="form-control" rows="5" name="mensagem"></textarea>
                                        </div>
                                        
                                    </div>
                                    
                                    <div role="tabpanel" class="tab-pane" id="enviarArquivo">
                                        <div class="form-group col-md-12">
                                            
                                            <div class="form-group col-md-12" style="padding-top:10px">
                                                <label for="">Arquivo</label>
                                                <input class="form-control" name="file" id="file" type="file" disabled />
                                            </div>
                                            
                                            <div class="progressbarFile col-md-12">
                                				<div class="progress" style="display:none;">
                                					<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                				</div>
                                			</div>
                                            
                                        </div>
                                    </div>
                                    
                                    <div role="tabpanel" class="tab-pane" id="arquivo">

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
                                                            <a class="list-group-item active">Arquivo da mensagem</a>
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

                                    </div>
                                </div>
                            </div>
                            <!-- END .tabpanel -->

                        </div>
                        <!-- END .panel-body -->

                        <div class="panel-footer text-right">
                            <a href="/Trabalho T3 - 20151.pdf" target="_blank"><button type="button" class="btn btn-default">Baixar Enunciado</button></a>
                            <button type="button" class="btn btn-success" name="btnEnviar">Enviar protocolo</button>
                        </div>
                        <!-- END .panel-footer -->

                    </div>
                    <!-- END .panel -->

                </div>
                <!-- END .row -->

            </div>
            <!-- END .oontainer-fluid -->

        </form>

    </body>
</html>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $('[data-toggle="tooltip"]').tooltip();
  
    $('[name=btnEnviar]').bind('click', function() {

        var form = $('[name=formProtocolo]');

        if(form.attr('progressbar')) {
            send(form, { progressbar : form.attr('progressbar') });
        } else {
            send(form);
        }
        
    });
    
    $('#tabs a').click(function (e) {
        divID = $(this).attr("href");
        
        $("#mensagem, #enviarArquivo").find("textarea, input").prop("disabled", true);
        
        switch(divID) {
            case '#arquivo':
                $('#result').html("");
                $("[name=btnEnviar]").text("Receber arquivo");
                $("[name=formProtocolo]").attr("action", "lerProtocolo.php");
            break;
            
            case '#mensagem':
                $(divID).find("textarea").prop("disabled", false);
                $("[name=btnEnviar]").text("Enviar protocolo");
                $("[name=formProtocolo]").attr("action", "montaProtocolo.php");
            break;
            
            case '#enviarArquivo':
                $('#result').html("");
                $(divID).find("input").prop("disabled", false);
                $("[name=btnEnviar]").text("Enviar arquivo");
                $("[name=formProtocolo]").attr("action", "montaProtocolo.php");
            break;
        }
        
        e.preventDefault()
        $(this).tab('show');
    })
});
</script>