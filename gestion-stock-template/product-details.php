<?php
session_start();
?>
<?php if (isset($_SESSION['admin'])): ?>
<?php
  require_once("../php/Class/Product.php");
  $active = array(0, 0, 0, 0, 0, "active", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
  if (isset($_GET['num_pr'])) {
    extract($_GET);
    $pr = Product::displayPr($num_pr);
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
  <title>Détails du produit</title>

  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png" />

  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

  <link rel="stylesheet" href="assets/css/animate.css" />

  <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />

  <link rel="stylesheet" href="assets/plugins/owlcarousel/owl.carousel.min.css" />

  <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />

  <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />

  <link rel="stylesheet" href="assets/css/style.css" />


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
            <h4>Détails du produit</h4>
            <h6>Détails complets du produit</h6>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-8 col-sm-12">
            <div class="card">
              <div class="card-body">
                <div class="productdetails">
                  <ul class="product-bar">
                    <li>
                      <h4>Référence</h4>
                      <h6>
                        <?= $pr['num_pr'] ?>
                      </h6>
                    </li>
                    <li>
                      <h4>Produit</h4>
                      <h6>
                        <?= $pr['lib_pr'] ?>
                      </h6>
                    </li>
                    <li>
                      <h4>Description</h4>
                      <h6>
                        <?= $pr['desc_pr'] ?>
                      </h6>
                    </li>
                    <li>
                      <h4>Catégorie</h4>
                      <h6>
                        <?= $pr['lib_cat'] ?>
                      </h6>
                    </li>
                    <li>
                      <h4>Marque</h4>
                      <h6>
                        <?= $pr['nom_marque'] ?>
                      </h6>
                    </li>
                    <li>
                      <h4>Prix ​​D'achat</h4>
                      <h6>
                        <?= $pr['prix_achat'] ?>Fcfa
                      </h6>
                    </li>

                    <li>
                      <h4>Prix ​​unitaire</h4>
                      <h6>
                        <?= $pr['prix_uni'] ?>Fcfa
                      </h6>
                    </li>
                    <li>
                      <h4>Quantité</h4>
                      <h6>
                        <?= $pr['qte_stock'] ?>
                      </h6>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-sm-12">
            <div class="card">
              <div class="card-body">
                <div class="slider-product-details">
                  <div class="owl-carousel owl-theme product-slide">
                    <div class="slider-product">
                      <img src="<?= $pr['pr_image'] ?>" style="display: inline-block;" alt="img" />
                      <h4>
                        <?= $pr['lib_pr'] ?>.jpg
                      </h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/jquery-3.6.0.min.js"></script>

  <script src="assets/js/feather.min.js"></script>

  <script src="assets/js/jquery.slimscroll.min.js"></script>

  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <script src="assets/plugins/owlcarousel/owl.carousel.min.js"></script>

  <script src="assets/plugins/select2/js/select2.min.js"></script>

  <script src="assets/js/script.js"></script>
</body>

</html>
<?php else: ?>
<?php header("Location: signin.php"); ?>
<?php endif ?>