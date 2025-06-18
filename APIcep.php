<?php
// Variáveis para preencher os campos com os dados da API, se já foram buscados
$cep = $rua = $bairro = $cidade = "";
 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cep'])) {
    //\D (maiúsculo) remove qualquer coisa que não seja número vindo do form
    $cep = preg_replace('/\D/', '', $_POST['cep']); // Remove caracteres não numéricos
// Verifica se o CEP tem 8 dígitos
    // O CEP deve ter 8 dígitos, então verificamos se o tamanho é 8
    if (strlen($cep) === 8) {
        // URL da API ViaCEP
        $url = "https://viacep.com.br/ws/$cep/json/";
 
        // Consulta a API ViaCEP usando file_get_contents ê o conteúdo de um arquivo ou URL, e retorna esse conteúdo como uma string.
        $resposta = file_get_contents($url);
        $dados = json_decode($resposta, true);
 
        if (!isset($dados['erro'])) {
            // Preenche os campos com os dados retornados
            $rua    = $dados['logradouro'] ?? '';
            $bairro = $dados['bairro'] ?? '';
            $cidade = $dados['localidade'] ?? '';
        } else {
            echo "<p style='color:red;'>CEP não encontrado.</p>";
        }
    } else {
        echo "<p style='color:red;'>CEP inválido.</p>";
    }
}
?>
 
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Formulário com ViaCEP em PHP</title>
</head>
<body>
  <h2>Formulário de Endereço</h2>
 
  <form method="POST">
    <label>CEP:</label><br>
    <input type="text" name="cep" value="<?= htmlspecialchars($cep) ?>">
    <button type="submit">Buscar</button><br><br>
 
    <label>Rua:</label><br>
    <input type="text" name="rua" value="<?= htmlspecialchars($rua) ?>"><br><br>
 
    <label>Bairro:</label><br>
    <input type="text" name="bairro" value="<?= htmlspecialchars($bairro) ?>"><br><br>
 
    <label>Cidade:</label><br>
    <input type="text" name="cidade" value="<?= htmlspecialchars($cidade) ?>"><br><br>
 
    <button type="submit">Enviar</button>
  </form>
</body>
</html>