<html>
<head>
    <title>Menú de selección de países con filtro de continente</title>
    <style>
    </style>
</head>

<body>

    <?php
    # (1.1) Conexión a MySQL (host, usuario, contraseña)
    $conn = mysqli_connect('localhost', 'admin', 'admin123');

    # (1.2) Seleccionamos la base de datos
    mysqli_select_db($conn, 'mundo');

    # (2.1) Consulta para obtener los continentes únicos
    $consultaContinentes = "SELECT DISTINCT continent FROM country";
    $resultatContinentes = mysqli_query($conn, $consultaContinentes);

    ?>

    <!-- seleccionar el continente -->
    <divE>
    <h1>Checkbox de Continentes y Países</h1>
    <form method="post" action="">
        <h3>Seleccione un continente o varios:</h3>
            <?php
            #dropdown de continentes
            while ($row = mysqli_fetch_assoc($resultatContinentes)) {
                $continent = $row['continent'];
                echo "<br/>";
                echo "<label for='$continent'>$continent</label>";
                echo "<input type='checkbox' name='continents[]' value='$continent'id='$continent'>";
            }
            ?>
        <br/>
        <button type="submit">Filtrar</button>
    </form>
    </divE>

    <divD>
    <?php
    # verificacion continente
    if (isset($_POST['continents'])) {
        $arrayContinents = $_POST['continents'];
        $stringContinents = "'" . implode("','", $arrayContinents) . "'";
        // var_dump($stringContinents);

        # consulta para obtener los países del continente seleccionado
        $consultaPaises = "SELECT name FROM country WHERE continent in ($stringContinents) ORDER BY name ASC";
        $resultatPaises = mysqli_query($conn, $consultaPaises);

        echo "<h2>Países en continentes seleccionados: </h2>";
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($resultatPaises)) {
            echo "<li>" . $row['name'] . "</li>";
        }
        echo "</ul>";
    }
    ?>
    </divD>

</body>
</html>
