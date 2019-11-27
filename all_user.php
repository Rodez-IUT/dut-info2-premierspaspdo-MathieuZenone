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
							<option value="3" <?php if (get("status_id") == 3) echo 'selected' ?>>Waiting for account deletion</option>
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
							$lettreDebut = htmlspecialchars(get("start_letter").'%');
							$sql = "select users.id as user_id, username, email, s.name as status 
									from users 
									join status s on users.status_id = s.id 
									where username like :start_letter and status_id = :status_id 
									order by username";
							$stmt = $pdo->prepare($sql);
							$stmt->execute(['start_letter' => $lettreDebut, 'status_id' => $status_id]);
							
							
												 
							while ($row = $stmt->fetch()) {
								echo "<tr>";
									echo "<td>". $row['user_id'] . "</td>";
									echo "<td>". $row['username'] . "</td>";
									echo "<td>". $row['email'] . "</td>";
									echo "<td>". $row['status'] . "</td>";
								echo "</tr>";
							}
						?>
					</table>
				</div>
			</div>
		</div>
	</body>
	
	
	
	
</html>