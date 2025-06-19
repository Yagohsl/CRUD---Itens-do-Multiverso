<?php
if (!isset($tipo_navbar)) {
  $tipo_navbar = 'completa'; // valor padrão
}
include '../db/db.php'; // já deve estar incluído

// pega todas as categorias distintas
$stmt = $pdo->query("SELECT DISTINCT categoria FROM produto ORDER BY categoria ASC");
$categorias = $stmt->fetchAll(PDO::FETCH_COLUMN);



if ($tipo_navbar === 'completa'): ?>
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">MultiShop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Usuário -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Usuário</a>
          <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="./usuario/login.php">Login</a></li>
          <li><a class="dropdown-item" href="./usuario/cadastro.php">Cadastro</a></li>
          </ul>
        </li>

        <!-- Categorias -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Categorias</a>
          <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="?categoria=">Todas</a></li>
          <?php foreach ($categorias as $cat): ?>
          <li><a class="dropdown-item" href="?categoria=<?= urlencode($cat) ?>"><?= htmlspecialchars($cat) ?></a></li>
          <?php endforeach; ?>
        </ul>

        </li>
      </ul>

      <!-- Ícone do carrinho -->
<!-- Botão do carrinho (ícone com offcanvas) -->
<button class="btn nav-link me-3 d-flex align-items-center" type="button"
        data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" 
        aria-controls="offcanvasWithBothOptions" style="background: none; border: none;">
  <span class="material-symbols-outlined" style="font-size: 40px;">shopping_cart</span>
</button>



      <!-- Campo de busca -->
      <form class="d-flex" role="search" method="get">
        <input class="form-control me-2 buscar input-buscar ms-auto" type="search" placeholder="Buscar por nome" name="busca">
        <button class="buscar btn-buscar ms-auto" type="submit">Buscar</button>
      </form>
    </div>
  </div>
</nav>


<?php elseif ($tipo_navbar === 'simples'): ?>
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">MultiShop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Usuário
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="./login.php">Login</a></li>
            <li><a class="dropdown-item" href="./cadastro.php">Cadastro</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php elseif ($tipo_navbar === 'admin'): ?>
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">MultiShop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Usuário
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../usuario/login.php">Login</a></li>
            <li><a class="dropdown-item" href="../usuario/cadastro.php">Cadastro</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categorias
          </a>
          <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="?categoria=Adicionar">Adicionar Produto</a></li>
          <li><a class="dropdown-item" href="?categoria=Deletar">Deletar Produto</a></li>
          <li><a class="dropdown-item" href="?categoria=Editar">Editar Produto</a></li>

          </ul>
        </li>

      </ul>
      
    </div>
  </div>
</nav>
<?php endif; ?>
