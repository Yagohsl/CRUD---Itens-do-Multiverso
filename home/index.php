<?php
include '../db/db.php';
$stmtCarrossel = $pdo->query("SELECT * FROM produto ORDER BY preco DESC LIMIT 6");
$produtos_carrossel = $stmtCarrossel->fetchAll();


$busca = $_GET['busca'] ?? '';
$categoria = $_GET['categoria'] ?? '';

$sql = "SELECT * FROM produto WHERE nome LIKE ? AND categoria LIKE ?";
$stmt = $pdo->prepare($sql);
$stmt->execute(["%$busca%", "%$categoria%"]);
$produtos_receitas = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" href="../images/logo.png" type="image/png">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart" />
  <title>MultiShop</title>
</head>
<?php
$tipo_navbar = 'completa'; 
include '../navbar/nav_bar.php';
?>


  <body>
    
<!-- Offcanvas lateral -->
<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" 
     id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Seu Carrinho</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar" data-bs-theme="dark" ></button>
  </div>
  <div class="offcanvas-body">
  <ul id="carrinho-itens" class="list-group mb-3"></ul>
  <p id="carrinho-vazio">Seu carrinho está vazio por enquanto.</p>
  
  <div class="mt-4 d-flex justify-content-between align-items-center border-top pt-3">
  <strong>Total:</strong>
  <span id="preco-total" class="fw-bold">0 créditos</span>
</div>

</div>

</div>

    <h1 class ="title-painel">Produtos mais procurados</h1>

    <div class="carousel" mask>
  <?php foreach ($produtos_carrossel as $p): ?>
    <article>
      <div class="r-carousel">
        <img src="data:image/jpeg;base64,<?= base64_encode($p['imagem']) ?>" alt="<?= htmlspecialchars($p['nome']) ?>" class="img-receita">
        <h2><?= htmlspecialchars($p['nome']) ?></h2>
        <p class="cont-receita preco mt-auto"><br> <?= nl2br($p['preco']) ?> créditos</p>
        <a href="#" class="btn btn-outline-success mt-auto add-to-cart" data-nome="<?= htmlspecialchars($p['nome']) ?>" data-preco="<?= htmlspecialchars($p['preco']) ?>">Adicionar ao carrinho</a>
        

    </article>
  <?php endforeach; ?>
</div>

    <h1 class ="title-painel">Todos os nossos produtos</h1>


<div class="receitas">
  <?php foreach ($produtos_receitas as $p): ?>
    <div class="receita">
      <h3 class="title-receita"><?= htmlspecialchars($p['nome']) ?></h3>
      <img src="data:image/jpeg;base64,<?= base64_encode($p['imagem']) ?>" alt="Imagem do produto" class="img-receita">
      <p class="cont-receita">
        <strong>Categoria</strong> 
        <br>
        <?= htmlspecialchars($p['categoria']) ?>
      </p>
      <p class="cont-receita"><strong>Descrição</strong><br> <?= nl2br($p['descricao']) ?></p>
      <p class="cont-receita preco mt-auto"><br> <?= nl2br($p['preco']) ?> créditos</p>
      <a href="#" class="btn btn-outline-success mt-auto add-to-cart" data-nome="<?= htmlspecialchars($p['nome']) ?>" data-preco="<?= htmlspecialchars($p['preco']) ?>">Adicionar ao carrinho</a>

    </div>
  <?php endforeach; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="./js/script.js"></script>

</body>
</html>
