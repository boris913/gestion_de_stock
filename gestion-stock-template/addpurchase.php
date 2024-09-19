<?php
session_start();
?>
<?php if (isset($_SESSION['admin'])): ?>
<?php
  require_once("../php/Class/Supplier.php");
  require_once("../php/Class/Product.php");
  require_once("../php/Class/Purchase.php");
  require_once("../php/Class/PrPurchase.php");
  $active = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "active", 0, 0, 0, 0, 0, 0);
  if (isset($_POST['add'])) {
    extract($_POST);
    // ila deja 3amro inser had purchase ..
    if (!Purchase::isPurchase($num_app)) {
      $pruchase = new Purchase($num_app, $date_app, $id, $desc_app);
      $pruchase->add();
    }
    // echo ("<pre>");
    // print_r($_POST);
    $product_of_purchase = new PrPurchase($num_app, $num_pr, $qte_achete);
    try {
      $product_of_purchase->add();
    } catch (\Throwable $th) {
    }
    Product::editQty($num_pr, $qte_achete);
    $prPurchases = PrPurchase::displayPrPurchase($num_app);
    $pur = Purchase::displayPur($num_app);
    // print_r($pur);
  }
  if (isset($_GET['num_pr'])) {
    extract($_GET);
    Purchase::deletePrPurchase($num_pr, $num_app);
    $prPurchases = PrPurchase::displayPrPurchase($num_app);
    $pur = Purchase::displayPur($num_app);
  }

  if (isset($_GET['num_app'])) {
    extract($_GET);
    $prPurchases = PrPurchase::displayPrPurchase($num_app);
  }
  $suppliers = Supplier::afficher("fournisseur");
  $products = Product::afficher("produit");
  // print_r($prPurchases);

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
  <title>Ajouter un achat</title>

  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png" />

  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

  <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />

  <link rel="stylesheet" href="assets/css/animate.css" />

  <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />

  <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />

  <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />

  <link rel="stylesheet" href="assets/css/style.css" />
  <style>
    @media (min-width: 992px) {
      .desc-form {
        flex: 0 0 auto;
        width: 75%;
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
            <h4>Ajouter un achat </h4>
            <h6>Ajouter un nouvel achat</h6>
          </div>
        </div>
        <div class="card">
          <form class="card-body" method="post" action="addpurchase.php">
            <div class="row">
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Nom du fournisseur</label>
                  <div class="row">
                    <div class="col-lg-10 col-sm-10 col-10">
                      <select class="select" name="id" required>
                        <option value="">Sélectionner</option>
                        <?php foreach ($suppliers as $item): ?>
                        <option value="<?= $item['id']; ?>" <?php if (isset($pur)) {
      if ($item['id'] === $pur['id_four']) {
        echo ("selected");
      }
    } ?>>
                          <?= $item['nom'] . " " . $item['prenom']; ?>
                        </option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                      <div class="add-icon">
                        <a href="addsupplier.php">
                          <img src="assets/img/icons/plus1.svg" alt="img" />
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Date d'achat </label>
                  <div class="input-groupicon">
                    <input type="text" placeholder="JJ-MM-AAAA" class="datetimepicker" name="date_app"  value="<?php if (isset($pur)) {
    echo ($pur['date_app']);
  } ?>" required/>
                    <div class="addonset">
                      <img src="assets/img/icons/calendars.svg" alt="img" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Nom du produit</label>
                  <select class="select" name="num_pr" required>
                    <option value="">Choisissez un produit</option>
                    <?php foreach ($products as $item): ?>
                    <option value="<?= $item['num_pr']; ?>">
                      <?= $item['lib_pr']; ?>
                    </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Référence n°.</label>
                  <input type="text" name="num_app" value="<?php if (isset($pur)) {
    echo ($pur['num_app']);
  } ?>" required/>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Quantité</label>
                  <input type="text" name="qte_achete" required/>
                  <input type="hidden" name="current_num_app" required/>
                </div>
              </div>
              <div class="col-lg-12 desc-form">
                <div class="form-group">
                  <label>Description</label>
                  <input type="text" class="form-control" name="desc_app" value="<?php if (isset($pur)) {
    echo ($pur['desc_app']);
  } ?>" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Nom du produit</th>
                      <th>Qté</th>
                      <th>Prix ​​d'achat</th>
                      <th class="text-end">Coût unitaire</th>
                      <th class="text-end">Coût total</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($prPurchases)): ?>
                    <?php foreach ($prPurchases as $item): ?>
                    <tr>
                      <td class="productimgname">
                        <a class="product-img">
                          <img src="<?= $item['pr_image'] ?>" alt="product" />
                        </a>
                        <a href="javascript:void(0);"><?= $item['lib_pr'] ?></a>
                      </td>
                      <td><?= $item['qte_achete'] ?></td>
                      <td><?= $item['prix_achat'] ?> Fcfa</td>
                      <td class="text-end"><?= $item['prix_uni'] ?> Fcfa</td>
                      <td class="text-end"><?= $item['qte_achete'] * $item['prix_achat'] ?> Fcfa</td>
                      <td>
                        <a href="./addpurchase.php?num_pr=<?= $item['num_pr'] ?>&amp;num_app=<?= $item['num_app'] ?>">
                          <img src="assets/img/icons/delete.svg" alt="svg" />
                        </a>
                      </td>
                    </tr>
                    <?php endforeach ?>
                    <?php endif ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-lg-12">
              <button class="btn btn-submit me-2" type="submit" name="add">Ajouter</button>
              <a href="purchaselist.php" class="btn btn-cancel">Annuler</a>
            </div>
          </form>
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

  <script src="assets/js/moment.min.js"></script>
  <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

  <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
  <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>

  <script src="assets/js/script.js"></script>
</body>

</html>
<?php else: ?>
<?php header("Location: signin.php"); ?>
<?php endif ?>