<!DOCTYPE html>
<html>
<head>
    <title>Graph from MySQL Data</title>
    <!-- Include Chart.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body>
    <div style="width: 80%; margin: auto;">
        <canvas id="myChart"></canvas>
    </div>

    <?php
    // Database connection details
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'superschool';

    // Create a connection to the database
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to retrieve data from your table (customize this query)
    $sql = "SELECT date_column, value_column FROM your_table";
    $result = $conn->query($sql);

    // Prepare data for the graph
    $labels = [];
    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['date_column'];
            $data[] = $row['value_column'];
        }
    }

    // Close the database connection
    $conn->close();
    ?>

    <script>
        // JavaScript code to create a line chart using Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Data',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
