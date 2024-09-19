<?php
require_once("Dao.php");
require_once("TotalLigne.php");
class Sale {
    use TotalLigne;
    public function __construct(
        private $num_com,
        private $date_com,
        private $id_cli
    ) {
    }

    public static function isSale($num_com) {
        return Dao::isSale($num_com);
    }

    public function add() {
        Dao::addSale($this->num_com, $this->date_com, $this->id_cli);
    }

    public static function displaySale($num_com) {
        return Dao::displaySale($num_com);
    }

    public static function displayAllSales() {
        return Dao::displayAllSales();
    }

    public static function deleteSale($num_com) {
        Dao::deleteSale($num_com);
    }

    public static function displaySaleWithPr($num_com) {
        return Dao::displaySaleWithPr($num_com);
    }
    public static function topSales() {
        return Dao::topSales();
    }
    public static function getMonthlySalesData() {
        // Connexion à la base de données
        $pdo = Dao::getPdo(); // Supposons que Dao::getPdo() retourne une instance PDO
    
        // Requête SQL pour obtenir les ventes mensuelles
        $sql = "
            SELECT 
                DATE_FORMAT(STR_TO_DATE(date_com, '%d-%m-%Y'), '%Y-%m') AS mois,
                SUM(qte_pr * prix_vente) AS total_ventes
            FROM 
                commande
            JOIN 
                contient_pr ON commande.num_com = contient_pr.num_com
            GROUP BY 
                mois
            ORDER BY 
                mois;
        ";
    
        // Préparer et exécuter la requête
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    
        // Récupérer les résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $results;
    }
    
}