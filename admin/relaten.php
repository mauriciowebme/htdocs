<?php
// Inicialize a sessão
session_start();
 
// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require("../config.php");


$page_title = "Atendimentos";
$cliente = $pass = $relatorio = $honorario = $departamento = $oficial = "";

$stmt = $pdo->prepare("SELECT * FROM atendimentos ORDER BY id DESC");
$stmt->execute();

if(isset($_GET['delete'])){

    $id = (int)$_GET['delete'];
    $pdo->exec("DELETE FROM atendimentos WHERE id=$id");
    header("Location: ../admin/relaten.php");

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
        <h1 class="h2">Relatórios</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Novo Atendimento
</button>
          </div>
        </div>
        
      </div>
    
      <?php 
      //Receber dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Verificar se o usuário clicou no botão
        if(!empty($dados['AddAten'])){

          $empty_input = false;
          $dados = array_map('trim', $dados);
          if(in_array("", $dados)) {
            $empty_input = true;
            echo "<p>Há campos em branco</p>";

          }
          if(!$empty_input){
            $query = "INSERT INTO atendimentos (cliente, pass, advogado, departamento, oficial, honorario, relatorio, data) VALUES (:cliente, :pass, :advogado, :departamento, :oficial, :honorario, :relatorio, NOW())";
            $edit = $pdo->prepare($query);
            $edit->bindParam(':cliente', $cliente, PDO::PARAM_STR);
            $edit->bindParam(':pass', $pass, PDO::PARAM_INT);
            $edit->bindParam(':advogado', $username, PDO::PARAM_STR);
            $edit->bindParam(':departamento', $dados['departamento'], PDO::PARAM_STR);
            $edit->bindParam(':oficial', $dados['oficial'], PDO::PARAM_STR);
            $edit->bindParam(':honorario', $dados['honorario'], PDO::PARAM_STR);
            $edit->bindParam(':relatorio', $dados['relatorio'], PDO::PARAM_STR);

            // Definir parametros
            $cliente = $dados["cliente"];
            $pass = $dados["pass"];
            $username = $_SESSION["username"];

            if($edit->execute()){
              echo '<div class="alert alert-success md" role="alert">
              Registros de atendimentos efetuado com sucesso.
            </div>';
            
          }

        }
      }
      ?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar um atendimento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form class="row g-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <div class="col-md-5">
    <label for="cliente" class="form-label">Cliente</label>
    <input type="text" name="cliente" class="form-control" placeholder="Nome Sobrenome" value="<?php echo $cliente; ?>">
  </div>
  <div class="col-md-3">
    <label for="pass" class="form-label">ID Cliente</label>
    <input type="text" name="pass" class="form-control" placeholder="0011" value="<?php echo $pass; ?>">
    
  </div>
  <div class="col-md-6">
    <label for="advogado" class="form-label">Advogado</label>
    <input type="text" name="advogado" class="form-control" placeholder="<?php echo $_SESSION['username']; ?>" value="<?php echo $_SESSION['username']; ?>" disabled>
   
  </div>
  <div class="col-md-4">
    <label for="departamento" class="form-label">Departamento</label>
    <select class="form-select" name="departamento" aria-label="departamento">
  <option selected>Selecione</option>
  <option value="Polícia Militar">PMERJ</option>
  <option value="Polícia Civil">Civil</option>
  <option value="Polícia Rodoviária">PRF</option>
  <option value="Polícia Federal">PF</option>
</select>
  </div>
  <div class="col-md-6">
    <label for="oficial" class="form-label">Oficial</label>
    <input type="text" name="oficial" class="form-control" placeholder="Nome Sobrenome" value="<?php echo $oficial; ?>">
  
  </div>
  <div class="col-md-4">
    <label for="honorario" class="form-label">Pagamento</label>
    <select class="form-select" name="honorario" aria-label="honorario">
  <option selected>Selecione</option>
  <option value="Sim">Sim</option>
  <option value="Não">Não</option>
  <option value="Parceiro">Parceiro</option>
</select>
  </div>
  <div class="col-md-10">
    <label for="relatorio" class="form-label">Relatório</label>
    <input type="text" name="relatorio" class="form-control" value="<?php echo $relatorio; ?>">
  
  </div>
  <div class="col-12">
  <input type="submit" class="btn btn-primary" value="Adicionar" name="AddAten">
  </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
    
</br>
    <hr>
      <h2>Lista de atendimentos</h2>
      <div class="table-responsive small">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Nº</th>
              <th scope="col">Data</th>
              <th scope="col">Advogado</th>
              <th scope="col">ID</th>
              <th scope="col">Cliente</th>
              <th scope="col">Honorario</th>
              <th scope="col">Departamento</th>
              <th scope="col">Oficial</th>
              <th scope="col">Relatório</th>
              <th scope="col">Ação</th>
            </tr>
          </thead>
          <tbody>
            <?php while($dados = $stmt->fetch(PDO::FETCH_ASSOC)) { 
              ?>
            <tr>
              <td><?php echo $dados["id"]; ?></td>
              <td><?php echo $dados["data"]; ?></td>
              <td><?php echo $dados["advogado"]; ?></td>
              <td><?php echo $dados["pass"]; ?></td>
              <td><?php echo $dados["cliente"]; ?></td>
              <td><?php echo $dados["honorario"]; ?></td>
              <td><?php echo $dados["departamento"]; ?></td>
              <td><?php echo $dados["oficial"]; ?></td>
              <td><?php echo $dados["relatorio"]; ?></td>
              <td>
                <a class="btn btn-sm btn-secondary <?php if($_SESSION["rank"] <= 2) { ?>disabled<?php } ?>" href="#"><i class="bi bi-pencil"></i></a>
                <a class="btn btn-sm btn-danger <?php if($_SESSION["rank"] <= 2) { ?>disabled<?php } ?>" href="?delete=<?php echo $dados["id"] ?>"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js" integrity="sha384-gdQErvCNWvHQZj6XZM0dNsAoY4v+j5P1XDpNkcM3HJG1Yx04ecqIHk7+4VBOCHOG" crossorigin="anonymous"></script><script src="dashboard.js"></script></body>
</html>