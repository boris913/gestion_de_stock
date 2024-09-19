<?php
session_start();
?>
<?php if (isset($_SESSION['admin'])): ?>
<?php
  require_once("../php/Class/Product.php");
  require_once("../php/Class/Categorie.php");
  require_once("../php/Class/Marque.php");
  $cats = Categorie::afficher("categorie");
  $brands = Marque::afficher("marque");
  $active = array(0, 0, 0, 0, 0, 0, "active", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
  if (isset($_POST['add'])) {
    extract($_POST);
    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $image = "./image/product/" . $filename;

    if (move_uploaded_file($tempname, $image)) {
      $nv_pr = new Product($num_pr, $id_cat, $id_marque, $lib_pr, $desc_pr, $prix_uni, $prix_achat, $qte_stock, $image);
      $nv_pr->addPr();
    } else {
      exit("<h3> Failed to upload image!</h3>");
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
  <title>Ajouter un produit</title>

  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png" />

  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

  <link rel="stylesheet" href="assets/css/animate.css" />

  <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />

  <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />

  <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />

  <link rel="stylesheet" href="assets/css/style.css" />

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
            <h4>Ajouter un produit</h4>
            <h6>Créer un nouveau produit</h6>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <form class="row" method="post" action="addproduct.php" enctype="multipart/form-data">
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Référence</label>
                  <input type="text" name="num_pr" required/>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Nom du produit</label>
                  <input type="text" name="lib_pr" required/>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Catégorie</label>
                  <select class="select" name="id_cat">
                    <option value="">Choisissez une catégorie</option>
                    <?php foreach ($cats as $item): ?>
                    <option value="<?= $item['id_cat']; ?>">
                      <?= $item['lib_cat']; ?>
                    </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Marque</label>
                  <select class="select" name="id_marque">
                    <option value="">Choisissez une marque</option>
                    <?php foreach ($brands as $item): ?>
                    <option value="<?= $item['id_marque']; ?>">
                      <?= $item['nom_marque']; ?>
                    </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Quantité</label>
                  <input type="text" name="qte_stock" required/>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>prix d'achat (en Fcfa)</label>
                  <input type="text" name="prix_achat" required/>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>prix unitaire (en Fcfa)</label>
                  <input type="text" name="prix_uni" required/>
                </div>
              </div>

              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>description</label>
                  <input type="text" name="desc_pr" required/>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label> Image du produit</label>
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
                <button class="btn btn-submit me-2" name="add">Ajouter un produit</button>
                <a href="productlist.php" class="btn btn-cancel">Annuler</a>
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