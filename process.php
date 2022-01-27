<?php

	session_start(); 
	$mysqli = new mysqli('localhost','root','','crud') or die(mysqli_error($mysqli)); //conectare la baza de date
	
	$id=0; //id-ul inrefistrare
	$update=false; //daca se face update sau nu
	$name=''; //1. coloana din tabela
	$location=''; //2.coloana din tabela
	
	if (isset($_POST['save'])){  //daca este apasat butonul save
		$name=$_POST['name']; //salveaza date din prima rublica
		$location=$_POST['location']; //salveaza date din a  doua prima rublica
		
		$mysqli->query("INSERT INTO data(name, location) VALUES('$name','$location')") or die(mysqli->error); //insereaza in tabela de mqsql cu ajutorul unei query
		
		$_SESSION['message']="Inregistrare sa facut cu suces!"; //trimitera unei mesaj potrivit
		$_SESSION['msg_type']="success"; //tag-ul mesajului tag-ul messajului formatat cu bootstrap
		
		header("location: index.php"); //retrimite la prima pagina
	}
	
	if (isset($_GET['delete'])){ //daca este apasat butonul delete
		$id=$_GET['delete']; //salveaza id-ul al elementului selectat
		$mysqli->query("DELETE FROM data WHERE id=$id") or die ($mysqli->error()); //sterge elmentul associat de id
		
		$_SESSION['message']="Stergerea sa facut cu suces!"; //messaj potrivit
		$_SESSION['msg_type']="danger"; //tag-ul messajului formatat cu bootstrap
		header("location: index.php"); //retrimite la prima pagina
	} 
	
	if(isset($_GET['edit'])){ //daca este apasat butonul  edit
		$id = $_GET['edit']; //salveaza id-ul al elementului selectat
		$update = true;
		$result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error()); //afiseaza elmentul associat de id pe rublicele  potrivite
		if ( count(array($result))==1){ //daca rezultatul este real
			$row = $result->fetch_array(); //se salveaza datele in $row
			$name = $row['name']; 
			$location = $row['location'];
		}
	}
	if (isset($_POST['update'])){
		$id =$_POST['id']; //ii puscat, returneaza cu cu "-" id-ul..why?		
		$id =(int)$id; //string to int
		$id =abs($id); //valoarea absoluta
		$name = $_POST['name'];
		$location = $_POST['location'];
		
		$mysqli->query("UPDATE data SET name ='$name', location = '$location' WHERE id='$id'") or die($mysqli->error); //actualizeaza elementul selectat
		
		$_SESSION['message']="Inregsitrarea a fost actualizata!"; //mesaj potrivit
		$_SESSION['msg_type']="warning"; //tag-ul messajului formatat cu bootstrap

		header('location: index.php');
	}
?>