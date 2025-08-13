<?php  

$mesi = ['Gennaio', 'Febbraio','Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
$vendite = [120, 150, 90, 130, 110, 98, 87, 160, 120, 150, 90, 118];

?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafico PHP</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

 <h2>Vendite Mensili</h2>
 <canvas id="graficoLinee"></canvas>

 <script>

    const labels = <?php echo json_encode($mesi); ?>;
    const data = <?php echo json_encode($vendite); ?>;

    const ctx = document.getElementById('graficoLinee').getContext('2d');

    const chart = new Chart(ctx, {

        type: 'line',
        data : {
            labels: labels,
            datasets: [{

                label: 'Vendite',
                data: data,
                fill: false,
                borderColor: 'blue',
                tension: 0.1
            }]
        },
        options: {
            responsive : true,
            scales : {
                y: {beginAtZero: true}
            }
        }
    });


 </script>
</body>
</html>