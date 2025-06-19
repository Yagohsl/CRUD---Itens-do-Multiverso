<?php
// Variáveis do formulário
$nome = $cpf = $email = $telefone = $senha = "";
$cep = $rua = $bairro = $cidade = "";
$erro_cep = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados gerais
    $nome = $_POST['nome'] ?? "";
    $cpf = $_POST['cpf'] ?? "";
    $email = $_POST['email'] ?? "";
    $telefone = $_POST['telefone'] ?? "";
    $senha = $_POST['senha'] ?? "";

    if (isset($_POST['buscar_cep'])) {
        // Buscar endereço pelo CEP
        $cep = preg_replace('/\D/', '', $_POST['cep'] ?? "");

        if (strlen($cep) === 8) {
            $url = "https://viacep.com.br/ws/$cep/json/";
            $resposta = file_get_contents($url);

            if ($resposta !== false) {
                $dados = json_decode($resposta, true);

                if (!isset($dados['erro'])) {
                    $rua = $dados['logradouro'] ?? '';
                    $bairro = $dados['bairro'] ?? '';
                    $cidade = $dados['localidade'] ?? '';
                } else {
                    $erro_cep = "CEP não encontrado.";
                }
            } else {
                $erro_cep = "Erro ao consultar a API ViaCEP.";
            }
        } else {
            $erro_cep = "CEP inválido.";
        }
    }

    // Aqui você pode colocar o código para salvar os dados quando clicar em "Salvar"
    if (isset($_POST['salvar'])) {
        // Código para salvar os dados no banco, etc.
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" href="./images/logo.png" type="image/png">


  <title>MultiShop</title>
</head>
<?php
$tipo_navbar = 'simples'; 
include '../navbar/nav_bar.php';
?>
<body>
    
    <?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
    
    <form method="POST" action="" class="login">
        <h1 class="title-painel">Cadastro de Usuários</h1>
        <!-- Campos usuais -->
        <div class="mb-3">
            <label for="nome" class="form-label label-painel">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control input-painel" maxlength="50" required value="<?= htmlspecialchars($nome) ?>">
        </div>
        <div class="mb-3 ">
            <label for="cpf" class="form-label label-painel">CPF</label>
            <input type="text" name="cpf" id="cpf" class="form-control input-painel" maxlength="14" required value="<?= htmlspecialchars($cpf) ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label label-painel">Email</label>
            <input type="email" name="email" id="email" class="form-control input-painel" maxlength="50" required value="<?= htmlspecialchars($email) ?>">
        </div>
        <div class="mb-3 ">
            <label for="telefone" class="form-label label-painel">Telefone</label>
            <input type="tel" name="telefone" id="telefone" class="form-control input-painel" maxlength="20" required value="<?= htmlspecialchars($telefone) ?>">
        </div>

        <!-- CEP com botão buscar -->
        <div class="mb-3 ">
            <label for="cep" class="form-label label-painel">CEP</label>
            <input type="text" name="cep" id="cep" class="form-control input-painel" maxlength="9" required placeholder="00000-000" value="<?= htmlspecialchars($cep) ?>">
        </div>
        <button type="submit" name="buscar_cep" class="buscar btn-buscar">Buscar CEP</button>

        <!-- Campos endereço preenchidos pela API -->
        <div class="mb-3 ">
            <label for="rua" class="form-label label-painel">Rua</label>
            <input type="text" name="rua" id="rua" class="form-control input-painel" readonly value="<?= htmlspecialchars($rua) ?>">
        </div>
        <div class="mb-3 ">
            <label for="bairro" class="form-label label-painel">Bairro</label>
            <input type="text" name="bairro" id="bairro" class="form-control input-painel" readonly value="<?= htmlspecialchars($bairro) ?>">
        </div>
        <div class="mb-3 ">
            <label for="cidade" class="form-label label-painel">Cidade</label>
            <input type="text" name="cidade" id="cidade" class="form-control input-painel" readonly value="<?= htmlspecialchars($cidade) ?>">
        </div>

        <div class="mb-3 ">
            <label for="senha" class="form-label label-painel">Senha</label>
            <input type="password" name="senha" id="senha" class="form-control" maxlength="25" required value="<?= htmlspecialchars($senha) ?>">
        </div>

        <button type="submit" name="salvar" class="buscar btn-buscar">Salvar</button>
    </form>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
