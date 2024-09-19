<?php
    $monthlySalesData = Sale::getMonthlySalesData();

    // Couleurs personnalisées excentriques
    $colors = [
        '#6f42c1', // bs-purple
        '#d63384', // bs-pink    
        '#fd7e14', // bs-orange
        '#ffc107', // bs-yellow
        
        '#20c997', // bs-teal
        '#6610f2', // bs-indigo
        '#0d6efd', // bs-blue
        '#0dcaf0', // bs-cyan
        
        '#198754', // bs-green
       
        '#dc3545', // bs-red
    ];

    $colorCount = count($colors);
    $colorIndex = 0;
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<canvas id="salesChart" style="max-width: 100%; max-height: 400px; background-color: #0D1117; padding: 20px; border-radius: 10px;"></canvas>
<script>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [<?php foreach ($monthlySalesData as $data) echo '"' . $data['mois'] . '",'; ?>],
            datasets: [{
                label: 'Total des ventes par mois (en F cfa)',
                data: [<?php foreach ($monthlySalesData as $data) echo $data['total_ventes'] . ','; ?>],
                backgroundColor: [
                    <?php
                    foreach ($monthlySalesData as $data) {
                        echo "'" . $colors[$colorIndex] . "',";
                        $colorIndex = ($colorIndex + 1) % $colorCount;
                    }
                    ?>
                ],
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'white' // Changer la couleur du texte du label en blanc
                    }
                }
            }
            
        }
    });
</script>


