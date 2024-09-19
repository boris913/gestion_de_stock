<?php
session_start();
// print_r($_SESSION);
?>
<?php if (isset($_SESSION['admin'])):
    require_once("../php/Class/Client.php");
    require_once("../php/Class/Supplier.php");
    require_once("../php/Class/Purchase.php");
    require_once("../php/Class/Sale.php");
    require_once("../php/Class/Product.php");
    $active = array("active", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    $clients = Client::nbrDesTuples("client");
    $suppliers = Supplier::nbrDesTuples("fournisseur");
    $purchases = Purchase::TotalLigne("approvisionnement");
    $sales = Sale::TotalLigne("commande");
    $products = Product::afficher("produit");
    $almost_expired_products = Product::afficherExepiredPr();
    $all_sales = Sale::topSales();
    $all_purchases = Purchase::displayAllPur();
    $total_all_sales = 0;
    foreach ($all_sales as $item) {
        $total_all_sales += $item['total'];
    }
    $total_all_pur = 0;
    foreach ($all_purchases as $value) {
        $total_all_pur += $value['total'];
    }
    $total_all_pr = 0;
    foreach ($products as $value) {
        $total_all_pr += $value['qte_stock'];
    }
    // print_r($clients); 
    $monthly_sales_data = Sale::getMonthlySalesData();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>AMITAM Store</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/css/animate.css">

    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body>
    <div id=" global-loader">
        <div class="whirly-loader"> </div>
    </div>

    <div class="main-wrapper">

        <?php require_once("header.php"); ?>
        <?php require_once("sidebar.php"); ?>
        <?php require_once("alerte.php"); ?>

        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget">
                            <div class="dash-widgetimg">
                                <span><img src="assets/img/icons/dash1.svg" alt="img"></span>
                            </div>
                            <?php ?>
                            <?php ?>
                            <div class="dash-widgetcontent">
                                <h5><span class="counters" data-count="<?= $total_all_pur ?>"><?= $total_all_pur ?>Fcfa</span> Fcfa</h5>
                                <h6>Montant total<br>des achats </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash1">
                            <div class="dash-widgetimg">
                                <span><img src="assets/img/icons/dash2.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5><span class="counters" data-count="<?= $total_all_sales ?>"><?= $total_all_sales ?>Fcfa</span> Fcfa</h5>
                                <h6>Montant total<br>des ventes</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash2">
                            <div class="dash-widgetimg">
                                <span><img src="assets/img/icons/dash3.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5><span class="counters" data-count="<?= $total_all_sales - $total_all_pur ?>"><?= $total_all_sales - $total_all_pur ?>Fcfa</span> Fcfa</h5>
                                <h6>Montant total<br>des bénéfices</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash3">
                            <div class="dash-widgetimg">
                                <span><img src="assets/img/icons/dash4.svg" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5><span class="counters" data-count="<?= $total_all_pr ?>"><?= $total_all_pr ?>
                                Fcfa</span>
                                </h5>
                                <h6>Nombre total de<br>produits en stock</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count">
                            <div class="dash-counts">
                                <h4><?= $clients ?></h4>
                                <h5>Clients</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das1">
                            <div class="dash-counts">
                                <h4><?= $suppliers ?></h4>
                                <h5>Fournisseurs</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="user-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das2">
                            <div class="dash-counts">
                                <h4><?= $purchases ?></h4>
                                <h5>Facture D'achat</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="file-text"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das3">
                            <div class="dash-counts">
                                <h4><?= $sales ?></h4>
                                <h5>Facture de Vente</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="file"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    
                        <div class="card flex-fill">
                            <h4 class="card-title mb-0" style="padding:15px;">Top 4 des ventes</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Référence de vente</th>
                                        <th>Clients</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i <= 3; $i++): ?>
                                    <tr>
                                        <td><?= $all_sales[$i]['num_com'] ?></td>
                                        <td class="productimgname">
                                            <a href="javascript:void(0);" class="product-img">
                                                <img src="<?= $all_sales[$i]['image'] ?>" alt="product" />
                                            </a>
                                            <a href="javascript:void(0);"><?= $all_sales[$i]['nom'] . " " . $all_sales[$i]['prenom'] ?></a>
                                        </td>
                                        <td><?= $all_sales[$i]['date_com'] ?></td>
                                        <td><?= $all_sales[$i]['total'] ?> Fcfa</td>
                                    </tr>
                                    <?php endfor ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                   
                <div class="row" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="col-md-6">
        <?php require_once("tab_ven_per_m.php"); ?>
    </div>
    <div class="col-md-6">
        <?php require_once("graphe.php"); ?>
    </div>
</div>
                <div class="card mb-0">
                    <div class="card-body">
                        <h4 class="card-title">Quantité minimale en stock</h4>
                        <div class="table-responsive dataview">
                            <table class="table datatable ">
                                <thead>
                                    <tr>
                                        <th>Nº</th>
                                        <th>Nom Produit</th>
                                        <th>Nom Marque</th>
                                        <th>Nom Catégorie</th>
                                        <th>Prix D'achat</th>
                                        <th>Quantité restante</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < 4; $i++): ?>
                                    <tr>
                                        <td><?= $i + 1; ?></td>
                                        <td class="productimgname">
                                            <a class="product-img" href="productlist.php">
                                                <img src="<?= $almost_expired_products[$i]['pr_image'] ?>"
                                                    alt="product">
                                            </a>
                                            <a href="productlist.php"><?= $almost_expired_products[$i]['lib_pr'] ?></a>
                                        </td>
                                        <td><?= $almost_expired_products[$i]['nom_marque'] ?></td>
                                        <td><?= $almost_expired_products[$i]['lib_cat'] ?></td>
                                        <td><?= $almost_expired_products[$i]['prix_achat'] ?> Fcfa</td>
                                        <td><?= $almost_expired_products[$i]['qte_stock'] ?></td>
                                    </tr>
                                    <?php endfor ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 20px;"></div>
                <div class="row" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="col-md-6">
        <?php require_once("product_ms_sale.php"); ?>
    </div>
    <div class="col-md-6">
         
                        <div class="card flex-fill">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Produits récemment ajoutés</h4>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false"
                                        class="dropset">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a href="productlist.php" class="dropdown-item">Liste de Produits</a>
                                        </li>
                                        <li>
                                            <a href="addproduct.php" class="dropdown-item">Ajouter un Produit</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive dataview">
                                    <table class="table datatable ">
                                        <thead>
                                            <tr>
                                                <th>Nº</th>
                                                <th>Produits</th>
                                                <th>Prix</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
    $j = 0;
    for ($i = sizeof($products) - 1; $i >= sizeof($products) - 4; $i--):
        $j++;
                                            ?>
                                            <tr>
                                                <td><?= $j; ?></td>
                                                <td class="productimgname">
                                                    <a href="productlist.php" class="product-img">
                                                        <img src="<?= $products[$i]['pr_image'] ?>" alt="product">
                                                    </a>
                                                    <a href="productlist.php"><?= $products[$i]['lib_pr'] ?></a>
                                                </td>
                                                <td><?= $products[$i]['prix_uni'] ?> Fcfa</td>
                                            </tr>
                                            <?php endfor ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
               
    </div>
</div>

            </div>
        </div>
    </div>

    <div id="stock-alert-modal" class="modal fade" tabindex="-1" aria-labelledby="lowStockAlertLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            </div>
    </div>
</div>
    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="assets/plugins/apexchart/chart-data.js"></script>

    <script src="assets/js/script.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>

</html>
<?php else: ?>
<?php header("Location: signin.php"); ?>
<?php endif ?>