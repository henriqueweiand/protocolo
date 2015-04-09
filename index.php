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

        <form name="formProtocolo" id="formProtocolo" method="post" action="" enctype="multipart/form-data">

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
                                <input type="text" class="form-control" name="" maxlength="15">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Endereço destino</label>
                                <input type="text" class="form-control" name="" maxlength="15">
                            </div>

                            <div role="tabpanel">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#mensagem" aria-controls="mensagem" role="tab" data-toggle="tab">Mensagem</a></li>
                                    <li role="presentation"><a href="#arquivo" aria-controls="arquivo" role="tab" data-toggle="tab">Arquivo(s)</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="mensagem">

                                        <div class="form-group col-md-12" style="padding-top:10px">
                                            <label for="">Mensagem</label>
                                            <textarea class="form-control" rows="5"></textarea>
                                        </div>
                                        
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="arquivo">

                                        <div class="form-group col-md-12" style="padding-top:10px">
                                            <label for="">Arquivo(s)</label>
                                            <input type="file" class="form-control" name="" disabled>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END .tabpanel -->

                        </div>
                        <!-- END .panel-body -->

                        <div class="panel-footer text-right">
                            <button type="reset" class="btn btn-default">Resetar formulário</button>
                            <button type="button" class="btn btn-success">Enviar</button>             
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
    
});
</script>