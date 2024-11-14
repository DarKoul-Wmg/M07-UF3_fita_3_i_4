<html>
 <head>
 	<title> Ex 3.2 Willy</title>

     <style>
 		body{
 		}
 		table,td {
 			border: 1px solid black;
 			border-spacing: 0px;
 		}
 	</style>
 </head>
 
 <body>
 	<h1>Llistat de ciutats filtrades per nombre d'habitants.</h1>
     <form method="post" action="ex32.php">

        <label for="llengua">Filtre per llengua:</label>
        <input type="text" id="llengua" name="llengua"><br/><br/>

        <input type="submit" value="Filtrar">
    </form>
 	<?php
 		# (1.1) Connectem a MySQL (host,usuari,contrassenya)
 		$conn = mysqli_connect('localhost','admin','admin123');
 
 		# (1.2) Triem la base de dades amb la que treballarem
 		mysqli_select_db($conn, 'mundo');
 
		if(isset($_POST['llengua']) && !empty($_POST['llengua'])){
			
			$filtre = $_POST['llengua'];

			// consulta 
			$consulta = "SELECT DISTINCT Language, isOfficial FROM countryLanguage WHERE Language LIKE '%$filtre%' ORDER BY Language;";
			
			# (2.2) enviem la query al SGBD per obtenir el resultat
			$resultat = mysqli_query($conn, $consulta);

			//errores
			if (!$resultat) {
					$message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
					$message .= 'Consulta realitzada: ' . $consulta;
					die($message);
			}
		
			if($resultat && mysqli_num_rows($resultat) > 0){
				echo "<ul>";
				while ($row = mysqli_fetch_assoc($resultat)){
					$nomLlengua = $row['Language'];
					$oficial = $row['isOfficial'] == 'T' ? "[OFICIAL]" : "";

					echo "<li>$nomLlengua $oficial</li>";
				}
		
				echo "</ul>";
			} else{
				echo "No s'han trobat llengua que coincideix amb el filtre";
			}
		}
 	?>
 </body>
</html>