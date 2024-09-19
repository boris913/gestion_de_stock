<?php
    $monthlySalesData = Sale::getMonthlySalesData();

    // Couleurs personnalisées excentriques
    $colors = ['#40E0D0', '#4B0082', '#90EE90', '#FFD700', '#FF6347', '#9400D3', '#00FF7F'];

    $colorCount = count($colors);
    $colorIndex = 0;

    echo "<div class='card mb-0'>
            <div class='card-body'>
                <h4 class='card-title'>Total des ventes par mois</h4>
                <div class='card-body'>
                    <div class='table-responsive dataview'>
                        <table class='table datatable'>
                            <thead>
                                <tr>
                                    <th>Mois</th>
                                    <th>Total des ventes</th>
                                </tr>
                            </thead>
                            <tbody>";

    $j = 0;
    foreach ($monthlySalesData as $data) {
        $j++;
        echo "<tr>
                <td>{$data['mois']}</td>
                <td>{$data['total_ventes']}F cfa</td>
              </tr>";
    }

    echo "          </tbody>
                        </table>
                    </div>
                </div>
            </div>
          </div>";
?>