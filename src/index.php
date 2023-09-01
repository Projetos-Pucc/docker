<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <title>Banco de dados</title>
</head>
<body>
<?php

	$pdo = new PDO("mysql:host=mariadb;dbname=mydatabase", 'user', 'user_password');
	$query = "CREATE TABLE IF NOT EXISTS lista (id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(60), quantidade INT) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
	$stmt = $pdo->prepare($query);
	$stmt->execute();

	if(isset($_POST["action"])){
		$nome = $_POST['nomeItem'];
		$quantidade = $_POST['qtd'];

		$insert = $pdo->prepare("INSERT INTO lista (nome,quantidade) VALUES (:nome,:quantidade)");
		$insert->bindParam(":nome",$nome);
		$insert->bindParam(":quantidade",$quantidade);
		$insert->execute();
	}

	if(isset($_GET['delete'])){
		$id = $_GET['delete'];
		$delete = $pdo->prepare("DELETE FROM lista WHERE id = :id");
		$delete->bindParam(':id',$id);
		if($delete->execute())
		echo "item deletado";
	}
?>

    <form class="center-box" method = "POST">

        <input type="text" name = "nomeItem" class="input1" placeholder="name">
        <input type="number" name = "qtd" class="input2" placeholder="qtd">
        <input type="submit" value="Cadastrar" class="styled-button" name="action">
    </form>
        
	
	<div class="table">
		<div class="table-header">
			<div class="header__item">Item</div>
			<div class="header__item">Quantidade</div>
			<div class="header__item">Botoes</div>
		</div>
		<div class="table-content">	
<?php
	$select = $pdo->prepare("SELECT * FROM lista");
	$select->execute();
	$data = $select->fetchAll();

		if($select->rowCount() != 0){
			foreach ($data as $key => $value) {
				echo '<div class="table-row">';
				echo '<div class="table-data">'.$value["nome"].'</div>';
				echo '<div class="table-data">'.$value["quantidade"].'</div>';
				echo '<div class="table-data"><a href="?delete='.$value['id'].'">Remover</a></div>';
				echo '</div>';
			}
		}
?>
		</div>	
	</div>
</body>
</html>