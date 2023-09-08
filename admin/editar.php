<?php
// Inicialize a sessão
session_start();
 
// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "../config.php";

if(isset($_GET["id"])){

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
    $param_id = $_GET["id"];
    $stmt->execute();
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $dados["id"];
    $name = $dados["name"];
    $username = $dados["username"];
    $position = $dados["position"];
    $serial = $dados["serial"];
    $passaporte = $dados["passaporte"];
    $phone = $dados["phone"];
    $discord = $dados["discord"];
    $active = $dados["active"];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        $sql = "UPDATE users SET name=:name, position=:position, serial=:serial, passaporte=:passaporte, phone=:phone, discord=:discord, active:active WHERE id=:id";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":position", $position, PDO::PARAM_STR);
        $stmt->bindParam(":serial", $serial, PDO::PARAM_STR);
        $stmt->bindParam(":passaporte", $passaporte, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
        $stmt->bindParam(":discord", $discord, PDO::PARAM_STR);
        $stmt->bindParam(":active", $active, PDO::PARAM_STR);
    
        if($stmt->execute()){
            echo "ATUALIZADO COM SUCESSO";
        }
    }
}  else {
    header("Location: index.php");
}

?>

<!doctype html>
<html lang="pt" data-bs-theme="auto">
  <head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.115.4">
    <title>Cadastro · Jurídico</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">

    

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bi {
  display: inline-block;
  width: 1rem;
  height: 1rem;
}

/*
 * Sidebar
 */

@media (min-width: 768px) {
  .sidebar .offcanvas-lg {
    position: -webkit-sticky;
    position: sticky;
    top: 48px;
  }
  .navbar-search {
    display: block;
  }
}

.sidebar .nav-link {
  font-size: .875rem;
  font-weight: 500;
}

.sidebar .nav-link.active {
  color: #2470dc;
}

.sidebar-heading {
  font-size: .75rem;
}

/*
 * Navbar
 */

.navbar-brand {
  padding-top: .75rem;
  padding-bottom: .75rem;
  background-color: rgba(0, 0, 0, .25);
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
}

.navbar .form-control {
  padding: .75rem 1rem;
}

      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }
      .bd-mode-toggle {
        z-index: 1500;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
  </head>
  <body>
    
  <?php include ('../includes/theme.php'); ?>

<header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">Fusion &middot; Jurídico</a>

  <ul class="navbar-nav flex-row d-md-none">
    <li class="nav-item text-nowrap">
      <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
        <svg class="bi"><use xlink:href="#search"/></svg>
      </button>
    </li>
    <li class="nav-item text-nowrap">
      <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <svg class="bi"><use xlink:href="#list"/></svg>
      </button>
    </li>
  </ul>

  <div class="right px-4">
    <p class="fs-2">Olá, <?php echo htmlspecialchars($_SESSION["username"]); ?></p>
</div>
</header>

<div class="container-fluid">
  <div class="row">

  <?php include('../includes/sidenavadmin.php') ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Administração</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
            <svg class="bi"><use xlink:href="#calendar3"/></svg>
            This week
          </button>
        </div>
      </div>

      <p class="fs-2">Cadastrar um usuário</p>
    <form class="row g-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="col-md-2">
    <label for="id" class="form-label">ID</label>
    <input type="text" class="form-control" id="id" value="<?php echo $id; ?>" disabled>
  </div>
    <div class="col-md-4">
    <label for="name" class="form-label">Nome</label>
    <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
  </div>
  <div class="col-md-4">
    <label for="username" class="form-label">Usuário</label>
    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" disabled>
  </div>

  <div class="col-md-4">
    <label for="position" class="form-label">Cargo</label>
    <input type="text" name="position" class="form-control" value="<?php echo $position; ?>">
   
  </div>
  <div class="col-md-2">
    <label for="serial" class="form-label">Inscrição</label>
    <input type="text" name="serial" class="form-control" value="<?php echo $serial; ?>">
  </div>
  <div class="col-md-2">
    <label for="passaporte" class="form-label">Passaporte</label>
    <input type="text" name="passaporte" class="form-control" value="<?php echo $passaporte; ?>">
  </div>
  <div class="col-md-2">
    <label for="phone" class="form-label">Telefone</label>
    <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">

  </div>
  <div class="col-md-2">
    <label for="discord" class="form-label">Discord</label>
    <input type="text" name="discord" class="form-control" value="<?php echo $discord; ?>">

  </div>
  <div class="col-md-2">
  <div class="col-md-2">
  <label for="discord" class="form-label">Ativo</label>
    </div>
        <?php if ($dados["active"] == 1) { ?>
            <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="active" id="ativo" value="1" checked>
  <label class="form-check-label" for="active">Sim</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="active" id="active" value="0">
  <label class="form-check-label" for="active">Não</label>
</div>
            <?php 
        } else {
            ?>
           <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="active" value="1">
  <label class="form-check-label" for="inlineRadio1">Sim</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="active" id="active" value="0" checked>
  <label class="form-check-label" for="active">Não</label>
</div>
            <?php 
        }
        ?>
  </div>
  <div class="col-12">
  <input type="submit" class="btn btn-primary" value="atualizar" name="Atualizar>

  </div>
</form>
      
    </main>
  </div>
</div>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js" integrity="sha384-gdQErvCNWvHQZj6XZM0dNsAoY4v+j5P1XDpNkcM3HJG1Yx04ecqIHk7+4VBOCHOG" crossorigin="anonymous"></script><script src="dashboard.js"></script></body>
</html>