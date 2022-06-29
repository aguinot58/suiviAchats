<?php

namespace App\Service;

class FetchDatasGraph
{

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getDataGraph($date_deb = null, $date_fin = null)
    {
        if ($date_deb == null){
            $today = date('Y');
            $date_deb = $today.'/01/01';
        }

        if ($date_fin == null){
            $today = date('Y');
            $date_fin = $today.'/12/31';
        }

        $datas = $this->conn->executeQuery("SELECT c.nom_cat, MONTH(a.date_achat) AS mois, SUM(a.prix_achat) AS total from Achats a JOIN Produits p ON a.id_prod = p.id_prod JOIN Categories c ON p.id_cat = c.id_cat WHERE a.date_achat >= '$date_deb' AND a.date_achat <= '$date_fin' GROUP BY p.id_cat, mois");
        return $datas->fetchAll();
    }
}

?>