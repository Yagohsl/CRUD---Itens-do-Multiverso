<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['admin'])) {
  echo "Acesso negado.";
  exit;
}
include '../db/db.php';
if (!isset($_GET['categoria'])) {
  header("Location: ?categoria=Adicionar");
  exit;
}

$stmtCat = $pdo->query("SELECT DISTINCT categoria FROM produto ORDER BY categoria ASC");
$categorias = $stmtCat->fetchAll(PDO::FETCH_COLUMN);

/*php para adicionar produto*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['categoria'] === 'Adicionar') {
  if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $nome = $_POST['nome'];
    $categoria = $_POST['categoria'];
    $nova_categoria = trim($_POST['nova_categoria'] ?? '');

    // Se escolheram nova categoria e digitou algo, use ela
    if ($categoria === 'nova' && $nova_categoria !== '') {
      $categoria = $nova_categoria;
      // Opcional: aqui você pode salvar a nova categoria numa tabela separada se quiser
    }

    $preco = $_POST['preco'];
    $desc = $_POST['descricao'];
    $imagem = file_get_contents($_FILES['imagem']['tmp_name']);

    $stmt = $pdo->prepare("INSERT INTO produto (nome, categoria, preco, descricao, imagem) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $categoria, $preco, $desc, $imagem]);
    echo '<div class="alert alert-success" style="font-size: 2rem;">Produto adicionado com sucesso!</div>';
  } 
}



/*php para remover produto*/
if (isset($_GET['categoria']) && $_GET['categoria'] === 'Deletar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];

  $stmt = $pdo->prepare("DELETE FROM produto WHERE id = ?");
  if ($stmt->execute([$id])) {
    echo "<div class='alert alert-success' style='font-size: 2rem;' >Produto deletado com sucesso!</div>";
  } else {
    echo "<div class='alert alert-danger' style='font-size: 2rem;'>Erro ao deletar produto</div>";
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Painel Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" href="./images/logo.png" type="image/png">

</head>
<?php
$tipo_navbar = 'admin'; 
include '../navbar/nav_bar.php';
?>
<body>
  <!-- Formulario de adicionar produtos -->
<?php if (isset($_GET['categoria']) && $_GET['categoria'] === 'Adicionar'): ?>

  <form method="post" enctype="multipart/form-data" class="painel-receita">
    <h1 class="title-painel">Painel Administrativo</h1>
    <br><br>
    <div class="mb-3">
    <label for="nome_receita" class="form-label label-painel" >Nome do Produto</label>
      <input type="text" class="form-control input-painel" name="nome" placeholder="Digite o nome do produto" required>

    <div class="mb-3">
    <label for="categoria_receita" class="form-label label-painel" >Categoria</label>
    <select name="categoria" id="categoria-select" class="form-select input-painel" aria-label="Categorias" onchange="toggleNovaCategoria()">
  <option value="">-- Selecione --</option>
  <?php foreach ($categorias as $cat): ?>
    <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
  <?php endforeach; ?>
  <option value="nova">Nova Categoria...</option>
</select>


  <div class="mb-3" id="nova-categoria-container" style="display:none; margin-top: 1rem;">
    <label for="nova_categoria" class="form-label label-painel">Nome da Nova Categoria</label>
    <input type="text" class="form-control input-painel" name="nova_categoria" id="nova_categoria" placeholder="Digite a nova categoria">
</div>

<script>
  function toggleNovaCategoria() {
    const select = document.getElementById('categoria-select');
    const novaCatDiv = document.getElementById('nova-categoria-container');
    if (select.value === 'nova') {
      novaCatDiv.style.display = 'block';
    } else {
      novaCatDiv.style.display = 'none';
      document.getElementById('nova_categoria').value = '';
    }
  }
</script>

    </div>

    <div class="mb-3">
      <label for="preco" class="form-label label-painel" >Preço</label>
      <textarea class="form-control input-painel"name="preco" placeholder="Digite o preço aqui" required></textarea>
    </div>
      <div class="mb-3">
        <label for="descricao" class="form-label label-painel" >Descrição</label>
        <textarea class="form-control input-painel" id="text-modo-preparo" rows="5"name="descricao" placeholder="Digite a descição do produto aqui" required></textarea>
    </div>
    <div class="mb-3">
      <label for="foto_receita" class="form-label label-painel" >Foto do produto</label>
      <input class="form-control input-painel" type="file" name="imagem" accept="image/*" required>
    </div>
    <button type="submit"class="buscar btn-buscar">Adicionar Produto</button>
  </form>
  <?php endif; ?>

<!--Formulario de Deletar receita -->
<?php
if ($_GET['categoria'] === 'Deletar') {
  $stmt = $pdo->query("SELECT id, nome FROM produto ORDER BY id ASC");
  $receitas = $stmt->fetchAll();

  echo "<div class='container mt-4'>";
  echo "<h1 class='mb-3 title-painel'>Produtos cadastrados</h1>";
  echo "<ul class='list-group'>";
  foreach ($receitas as $receita) {
    echo "<li class='list-group-item input-painel'>ID: {$receita['id']} - {$receita['nome']}</li>";
  }
  echo "</ul>";
  echo "</div>";
}
?>
  <?php if (isset($_GET['categoria']) && $_GET['categoria'] === 'Deletar'): ?>
  <form method="post" class="painel-receita mt-5">
    <h1 class="title-painel">Deletar Produto</h1>
    <div class="mb-3">
      <label for="id" class="form-label label-painel">ID do Produto</label>
      <input type="number" class="form-control input-painel" name="id" placeholder="Digite o ID do produto para deletar" required>
    </div>
    <button type="submit" class="buscar btn-deletar">Deletar Produto</button>
  </form>
<?php endif; ?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_id'])) {
  $id = $_POST['editar_id'];
  $nome = $_POST['nome'];
  $categoria = $_POST['categoria'];
  $preco = $_POST['preco'];
  $descricao = $_POST['descricao'];

  if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
    $stmt = $pdo->prepare("UPDATE produto SET nome=?, categoria=?, preco=?, descricao=?, imagem=? WHERE id=?");
    $stmt->execute([$nome, $categoria, $preco, $descricao, $imagem, $id]);
  } else {
    $stmt = $pdo->prepare("UPDATE produto SET nome=?, categoria=?, preco=?, descricao=? WHERE id=?");
    $stmt->execute([$nome, $categoria, $preco, $descricao, $id]);
  }

  echo "<div class='alert alert-success' style='font-size: 2rem;'>Produto atualizado com sucesso!</div>";
}
?>

<?php if ($_GET['categoria'] === 'Editar'): 
  $stmt = $pdo->query("SELECT id, nome FROM produto ORDER BY id ASC");
  $receitas = $stmt->fetchAll();

  echo "<div class='container mt-4'>";
  echo "<h1 class='mb-3 title-painel'>Produtos cadastrados</h1>";
  echo "<ul class='list-group'>";
  foreach ($receitas as $receita) {
    echo "<li class='list-group-item input-painel'>ID: {$receita['id']} - {$receita['nome']}</li>";
  }
  echo "</ul>";
  echo "</div>";
  ?>
  <form method="get" class="painel-receita" >
    <h1 class="title-painel">Editar Produto</h1>
    <div class="mb-3">
      <label for="id" class="form-label label-painel">Digite o ID do produto para editar</label>
      <input type="hidden" name="categoria" value="Editar">
      <input type="number" class="form-control input-painel" name="id" required>
    </div>
    <button type="submit" class="buscar btn-buscar">Buscar Produto</button>
  </form>
<?php endif; ?>
<!--Editar-->
<?php
if ($_GET['categoria'] === 'Editar' && isset($_GET['id'])) {

  $id = $_GET['id'];
  $stmt = $pdo->prepare("SELECT * FROM produto WHERE id = ?");
  $stmt->execute([$id]);
  $produto = $stmt->fetch();

  if ($produto):
?>
  <form method="post" enctype="multipart/form-data" class="painel-receita">
    <input type="hidden" name="editar_id" value="<?= $produto['id'] ?>">
    <h1 class="title-painel">Editando Produto ID <?= $produto['id'] ?></h1>

    <div class="mb-3">
      <label class="form-label label-painel">Nome</label>
      <input type="text" name="nome" class="form-control input-painel" value="<?= htmlspecialchars($produto['nome']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label label-painel">Categoria</label>
      <input type="text" name="categoria" class="form-control input-painel" value="<?= htmlspecialchars($produto['categoria']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label label-painel">Preço</label>
      <input type="text" name="preco" class="form-control input-painel" value="<?= htmlspecialchars($produto['preco']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label label-painel">Descrição</label>
      <textarea name="descricao" class="form-control input-painel" rows="4"><?= htmlspecialchars($produto['descricao']) ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label label-painel">Imagem</label>
      <input type="file" name="imagem" class="form-control input-painel" accept="image/*">
    </div>

    <button type="submit" class="buscar btn-buscar">Salvar Alterações</button>
  </form>
<?php
  else:
    echo "<div class='alert alert-danger'>Produto não encontrado.</div>";
  endif;
}
?>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>
</html>
