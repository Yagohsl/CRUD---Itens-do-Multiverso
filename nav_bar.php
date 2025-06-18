<nav class=" navbar navbar-expand-lg sticky-top " >
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">MultiShop</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active " aria-current="page" href="login.php">Admin</a>
          </li>
  
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Categorias
            </a>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="?categoria=">Todas</a></li>
            <li><a class="dropdown-item" href="?categoria=Ben 10">Ben 10</a></li>
            <li><a class="dropdown-item" href="?categoria=Star Wars">Star Wars</a></li>
            </ul>
          </li>
  
        </ul>
        <form class="d-flex" role="search" method="get">
          <input class="form-control me-2 buscar" type="search" placeholder="Buscar por nome" aria-label="Search" name="busca"/>
          <button class="buscar btn-buscar" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>