<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: signin.php");
    exit;
}

require_once("../php/Class/Product.php");
require_once("../php/Class/Marque.php");
require_once("../php/Class/Categorie.php");
require_once("../php/Class/Client.php");
require_once("../php/Class/Sale.php");
require_once("../php/Class/PrSale.php");

$active = array(0, 0, 0, 0, 0, 0, 0, 0, "active", 0, 0, 0, 0, 0, 0, 0, 0);

$errorMessages = [];
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $num_com = $_POST['num_com'] ?? null;
        $date_com = $_POST['date_com'] ?? null;
        $id_cli = $_POST['id_cli'] ?? null;
        $num_pr = $_POST['num_pr'] ?? null;
        $qte_pr = $_POST['qte_pr'] ?? null;
        $prix_vente = $_POST['prix_vente'] ?? null;

        if (!$num_com || !$date_com || !$id_cli || !$num_pr || !$qte_pr || !$prix_vente) {
            $errorMessages[] = "Tous les champs sont obligatoires.";
        } else {
            $qty = Product::qtePr($num_pr);

            if ($qte_pr > $qty['qte_stock']) {
                $errorMessages[] = "La quantité demandée dépasse le stock disponible.";
            } else {
                if (!Sale::isSale($num_com)) {
                    $purchase = new Sale($num_com, $date_com, $id_cli);
                    try {
                        $purchase->add();
                    } catch (Exception $e) {
                        $errorMessages[] = "Erreur lors de l'ajout de la vente : " . $e->getMessage();
                    }
                }

                $product_of_sale = new PrSale($num_pr, $num_com, $qte_pr, $prix_vente);
                try {
                    $product_of_sale->add();
                    Product::deleteQty($num_pr, $qte_pr);
                    $prsSales = PrSale::displayPrsSale($num_com);
                    $sale = Sale::displaySale($num_com);
                    $successMessage = "Produit ajouté à la vente avec succès.";
                } catch (Exception $e) {
                    $errorMessages[] = "Erreur lors de l'ajout du produit à la vente : " . $e->getMessage();
                }
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['num_pr'], $_GET['num_com'])) {
        $num_pr = $_GET['num_pr'];
        $num_com = $_GET['num_com'];
        try {
            PrSale::deletePrSale($num_pr);
            $prsSales = PrSale::displayPrsSale($num_com);
            $sale = Sale::displaySale($num_com);
            $successMessage = "Produit supprimé de la vente avec succès.";
        } catch (Exception $e) {
            $errorMessages[] = "Erreur lors de la suppression du produit : " . $e->getMessage();
        }
    } elseif (isset($_GET['num_com'])) {
        $num_com = $_GET['num_com'];
        $prsSales = PrSale::displayPrsSale($num_com);
        $sale = Sale::displaySale($num_com);
    }
}

$clients = Client::afficher("client");
$products = Product::afficher("produit");
$categories = Categorie::afficher("categorie");
$brands = Marque::afficher("marque");
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
  <title>Nouvelles ventes</title>

  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png" />

  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

  <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />

  <link rel="stylesheet" href="assets/css/animate.css" />

  <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />

  <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />

  <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />

  <link rel="stylesheet" href="assets/css/style.css" />

  <?php if (isset($request_payload)): ?>
  <style>

  </style>
  <?php endif ?>
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
            <h4>Nouvelles ventes</h4>
            <h6>Créer une nouvelle vente</h6>
          </div>
        </div>
        <div class="card">
          <form class="card-body" id="myForm" method="post" action="createsalesreturns.php">
            <div class="row">
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Nom du client</label>
                  <div class="row">
                    <div class="col-lg-10 col-sm-10 col-10">
                      <select class="select" name="id_cli">
                        <option>Sélectionner le client</option>
                        <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['id']; ?>" <?php if (!empty($sale)) {
      if ($client['id'] === $sale['id_cli']) {
        echo ("selected");
      }
    } ?>><?= $client['nom'] . " " . $client['prenom']; ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                      <div class="add-icon">
                        <a href="./addcustomer.php"><img src="assets/img/icons/plus1.svg" alt="img" /></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Nom de marque</label>
                  <div class="row">
                    <div class="col-lg-10 col-sm-10 col-10">
                      <select class="select" name="id_marque" id="brand">
                        <option value="">Sélectionnez marque</option>
                        <?php foreach ($brands as $brand): ?>
                        <option value="<?= $brand['id_marque']; ?>"><?= $brand['nom_marque']; ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                      <div class="add-icon">
                        <a href="./addbrand.php"><img src="assets/img/icons/plus1.svg" alt="img" /></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Nom de la catégorie</label>
                  <div class="row">
                    <div class="col-lg-10 col-sm-10 col-10">
                      <select class="select" name="id_cat" id="cat">
                        <option value="">Sélectionnez catégorie</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id_cat']; ?>"><?= $cat['lib_cat']; ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                      <div class="add-icon">
                        <a href="./addcategory.php">
                          <img src="assets/img/icons/plus1.svg" alt="img" />
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Nom du produit</label>
                  <div class="row">
                    <div class="col-lg-10 col-sm-10 col-10">
                      <select class="select" name="num_pr">
                        <option>Sélectionner produit</option>
                        <?php foreach ($products as $pr): ?>
                        <option value="<?= $pr['num_pr']; ?>"><?= $pr['lib_pr']; ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                      <div class="add-icon">
                        <a href="./addproduct.php"><img src="assets/img/icons/plus1.svg" alt="img" /></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Quantité</label>
                  <input type="text" name="qte_pr" required/>
                  <?php if (isset($out_of_stock)): ?>
                  <p style="color:red; text-align: center">Stock Excédé</p>
                  <?php endif ?>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Date de la vente</label>
                  <div class="input-groupicon">
                    <input type="text" placeholder="DD-MM-YYYY" class="datetimepicker" name="date_com" value="<?php if (!empty($sale)) {
    echo $sale['date_com'];
  } ?>" required/>
                    <div class="addonset">
                      <img src="assets/img/icons/calendars.svg" alt="img" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Référence n°.</label>
                  <input type="text" name="num_com" value="<?php if (!empty($sale)) {
    echo $sale['num_com'];
  } ?>" required/>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label>Prix (en Fcfa)</label>
                  <input type="text" name="prix_vente" required/>
                </div>
              </div>
            </div>
            <?php if (!empty($errorMessages)): ?>
                <div class="alert alert-danger mt-3">
                    <ul>
                        <?php foreach ($errorMessages as $error): ?>
                        <li><?= htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if ($successMessage): ?>
                <div class="alert alert-success mt-3"><?= htmlspecialchars($successMessage); ?></div>
                <?php endif; ?>
            <div class="row">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Nom du produit</th>
                      <th>Prix unitaire</th>
                      <th>Quantité</th>
                      <th>Total</th>
                      
                    
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($prsSales)): ?>
                    <?php foreach ($prsSales as $pr): ?>
                    <tr>
                      <td class="productimgname">
                        <a class="product-img">
                          <img src="<?= $pr['pr_image'] ?>" alt="product" />
                        </a>
                        <a href="javascript:void(0);"><?= $pr['lib_pr'] ?></a>
                      </td>
                      <td><?= $pr['prix_vente'] ?> Fcfa</td>
                      <td><?= $pr['qte_pr'] ?></td>
                      <td><?= $pr['prix_vente'] * $pr['qte_pr']; ?></td>
                    </tr>
                    <?php endforeach ?>
                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total</strong></td>
                                        <td colspan="2">
                                            <strong><?= array_reduce($prsSales, function($total, $pr) {
                                                return $total + ($pr['prix_vente'] * $pr['qte_pr']);
                                            }, 0); ?> FCFA</strong>
                                        
                                      
                                    </tr>
                    <?php endif ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-lg-12">
              <button class="btn btn-submit me-2" type="submit" name="add">Ajouter</button>
              <a href="salesreturnlists.php" class="btn btn-cancel">Annuler</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
  $(document).ready(function() {
    $('#myForm').on('input', 'input', function() {
      var inputValue = $(this).val();
      // Validation du champ (exemple: vérifier si le champ est vide)
      if (inputValue === '') {
        $(this).addClass('is-invalid');
        $('#errorMessage').text('Ce champ est obligatoire.');
      } else {
        $(this).removeClass('is-invalid');
        $('#errorMessage').text('');
      }
    });
  });
</script>
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
