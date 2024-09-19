<?php
session_start();
?>
<?php if (isset($_SESSION['admin'])): ?>
<?php
  require_once("../php/Class/Supplier.php");
  $active = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "active", 0, 0);
  if (isset($_POST['submit'])) {
    extract($_POST);
    // Vérification si une image a été téléchargée
    if (isset($_FILES["image"]) && $_FILES["image"]["name"] != "") {
      $filename = $_FILES["image"]["name"];
      $tempname = $_FILES["image"]["tmp_name"];
      $image = "./image/supplier/" . $filename;

      if (move_uploaded_file($tempname, $image)) {
        $Supplier = new Supplier($nom, $prenom, $adr, $tele, $email, $image);
        $Supplier->Ajouter("fournisseur");
      } else {
        exit("<h3> Failed to upload image!</h3>");
      }
    } else {
    // Si aucune image n'est téléchargée, assigner une valeur par défaut (chaîne vide ou image par défaut)
    $image = "./assets/img/customer/admin.png"; // ou par exemple "./image/client/default.png" pour une image par défaut
    $client = new Supplier($nom, $prenom, $adr, $tele, $email, $image);
    $client->Ajouter("fournisseur");
    }
  
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
  <meta name="description" content="POS - Bootstrap Admin Template" />
  <meta name="keywords"
    content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects" />
  <meta name="author" content="Dreamguys - Bootstrap Admin Template" />
  <meta name="robots" content="noindex, nofollow" />
  <title>Ajouter un fournisseur</title>

  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png" />

  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

  <link rel="stylesheet" href="assets/css/animate.css" />

  <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />

  <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />

  <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />

  <link rel="stylesheet" href="assets/css/style.css" />
  <style>
    @media (min-width: 992px) {
      .col-lg-3 {
        flex: 0 0 auto;
        width: 33%;
      }

      .col-lg-9 {
        flex: 0 0 auto;
        width: 67%;
      }
    }
  </style>
</head>

<body>
  <div id="global-loader">
    <div class="whirly-loader"></div>
  </div>

  <div class="main-wrapper">
    <?php require_once("header.php"); ?>
    <?php require_once("sidebar.php"); ?>
    <div class="page-wrapper">
      <div class="content">
        <div class="page-header">
          <div class="page-title">
            <h4>Ajouter un fournisseur</h4>
            <h6>Ajouter un nouveau fournisseur</h6>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <form class="row" method="post" action="addsupplier.php" enctype="multipart/form-data">
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Nom du fournisseur</label>
                  <input type="text" name="prenom" required/>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Prénom du fournisseur</label>
                  <input type="text" name="nom" required/>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Téléphone</label>
                  <input type="text" name="tele" required/>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>E-mail</label>
                  <input type="text" name="email" />
                </div>
              </div>
              
              <div class="col-lg-9 col-12">
                <div class="form-group">
                  <label>Adresse</label>
                  <input type="text" name="adr" />
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label> Avatar</label>
                  <div class="image-upload">
                    <input type="file" name="image" />
                    <div class="image-uploads">
                      <img src="assets/img/icons/upload.svg" alt="img" />
                      <h4>Faites glisser et déposez un fichier à télécharger</h4>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <button class="btn btn-submit me-2" name="submit">Ajouter</button>
                <a href="supplierlist.php" class="btn btn-cancel">Annuler</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/jquery-3.6.0.min.js"></script>

  <script src="assets/js/feather.min.js"></script>

  <script src="assets/js/jquery.slimscroll.min.js"></script>

  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.bootstrap4.min.js"></script>

  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <script src="assets/plugins/select2/js/select2.min.js"></script>

  <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
  <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>

  <script src="assets/js/script.js"></script>
</body>

</html>
<?php else: ?>
<?php header("Location: signin.php"); ?>
<?php endif ?>