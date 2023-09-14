<?php
// Inicialize a sessão
session_start();
ob_start();
$page_title = "Editar Usuário";
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
 
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
}  else {
    header("Location: ../admin/index.php");
}


?>

<!doctype html>
<html lang="pt" data-bs-theme="auto">
  <?php include('../includes/headadmin.php'); ?>
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

  <div class="right px-4 text-white">
    <p class="fs-2">Olá, <?php echo htmlspecialchars($_SESSION["username"]); ?></p>
</div>
</header>

<div class="container-fluid">
  <div class="row">

  <?php include('../includes/sidenavadmin.php') ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Administração</h1>
      
      </div>
      <?php 
      //Receber dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Verificar se o usuário clicou no botão
        if(!empty($dados['EditUsuario'])){

          $empty_input = false;
          $dados = array_map('trim', $dados);
          if(in_array("", $dados)) {
            $empty_input = true;
            echo "<p>Há campos em branco</p>";

          }
          if(!$empty_input){
            $query = "UPDATE users SET name=:name, position=:position, serial=:serial, passaporte=:passaporte, phone=:phone, discord=:discord, active=:active, image=:image WHERE id=:id";
            $edit = $pdo->prepare($query);
            $edit->bindParam(':name', $dados['name'], PDO::PARAM_STR);
            $edit->bindParam(':position', $dados['position'], PDO::PARAM_STR);
            $edit->bindParam(':serial', $dados['serial'], PDO::PARAM_STR);
            $edit->bindParam(':passaporte', $dados['passaporte'], PDO::PARAM_INT);
            $edit->bindParam(':phone', $dados['phone'], PDO::PARAM_STR);
            $edit->bindParam(':discord', $dados['discord'], PDO::PARAM_STR);
            $edit->bindParam(':active', $dados['active'], PDO::PARAM_INT);
            $edit->bindParam(':id', $id, PDO::PARAM_INT);
            $edit->bindParam(':image', $dados['image'], PDO::PARAM_STR);

            if($edit->execute()){
              header("Location: ../admin/admin.php");
            } else{
              echo "<p>Usuário não editado.</p>";
            }
          }


        }
      ?>
      <p class="fs-2">Editar usuário</p>
    <form class="row g-3" id="edit-usuario" action="" method="POST">
    <div class="col-md-2">
    <label for="id" class="form-label">ID</label>
    <input type="text" class="form-control" id="id" value="<?php echo $id; ?>" disabled>
  </div>
    <div class="col-md-4">
    <label for="name" class="form-label">Nome</label>
    <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>">
  </div>
  <div class="col-md-4">
    <label for="username" class="form-label">Usuário</label>
    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" disabled>
  </div>

  <div class="col-md-4">
    <label for="position" class="form-label">Cargo</label>
    <select class="form-select" name="position" aria-label="position">
  <option selected>Selecione</option>
  <option value="Responsável Geral">Responsável Geral</option>
  <option value="Responsável">Responsável</option>
  <option value="Desembargador">Desembargador</option>
  <option value="Juiz">Juiz</option>
  <option value="Promotor">Promotor</option>
  <option value="Diretor">Diretor</option>
  <option value="Conselheiro">Conselheiro</option>
  <option value="Advogado Master">Advogado Master</option>
  <option value="Advogado Sênior">Advogado Sênior</option>
  <option value="Advogado Pleno">Advogado Pleno</option>
  <option value="Advogado Júnior">Advogado Júnior</option>
  <option value="Estagiário">Estagiário</option>
</select>
   
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
  <div class="col-md-4">
    <label for="discord" class="form-label">Ativo? </label>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="active" id="active" value="1" <?php if($active == 1){ echo "checked";} ?>>
      <label class="form-check-label" for="inlineRadio1">Sim</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="active" id="active" value="0" <?php if($active == 0){ echo "checked";} ?>>
      <label class="form-check-label" for="active">Não</label>
    </div>
  </div>
  <div class="col-md-6">
    <label for="image" class="form-label">Imagem</label>
    <input type="text" name="image" class="form-control" placeholder="https://link da imagem.png">

  </div>
  <div class="col-12">
  <input type="submit" class="btn btn-primary" value="Atualizar" name="EditUsuario">

  </div>
</form>
      
    </main>
  </div>
</div>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js" integrity="sha384-gdQErvCNWvHQZj6XZM0dNsAoY4v+j5P1XDpNkcM3HJG1Yx04ecqIHk7+4VBOCHOG" crossorigin="anonymous"></script><script src="dashboard.js"></script></body>
</html>