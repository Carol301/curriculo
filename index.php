<!DOCTYPE html>

<?php
    if (!isset($nome))
    {
        $nome = '';
    }
    if (!isset($email))
    {
    $email = '';
    }
    if (!isset($telefone))
    {
        $telefone = '';
    }
    if (!isset($cargo))
    {
        $cargo = '';
    }
    if (!isset($obs))
    {
        $obs = '';
    }
?>

<head>
    <title>Envio de Currículo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery.maskedinput.min.js"></script>
    <script src="js/maskphone.js"></script>
    
</head>
<html>
<body>
<div class="content">
<div class="container">
<div class="row">
<div class="col-md-6">
<img src="images/undraw_remotely_2j6y.svg" alt="Image" class="img-fluid">
</div>
<div class="col-md-6 contents">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="mb-4">
<h3>Envio de Currículo</h3>
<p class="mb-4">Envie seus dados e anexe seu currículo.</p>
</div>  

<form action="php/upload.php" method="post" enctype="multipart/form-data">

    <div class="form-group first">
    <label for="nome">Nome completo</label>
    <input type="text" name="nome" class="form-control" required maxlength="255" value="<? echo $nome;?>">
    </div>

    <div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" required maxlength="255" placeholder="exemplo@email.com" value="<? echo $email;?>">
    </div>

    <div class="form-group">
    <label for="telefone">Telefone</label>
    <input id="fone" type="text" name="telefone" class="fone form-control" required placeholder="(99) 99999-9999" value="<? echo $telefone;?>">
    </div> 

    <div class="form-group">
    <label for="cargo">Cargo desejado</label>
    <input type="text" name="cargo" class="form-control" required maxlength="255" value="<? echo $cargo;?>">
    </div> 

    <div class="form-group">
    <label for="escolaridade">Escolaridade</label>
    <select name="escolaridade" class="form-control" required>
        <option disabled selected value=""> Escolha uma opção </option>
        <option value="1"> Ensino Médio Completo </option>
        <option value="2"> Ensino Superior Completo </option>
        <option value="3"> Ensino Médio em Andamento </option>
        <option value="4"> Ensino Superior em Andamento </option>
    </select>
    </div> 

    <div class="form-group">
    <label for="obs">Observações</label>
    <textarea name="obs" class="form-control" maxlength="2000" rows="5" cols="40"><? echo $obs;?></textarea>
    </div> 

    <div class="form-group grupo-enviar">
    <label for="fileToUpload" class="btn enviar btn-primary" >Anexar currículo</label>
    <input type="file" name="fileToUpload" id="fileToUpload" class="btn btn-block" required> 
    <br>Tamanho Máximo:1MB.</div>

    <input type="submit" name="submit" value="Enviar currículo" class="btn btn-block btn-primary" required>
    </div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
