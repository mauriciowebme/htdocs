<?php
// Inicialize a sessão
session_start();
 
// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

require("../config.php");

$page_title = "Casamentos";
$status = $noivo = $id_noivo = $noiva = $id_noiva = $regime = $testemunha = $resp = $nota = "";


$stmt = $pdo->prepare("SELECT * FROM casamento ORDER BY id DESC");
$stmt->execute();

if(isset($_GET['delete'])){

    $id = (int)$_GET['delete'];
    $pdo->exec("DELETE FROM casamento WHERE id=$id");
    header("Location: ../admin/regcasamento.php");

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
  Adicionar Casamento
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
            $query = "INSERT INTO casamento (status, noivo, id_noivo, noiva, id_noiva, regime, testemunha, resp, nota, data) VALUES (:status, :noivo, :id_noivo, :noiva, :id_noiva, :regime, :testemunha, :resp, :nota, NOW())";
            $edit = $pdo->prepare($query);
            $edit->bindValue(':status', 'Pendente', PDO::PARAM_STR);
            $edit->bindParam(':noivo', $dados['noivo'], PDO::PARAM_STR);
            $edit->bindParam(':id_noivo', $dados['id_noivo'], PDO::PARAM_INT);
            $edit->bindParam(':noiva', $dados['noiva'], PDO::PARAM_STR);
            $edit->bindParam(':id_noiva', $dados['id_noiva'], PDO::PARAM_INT);
            $edit->bindParam(':regime', $dados['regime'], PDO::PARAM_STR);
            $edit->bindParam(':testemunha', $dados['testemunha'], PDO::PARAM_STR);
            $edit->bindParam(':resp', $_SESSION['username'], PDO::PARAM_STR);
            $edit->bindParam(':nota', $dados['nota'], PDO::PARAM_STR);

            if($edit->execute()){
              echo '<div class="alert alert-success md" role="alert">
              Mudança de nome registrada com sucesso.
            </div>';
            } else{
              echo "<p>Mudança não registrada.</p>";
            }
          }


        }
      ?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Casamento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form class="row g-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="col-md-5">
    <label for="noivo" class="form-label">Noivo</label>
    <input type="text" name="noivo" class="form-control" value="<?php echo $noivo; ?>">
  </div>
  <div class="col-md-5">
    <label for="id_noivo" class="form-label">ID Noivo</label>
    <input type="text" name="id_noivo" class="form-control" value="<?php echo $id_noivo; ?>">
    
  </div>
  <div class="col-md-5">
    <label for="noiva" class="form-label">Noiva</label>
    <input type="text" name="noiva" class="form-control" value="<?php echo $noiva; ?>">
   
  </div>
  <div class="col-md-5">
    <label for="id_noiva" class="form-label">ID Noiva</label>
    <input type="text" name="id_noiva" class="form-control" value="<?php echo $id_noiva; ?>">
   
  </div>
  <div class="col-md-5">
    <label for="regime" class="form-label">Regime</label>
    <select class="form-select" name="regime" aria-label="regime">
  <option selected>Selecione</option>
  <option value="Universal">Universal</option>
  <option value="Parcial">Parcial</option>
  <option value="Separação">Separação</option>
</select>
  </div>
  <div class="col-md-5">
    <label for="testemunha" class="form-label">Testemunha</label>
    <input type="text" name="testemunha" class="form-control" value="<?php echo $testemunha; ?>">
   
  </div>

  <div class="col-md-10">
    <label for="nota" class="form-label">Observações</label>
    <input type="text" name="nota" class="form-control" value="<?php echo $nota; ?>">
   
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
      <h2>Casamentos</h2>
      <div class="table-responsive small">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Nº</th>
              <th scope="col">ID Noivo</th>
              <th scope="col">Noivo</th>
              <th scope="col">ID Noiva</th>
              <th scope="col">Noiva</th>
              <th scope="col">Status</th>
              <th scope="col">Ação</th>
            </tr>
          </thead>
          <tbody>
            <?php while($dados = $stmt->fetch(PDO::FETCH_ASSOC)) { 
              ?>
            <tr>
              <td><?php echo $dados["id"]; ?></td>
              <td><?php echo $dados["id_noivo"]; ?></td>
              <td><?php echo $dados["noivo"]; ?></td>
              <td><?php echo $dados["id_noiva"]; ?></td>
              <td><?php echo $dados["noiva"]; ?></td>
              <td>
              <span class="
              <?php if($dados["status"] == "Pendente"){ echo "badge text-bg-warning";} ?>
              <?php if($dados["status"] == "Negado"){ echo "badge text-bg-danger";} ?>
              ">
              <?php echo $dados["status"]; ?>
            </span>
                </td>
              <td>
            <a class="btn btn-sm btn-primary" href="../admin/casadetail.php?id=<?php echo $dados["id"] ?>"><i class="bi bi-file-earmark-text"></i></a>
            <a class="btn btn-sm btn-danger <?php if($_SESSION["rank"] <= 3) { ?>disabled<?php } ?>" href="?delete=<?php echo $dados["id"] ?>"><i class="bi bi-trash"></i></a>
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