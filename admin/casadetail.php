<?php
// Inicialize a sessão
session_start();
ob_start();
$page_title = "Detalhes Casamento";
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
 
// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

require_once "../config.php";

if(isset($_GET["id"])){

    $stmt = $pdo->prepare("SELECT * FROM casamento WHERE id=:id");
    $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
    $param_id = $_GET["id"];
    $stmt->execute();
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $dados["id"];
    $noivo = $dados["noivo"];
    $id_noivo = $dados["id_noivo"];
    $noiva = $dados["noiva"];
    $id_noiva = $dados["id_noiva"];
    $regime = $dados["regime"];
    $testemunha = $dados["testemunha"];
    $resp = $dados["resp"];
    $juiz = $dados["juiz"];
    $nota = $dados["nota"];
    $data = $dados["data"];
    $status = $dados["status"];
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
        <h1 class="h2">Cartório</h1>
      
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
            $query = "UPDATE casamento SET status=:status, nota=:nota, juiz=:juiz WHERE id=:id";
            $edit = $pdo->prepare($query);
            $edit->bindParam(':status', $dados['status'], PDO::PARAM_STR);
            $edit->bindParam(':nota', $dados['nota'], PDO::PARAM_STR);
            $edit->bindParam(':juiz', $dados['juiz'], PDO::PARAM_STR);
            $edit->bindParam(':id', $id, PDO::PARAM_INT);

            if($edit->execute()){
              echo "<p>Casamento editado com sucesso!.";
              header("Location: ../admin/regcasamento.php");
            } else{
              echo "<p>Casamento não editado.</p>";
            }
          }


        }
      ?>
      <p class="fs-2">Detalhes do casamento</p>
    <form class="row g-3" id="edit-usuario" action="" method="POST">
        <div class="col-md-6">
        <label for="noivo" class="form-label">Status</label>
        <br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status" value="Pendente"  <?php if($status == "Pendente"){ echo "checked";} ?> <?php if($_SESSION["rank"] <= 2){ echo "disabled";} ?>>
                <label class="form-check-label" for="status">Pendente</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status" value="Aprovado"  <?php if($status == "Aprovado"){ echo "checked";} ?> <?php if($_SESSION["rank"] <= 2){ echo "disabled";} ?>>
                <label class="form-check-label" for="status">Aprovado</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status" value="Negado" <?php if($status == "Negado"){ echo "checked";} ?> <?php if($_SESSION["rank"] <= 2){ echo "disabled";} ?>>
                <label class="form-check-label" for="status">Negado</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status" value="Anulado" <?php if($status == "Anulado"){ echo "checked";} ?> <?php if($_SESSION["rank"] <= 3){ echo "disabled";} ?>>
                <label class="form-check-label" for="status">Anulado</label>
            </div>
        </div>
        <div class="col-md-8">
    <label for="noivo" class="form-label">Noivo</label>
    <input type="text" id="noivo" name="noivo" class="form-control" value="<?php echo $noivo; ?>" disabled>
  </div>
  <div class="col-md-2">
    <label for="name" class="form-label">ID Noivo</label>
    <input type="text" id="id_noivo" name="id_noivo" class="form-control" value="<?php echo $id_noivo; ?>" disabled>
  </div>
  <div class="col-md-8">
    <label for="noiva" class="form-label">Noiva</label>
    <input type="text" id="name" name="noiva" class="form-control" value="<?php echo $noiva; ?>" disabled>
  </div>
  <div class="col-md-2">
    <label for="id_noiva" class="form-label">ID Noiva</label>
    <input type="text" id="id_noiva" name="id_noiva" class="form-control" value="<?php echo $id_noiva; ?>" disabled>
  </div>
  <div class="col-md-4">
    <label for="name" class="form-label">Regime</label>
    <input type="text" id="regime" name="regime" class="form-control" value="<?php echo $regime; ?>" disabled>
  </div>
  <div class="col-md-4">
    <label for="testemunha" class="form-label">Testemunha</label>
    <input type="text" id="testemunha" name="testemunha" class="form-control" value="<?php echo $testemunha; ?>" disabled>
  </div>
  <div class="col-md-4">
    <label for="name" class="form-label">Advogado</label>
    <input type="resp" id="name" name="resp" class="form-control" value="<?php echo $resp; ?>" disabled>
  </div>
  <div class="col-md-4">
    <label for="juiz" class="form-label">Juiz</label>
    <input type="text" id="juiz" name="juiz" class="form-control" value="<?php if(empty($juiz)){ echo $_SESSION["username"];}else{echo $juiz;} ?>"  <?php if($_SESSION["rank"] <= 2){ echo "disabled";} ?>>
  </div>
  <div class="col-md-4">
    <label for="data" class="form-label">Data</label>
    <input type="text" id="data" name="data" class="form-control" value="<?php echo $data; ?>" disabled>
  </div>
  <div class="col-md-10">
    <label for="nota" class="form-label">Anotações</label>
    <input type="text" id="nota" name="nota" class="form-control" value="<?php echo $nota; ?>"  <?php if($_SESSION["rank"] <= 1){ echo "disabled";} ?>>
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