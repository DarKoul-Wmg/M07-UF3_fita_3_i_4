<html>
<head>
    <title>Menú de selección de países con filtro de continente</title>
</head>

<body>
    <h1>Dropdown de Continentes y Países</h1>

    <?php
    # (1.1) Conexión a MySQL (host, usuario, contraseña)
    $conn = mysqli_connect('localhost', 'admin', 'admin123');

    # (1.2) Seleccionamos la base de datos
    mysqli_select_db($conn, 'mundo');

    # (2.1) Consulta para obtener los continentes únicos
    $consultaContinentes = "SELECT DISTINCT continent FROM country";
    $resultatContinentes = mysqli_query($conn, $consultaContinentes);

    # (2.2) Si no hay resultado, mostrar mensaje de error y finalizar
    if (!$resultatContinentes) {
        $message  = 'Consulta inválida: ' . mysqli_error($conn) . "\n";
        $message .= 'Consulta realizada: ' . $consultaContinentes;
        die($message);
    }

    ?>

    <!-- seleccionar el continente -->
    <form method="GET" action="">
        <label for="continent">Seleccione un continente:</label>
        <select name="continent" id="continent">
            <option value="">--Continente--</option> 
            <?php
            #dropdown de continentes
            while ($row = mysqli_fetch_assoc($resultatContinentes)) {
                echo "<option>" . $row['continent'] . "</option>";
            }
            ?>
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <?php
    # verificacion continente
    if (isset($_GET['continent']) && $_GET['continent'] != '') {
        $continentSeleccionado = mysqli_real_escape_string($conn, $_GET['continent']);

        # consulta para obtener los países del continente seleccionado
        $consultaPaises = "SELECT name FROM country WHERE continent = '$continentSeleccionado' ORDER BY name ASC";
        $resultatPaises = mysqli_query($conn, $consultaPaises);

        # si no hay resultado, mostrar mensaje de error y finalizar
        if (!$resultatPaises) {
            $message  = 'Consulta inválida: ' . mysqli_error($conn) . "\n";
            $message .= 'Consulta realizada: ' . $consultaPaises;
            die($message);
        }

        echo "<h2>Países en $continentSeleccionado</h2>";
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($resultatPaises)) {
            echo "<li>" . $row['name'] . "</li>";
        }
        echo "</ul>";
    }
    ?>

</body>
</html>
