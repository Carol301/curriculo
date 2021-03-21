<!DOCTYPE html>

<head>
    <title>Confirmação de envio</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/jquery.maskedinput.min.js"></script>
    <script src="../js/maskphone.js"></script>
    
</head>
<html>
<body>
<div class="content">
<div class="container">
<a href="../">Voltar</a> 
<div class="row">
<div class="col-md-6">
<img src="../images/undraw_remotely_2j6y.svg" alt="Image" class="img-fluid">
</div>
<div class="col-md-6 contents">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="mb-4">
<h3>Status do envio</h3>
</div>
<form>
<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$mimeType = ''; 

// Verificar se o arquivo de documento é realmente um documento.
if (isset($_POST["submit"]))
{
    $mimeType = mime_content_type($_FILES["fileToUpload"]["tmp_name"]);
    if($mimeType !== false) {
        echo "<p class='mb-4'> O arquivo é um Documento - " . $mimeType . ".</p><br>";
        $uploadOk = 1;
    } else {
        echo "<p class='mb-4'> O arquivo não é um documento válido.</p><br>";
        $uploadOk = 0;
    }
}
else 
{ 
    header("Location: ../ ");
    exit();
}

// Verifica se o arquivo existe ou não.
if (file_exists($target_file))
{
    echo "<p class='mb-4'> Desculpe, esse arquivo já existe.</p><br>";
    $uploadOk = 0;
}

// Verifica o tamanho do arquivo.
if ($_FILES["fileToUpload"]["size"] > 1000000)
{
    echo "<p class='mb-4'> Desculpe, seu documento é muito grande. Tamanho máximo é 1MB.</p><br>";
    $uploadOk = 0;
}

// Permitir somente arquivos DOC, DOCX, PDF.
if ($fileType != "doc" && $fileType != "docx" && $fileType != "pdf")
{
    echo "<p class='mb-4'> Desculpe, apenas arquivos do tipo doc, docx e pdf são permitidos.</p><br>";
    $uploadOk = 0;
}

// Verifica se a variavel $uploadOk é 0 devido ao erro.
if ($uploadOk == 0)
{
    echo "<p class='mb-4'>Não foi possivel fazer o envio do seu arquivo.</p><br>";
}
else
{
    $escotxt = '';
    switch ($_POST['escolaridade']) {
        case '1':
            $escotxt = "Ensino Médio Completo"; 
            break;
        case '2':
            $escotxt = "Ensino Superior Completo"; 
            break;
        case '3':
            $escotxt = "Ensino Médio em Andamento"; 
            break;    
        case '4':
            $escotxt = "Ensino Superior em Andamento"; 
            break; 
    }

    // Se tudo está ok, tenta fazer upload do arquivo.
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
    {
        $basename = basename( $_FILES["fileToUpload"]["name"]);

        $DB_HOST = 'localhost';
        $DB_NOME = 'files';
        $DB_UID = 'root';
        $DB_SENHA = '';

        // Abre conexão com o banco
        $conn = sprintf("mysql:host=%s;dbname=%s;charset=utf8",
                    $DB_HOST,
                    $DB_NOME
                );

        try
        {
            $pdo = new PDO($conn, $DB_UID, $DB_SENHA);
            
            $blob = fopen($target_file, 'rb');

            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $telefone = $_POST['telefone']; 
            $cargo = $_POST['cargo'];
            $escolaridade = $_POST['escolaridade'];
            $obs = $_POST['obs'];
            $datahora = date('Y-m-d H:i:s');
            $ip_cliente = '';

            if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                // IP da internet compartilhada
                $ip_cliente = $_SERVER['HTTP_CLIENT_IP'];
            }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                // IP passado pelo proxy (caso houver)
                $ip_cliente = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }else{
                $ip_cliente = $_SERVER['REMOTE_ADDR'];
            }

            $sql = "INSERT INTO uploaded_files(
                mime,data,nome,email,telefone,cargo,
                escolaridade,observacoes,datahora,ip_cliente) 
                VALUES(:mime,:data,:nome,:email,:telefone,:cargo,
                :escolaridade,:observacoes,:datahora,:ip_cliente)";
            
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':mime', $mimeType);
            $stmt->bindParam(':data', $blob, PDO::PARAM_LOB);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':cargo', $cargo);
            $stmt->bindParam(':escolaridade', $escolaridade);
            $stmt->bindParam(':observacoes', $obs);
            $stmt->bindParam(':datahora', $datahora);
            $stmt->bindParam(':ip_cliente', $ip_cliente);
            
            $stmt->execute(); 

            echo "<p class='mb-4'> O arquivo ". htmlspecialchars($basename). " foi enviado.</p>";

            $to = $email;
            $subject = "Paytour - Confirmação de envio de curriculo";

            $message = "
            <html>
            <head>
            <title>Paytour - Confirmação de envio de curriculo</title>
            <style>
            table, td, th {
            border: 1px solid black;
            }
            body {
            font-family: Arial,sans-serif;
            }
            table { 
            border-collapse: collapse;
            }
            </style> 
            </head> 
            <body>
            <p>Paytour agradece a sua canditadura no site, entraremos em contado nos próximos dias.</p>
            <p>Confirmação dados enviados:</p>
            <table>
            <tr>
            <td>Nome:</td> 
            <td>".$nome."</td>
            </tr>

            <tr>
            <td>Email:</td> 
            <td>".$email."</td>
            </tr>

            <tr>
            <td>Telefone:</td> 
            <td>".$telefone."</td>
            </tr>
            
            <tr>
            <td>Cargo Desejado:</td> 
            <td>".$cargo."</td>
            </tr>

            <tr>
            <td>Escolaridade:</td> 
            <td>".$escotxt."</td>
            </tr>

            <tr>
            <td>Observações:</td> 
            <td>".$obs."</td>
            </tr> 

            <tr>
            <td>Data e Hora:</td> 
            <td>".$datahora."</td>
            </tr>

            <tr>
            <td>IP:</td> 
            <td>".$ip_cliente."</td>
            </tr>

            </table>
            </body>
            </html> 
            ";
  
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: <carolina.vrendo@gmail.com>" . "\r\n";
            $headers .= "Reply-To: <carolina.vrendo@gmail.com>" . "\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

            mail($to,$subject,$message,$headers);
            
        } catch (PDOException $e)
        {
            echo "<p class='mb-4'>".$e->getMessage()."</p>";
        }

        
    }
    else
    {
        echo " <p class='mb-4'> Ocorreu um erro ao enviar o arquivo.</p><br>";
    }
}

?>

</form>
</div>
</div>
</div>
</div>
</div>
</div>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>

</body>
</html>