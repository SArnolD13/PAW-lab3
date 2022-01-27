<! DOCTYPE html>
<html>
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	</head>
		<title>PHP</title>
		<!--<script scr="https://code.jquery.com/jquery-2.1.3.min.js"></script>-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</body>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<!--toate astea erau doar pentru bootstrap, sa arata mai bine pagina -->
		<?php require_once 'process.php'; ?> <!--ataseaza un alt file unde se fac precesurile de php si mysql -->
		<?php 
		if(isset($_SESSION['message'])): ?> <!-- verifica daca trebuie afisat un mesaj sau nu -->
		<div class="alert alert-<?=$_SESSION['msg_type']?>">  <!-- afiseaza mesajul potrivit primit din process.php -->
		<!-- afiseaza mesaj --> <!-- reseteaza mesajul astel sa nu fie blocat pe ecran aceeasi mesaj -->
		<?php
			echo $_SESSION['message'];  
			unset($_SESSION['message']);  
		?>
		</div>
		<?php endif; ?>
		<div class="container"> 
		
		<!-- se connecteaza pe data de baze --> <!-- afisaza continutul tabelei "data" -->
		<?php
			$mysqli = new mysqli('localhost','root','','crud') or die(mysqli_error($mysqli));  
			$result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);  
			?>
			<div class="row justify-content-center">  <!--ajusteaza pagina -->
				<table class="table">
				<thead>
					<tr>
						<th>Nume</th>
						<th>Location</th>
						<th colspan="2">Buton</th> 
					</tr>
				</thead>
				<?php
					while ($row = $result->fetch_assoc()): ?>  <!-- cat timp exista date in tabel , afiseaza -->
				<tr> 
					<td><?php echo $row['name']; ?></td> 
					<td><?php echo $row['location']; ?></td>
					<td>
						<a href="index.php?edit=<?php echo $row['id']; ?>" 
							class="btn btn-outline-primary"><hard>Edit</hard></a>  <!-- butonul de editare, care si contine id-ul coloanei din database  -->
						<a href="process.php?delete=<?php echo $row['id']; ?>"
							class="btn btn-danger"><hard>Delete</hard></a>  <!-- simular cu butonul edit, astfel fiecare elemetn al tabelului are propria buton -->
							
					</td>
				</tr>
				<?php endwhile; ?>
				
				</table>
			</div>
		<div class="row justify-content-center">
		
		<form action="process.php" method="POST">
		<input type="hidden" name="id" value=-<?php echo $id; ?>"> <!-- acest label ascus este metoda mea de a afla id-ul elementului selectat pentru editare -->
			<div class="form-group">
			<label>Name:</label>
			<input type="text" name="name" class="form-controll"
				value="<?php echo $name; ?>" placeholder="Numele dmv">
			</div>
			<div class="form-group">
			<label>Location:</label>
			<input type="text" name="location" class="form-controll"
				value="<?php echo $location; ?>" placeholder="Adressa dmv">
			</div>
			<div class="form-group">
			<?php 
				if ($update == true):
			?>
			<button type="submit" class="bnt btn-info" name="update"><hard>Update</hard></button>
			<?php else: ?>
			<button type="submit" class="bnt btn-primary" name="save"><hard>Save</hard></button>
			<?php endif; ?>
			</div>
		</form>
		</div>
		</div>
	</body>
</html>