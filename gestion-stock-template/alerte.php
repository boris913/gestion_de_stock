<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_des_stocks";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Requête pour récupérer les produits avec stock inférieur à 10, en incluant la colonne num_pr
$sql = "SELECT num_pr, lib_pr, qte_stock FROM produit WHERE qte_stock < 10 ORDER BY qte_stock ASC";
$result = $conn->query($sql);
$lowStockProducts = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $lowStockProducts[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avertissement de Stock</title>
    <!-- <style>
        /* Styles pour la modal */
        body {
            font-family: 'Roboto', sans-serif;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            max-width: 400px;
            border: 1px solid red;
            border-radius: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
            animation: fadeIn 0.5s ease;
            position: relative;
            top: 50%;
            transform: translateY(-50%); Centrage vertical

        } 
        /* .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        } */
        /* .modal-danger {
            font-weight: 700;
            text-align: center;
        } */
        /* .modal-p, .modal-ul {
            font-weight: 600;
            color: #777777;
            text-align: center;
        } */
        /* @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: scale(0.2);
            }
            to { 
                opacity: 1; 
                transform: scale(1); 
            }
        } */
        .modal-content {
            animation: fadeIn 1s ease-out;
        }
    </style>-->
    <style>
    body {
        font-family: 'Roboto', sans-serif;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }
    .modal-content {
        background-color: #fff;
        margin: auto; /* Centre horizontalement */
        padding: 20px;
        border: 1px solid #ff0000;
        width: 50%;
        max-width: 400px;
        border-radius: 35px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        animation: fadeIn 1s ease-out;
        position: relative;
        top: 50%;
        transform: translateY(-50%); /* Centrage vertical */
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 38px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    .modal-danger {
        font-weight: 700;
        text-align: center;
        }
    .modal-p, .modal-ul {
        font-weight: 600;
        color: #777777;
        text-align: center;
        }
    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: scale(0.2); 
        }
        to { 
            opacity: 1; 
            transform: scale(1); 
        }
    }
    .custom-center {
        margin: 10px 10px;
        display: flex;
        justify-content: center;
        align-items: center;
}


</style>

</head>
<body>

<?php if(!empty($lowStockProducts)): ?>
<div id="stockModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 class="text-danger modal-danger">Avertissement</h2>
        <p class="modal-p">Les produits suivants ont un stock inférieur à 5 unités : (Veuillez vous réapprovisionner)</p>
        <ul class="list-group modal-ul">
            <?php foreach($lowStockProducts as $product): ?>
                <li class="list-group-item">
                    <a href="http://gestionnairestock/addpurchase.php">
                        <?php echo $product['lib_pr'] . " - " . $product['qte_stock'] . " en stock"; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="custom-center">
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="window.location.href='http://gestionnairestock/addpurchase.php'">Ajouter en stock</button>
      </div>
        </div>
        
    </div>
</div>

<script>
    // Afficher la modal
    var modal = document.getElementById("stockModal");
    modal.style.display = "block";

    // Fermer la modal
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<?php endif; ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
