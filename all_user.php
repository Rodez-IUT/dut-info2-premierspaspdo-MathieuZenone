<!DOCTYPE html>
<html lang="fr">
  <head>
		<meta charset="utf-8">
		<!-- Bootstrap CSS -->
		<!--<link href="../TD6/site/bootstrap/css/bootstrap.css" rel="stylesheet">-->
		<link href="../testFonctionnement/bootstrap/css/bootstrap.css" rel="stylesheet">
		<!--<link href="../TD6/site/font-awesome/css/font-awesome.css" rel="stylesheet">-->
		<title>script PHP</title>
   </head>
	


	
	
	<body>
	
		 <?php
			/* link a la BD */
			$host = 'localhost';
			$db   = 'my_activities';
			$user = 'root';
			$pass = 'root';
			$charset = 'utf8mb4';
			$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
			$options = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			];
			try {
				 $pdo = new PDO($dsn, $user, $pass, $options);
			} catch (PDOException $e) {
				 throw new PDOException($e->getMessage(), (int)$e->getCode());
			}
			
			function get($name) {
				return isset($_GET[$name]) ? $_GET[$name] : null;
			}
		?>
		
		<!--  -->
		<div class="container">
			<div class="row">
				<!-- entete -->
				<div class="col-xs-12 cadre">
					<h1>ALL User</h1>
					
					<!-- formlaire -->
					<form action="all_user.php" method="get">
						Start with letter:
						<input name="start_letter" type="text" value="<?php echo get("start_letter") ?>">
						and status is:
						<select name="status_id">
							<option value="1" <?php if (get("status_id") == 1) echo 'selected' ?>>Waiting for account validation</option>
							<option value="2" <?php if (get("status_id") == 2) echo 'selected' ?>>Active account</option>
						</select>
						<input type="submit" value="OK">
					</form>

					
					<!-- table resultat -->
					<table class="table table-bordered table-striped">
						<tr>
							<th>ID</th>
							<th>Username</th>
							<th>Email</th>
							<th>Status</th>
						</tr>
						<?php
							/* afficher user filtrer */
							$status_id = get("status_id");
							$lettreDebut = htmlspecialchars(get("start_letter"));
							$sql= "SELECT users.id AS id, username, email, name 
							                     FROM users 
												 JOIN status 
												 ON users.status_id = status.id 
												 WHERE status.id ='$status_id'
												 AND username LIKE '$lettreDebut%' 
												 ORDER by username";
							
							$stmt = $pdo->query($sql);
												 
							while ($row = $stmt->fetch()) {
								echo "<tr>";
									echo "<td>". $row['id'] . "</td>";
									echo "<td>". $row['username'] . "</td>";
									echo "<td>". $row['email'] . "</td>";
									echo "<td>". $row['name'] . "</td>";
								echo "</tr>";
							}
						?>
					</table>
				</div>
			</div>
		</div>
	</body>
	
	
	
	
</html>