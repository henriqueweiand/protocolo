<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt_BR">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <script src="framework/jquery-1.11.2.min.js"></script>
        <script src="framework/bootstrap/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="framework/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="framework/bootstrap/css/bootstrap-theme.min.css">

        <title>Protocolo testea</title>
    </head>
    <body>

        <form name="formProtocolo" id="formProtocolo" method="GET" action="montaProtocolo.php">

            <div class="container-fluid">

                <div class="row">

                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <h1 class="panel-title">Protocolo</h1>
                        </div>
                        <!-- END .panel-headering -->

                        <div class="panel-body">
                            
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
                                    <li role="presentation" class="active"><a href="#mensagem" aria-controls="mensagem" role="tab" data-toggle="tab">Mensagem <small>(Enviar)</small></a></li>
                                    <li role="presentation"><a href="#arquivo" aria-controls="arquivo" role="tab" data-toggle="tab">Arquivo <small>(Receber)</small></a></li>
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="mensagem">

                                        <div class="form-group col-md-12" style="padding-top:10px">
                                            <label for="">Mensagem</label>
                                            <textarea class="form-control" rows="5" name="mensagem"></textarea>
                                        </div>
                                        
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="arquivo">

                                        <div class="form-group col-md-12">
                                            <?php 
                                            $files = scandir('/home/ubuntu/workspace/arquivos');
                                            unset($files[0]);
                                            unset($files[1]);
                                            sort($files);
                                            
                                            // < Verifica se já foi enviado arquivos
                                            if(!empty($files)) {
                                                
                                                // < Percorre os arquivos enviados
                                                foreach($files as $file) {
                                                    
                                                    list($data['grupo'], $data['nome'], $data['extensao']) = explode('.', $file);
                                                    
                                                    if($data['grupo'] != @$grupo) {
                                                        $grupo = $data['grupo'];
                                                        echo '
                                                        <div class="list-group" style="margin-top:15px; margin-bottom:0px">
                                                            <a href="#" class="list-group-item active">
                                                                Arquivos da mensagem
                                                            </a>
                                                        ';
                                                    }
                                                    
                                                    echo '<a href="#" class="list-group-item">'.$data['nome'].'.'.$data['extensao'].'</a>';
                                                    
                                                    if($data['grupo'] != @$grupo) {
                                                        echo '</div>';
                                                    }
                                                    
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
                            <button type="reset" class="btn btn-default">Resetar formulário</button>
                            <button type="submit" class="btn btn-success" name="btnEnviar">Enviar</button>             
                        </div>
                        <!-- END .panel-footer -->
                        
                        <div class="col-md-12 result">
                            
                        </div>

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
    
    $('#tabs a').click(function (e) {
        divID = $(this).attr("href");
        
        if(divID == '#arquivo') {
            $("#arquivo").find("input").prop("disabled", false);
            $("#mensagem").find("input, textarea").prop("disabled", true);
            $("button[name=btnEnviar]").text("Receber");
            $("#formProtocolo").attr("action", "lerProtocolo.php");
        } else {
            $("#arquivo").find("input").prop("disabled", true);
            $("#mensagem").find("input, textarea").prop("disabled", false);
            $("button[name=btnEnviar]").text("Enviar");
            $("#formProtocolo").attr("action", "montaProtocolo.php");
        }
        
        e.preventDefault()
        $(this).tab('show');
    })
});
</script>