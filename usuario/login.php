<?php
session_start();
include '../db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM adm WHERE email = ? AND senha = ?");
    $stmt->execute([$email, $senha]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['admin'] = true;
        header('Location: ../admin/admin.php');
        exit;
    } else {
        $erro = "Usuário ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login ADM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" href="./images/logo.png" type="image/png">

</head>
<?php
$tipo_navbar = 'simples'; 
include '../navbar/nav_bar.php';
?>
<body>
  <?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
<form method="post" class="login">
  <h1 class="title-painel">Login Administrativo</h1>
  <br><br>
  <div class="mb-3">
    <label for="Email1" class="form-label label-painel">E-mail</label>
    <input type="email" class="form-control input-painel" id="exampleInputEmail1" aria-describedby="emailHelp"name="email" placeholder="danieldazl@hotmail.com" required>

  <div class="mb-3">
    <label for="Password" class="form-label label-painel">Senha</label>
    <input type="password" class="form-control input-painel" id="exampleInputPassword1" name="senha" placeholder="Digite sua senha" required>
  </div>

  <button type="submit" class="buscar btn-buscar">Entrar</button>
</form>

 

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>
</html>

