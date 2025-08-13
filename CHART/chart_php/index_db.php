<?php 

//connessione tramite mysqli al db
$conn = new mysqli('localhost','root','','testchart');
//query al db per prendere il prodotto e la quantità dalla tabella vendite del db tastchart
$query = "SELECT prodotto, quantita FROM vendite";
//result
$result = $conn->query($query);
$etichette = [];
$valori = [];

while ($row = $result->fetch_assoc()){
    $etichette[] = $row['prodotto'];
    $valori[] = $row['quantita'];
}

$conn->close();

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <h2>Vendite per prodotto (mysql)</h2>
    <canvas id="graficoMysql"></canvas>
    


    <script>
        
     const labels =  <?php echo json_encode($etichette); ?>;
     const data =  <?php echo json_encode($valori); ?>;

     const ctx = document.getElementById('graficoMysql').getContext('2d');

     new Chart (ctx, {

        type: 'bar',
        data: {
            labels: labels,
            datasets: [{

                label: 'Quantità',
                data: data,
                borderWidth: 1
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


