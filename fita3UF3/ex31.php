<html>
 <head>
 	<title> Ex 3.1 Willy</title>

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
     <form method="GET" action="ex31.php">

        <label for="min_habitants">Mínimo de habitants:</label>
        <input type="number" id="min_habitants" name="min_habitants"><br/><br/>

        <label for="max_habitants">Máximo de habitants:</label>
        <input type="number" id="max_habitants" name="max_habitants"><br/><br/>

        <input type="submit" value="Filtrar">
    </form>
 	<?php
 		# (1.1) Connectem a MySQL (host,usuari,contrassenya)
 		$conn = mysqli_connect('localhost','admin','admin123');
 
 		# (1.2) Triem la base de dades amb la que treballarem
 		mysqli_select_db($conn, 'mundo');
 
 		# (2.1) creem el string de la consulta (query)

        #Si existeixen els paràmetres min_habitants i max_habitants, fem la consulta amb aquests paràmetres
        if (!isset($_GET['min_habitants']) && !isset($_GET['max_habitants'])) {
            $consulta = "SELECT * FROM city order by population DESC;";

        } else {
            
            $min_habitants = $_GET['min_habitants'];
            $max_habitants = $_GET['max_habitants'];

            $consulta = "SELECT * FROM city WHERE population BETWEEN $min_habitants AND $max_habitants order by population DESC;";
        }
 		# (2.2) enviem la query al SGBD per obtenir el resultat
 		$resultat = mysqli_query($conn, $consulta);
 
 		# (2.3) si no hi ha resultat (0 files o bé hi ha algun error a la sintaxi)
 		#     posem un missatge d'error i acabem (die) l'execució de la pàgina web
 		if (!$resultat) {
     			$message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
     			$message .= 'Consulta realitzada: ' . $consulta;
     			die($message);
 		}
 	?>
    
 	<!-- (3.1) aquí va la taula HTML que omplirem amb dades de la BBDD -->
 	<table>
 	<!-- la capçalera de la taula l'hem de fer nosaltres -->
 	<thead>
		<th colspan="4" align="center" bgcolor="cyan">Llistat de ciutats</th>
	</thead>
 	<?php
		$count = 0;
 		# (3.2) Bucle while
 		while( $registre = mysqli_fetch_assoc($resultat) )
 		{
 			# els \t (tabulador) i els \n (salt de línia) son perquè el codi font quedi llegible
  
 			# (3.3) obrim fila de la taula HTML amb <tr>
 			echo "\t<tr>\n";
 
 			# (3.4) cadascuna de les columnes ha d'anar precedida d'un <td>
 			#	després concatenar el contingut del camp del registre
 			#	i tancar amb un </td>
 			echo "\t\t<td>".$registre["Name"]."</td>\n";
 			echo "\t\t<td>".$registre['CountryCode']."</td>\n";
 			echo "\t\t<td>".$registre["District"]."</td>\n";
 			echo "\t\t<td>".$registre['Population']."</td>\n";
 
 			# (3.5) tanquem la fila
 			echo "\t</tr>\n";
			$count++;
 		}
		 echo"<p>Total de resultats: $count</p>";
 	?>
	
  	<!-- (3.6) tanquem la taula -->
 	</table>	
 </body>
</html>