<?php
// Connexion à la base de données
$mysqli = new mysqli("localhost", "root", "", "gestion_des_stocks");

// Vérifier la connexion
if ($mysqli->connect_error) {
    die("Échec de la connexion : " . $mysqli->connect_error);
}

// Requête pour obtenir les produits les plus vendus
$query = "
    SELECT p.lib_pr, p.pr_image, SUM(c.qte_pr) as total_vendus
    FROM contient_pr c
    JOIN produit p ON c.num_pr = p.num_pr
    GROUP BY p.lib_pr, p.pr_image
    ORDER BY total_vendus DESC
    LIMIT 4
";

$result = $mysqli->query($query);

// Vérifier si des résultats sont retournés
if ($result->num_rows > 0) {
    echo "<div class='card mb-0'>
            <div class='card-body'>
                    <h4 class='card-title'>Produits les plus vendus</h4>
                <div class='card-body'>
                    <div class='table-responsive dataview'>
                        <table class='table datatable'>
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Produits</th>
                                    <th>Total Ventes</th>
                                </tr>
                            </thead>
                            <tbody>";
    
    $j = 0;
    while($row = $result->fetch_assoc()) {
        $j++;
        echo "<tr>
                <td>{$j}</td>
                <td class='productimgname'>
                    <a href='productlist.php' class='product-img'>
                        <img src='{$row['pr_image']}' alt='product'>
                    </a>
                    <a href='productlist.php'>{$row['lib_pr']}</a>
                </td>
                <td>{$row['total_vendus']}</td>
              </tr>";
    }

    echo "          </tbody>
                        </table>
                    </div>
                </div>
            </div>
          </div>";
} else {
    echo "Aucun produit vendu trouvé.";
}

// Fermer la connexion
$mysqli->close();
?>
