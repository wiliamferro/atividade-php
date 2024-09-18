<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sistema_pedidos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if (isset($_POST['create'])) {
    $nome_cliente = $_POST['nome_cliente'];
    $nome_produto = $_POST['nome_produto'];
    $quantidade = $_POST['quantidade'];
    $data_pedido = $_POST['data_pedido'];

    $sql = "INSERT INTO pedidos (nome_cliente, nome_produto, quantidade, data_pedido) VALUES ('$nome_cliente', 
    '$nome_produto', '$quantidade', '$data_pedido')";

    if ($conn->query($sql) === TRUE) {
        echo "Novo pedido adicionado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nome_cliente = $_POST['nome_cliente'];
    $nome_produto = $_POST['nome_produto'];
    $quantidade = $_POST['quantidade'];
    $data_pedido = $_POST['data_pedido'];

    $sql = "UPDATE pedidos SET nome_cliente='$nome_cliente', nome_produto='$nome_produto'
    , quantidade='$quantidade', data_pedido='$data_pedido' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Pedido atualizado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM pedidos WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Pedido excluído com sucesso!";
    } else {
        echo "Erro ao excluir o pedido: " . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM pedidos");
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD - Sistema de Pedidos</title>
</head>
<body>

<h2>Adicionar Pedido</h2>
<form method="POST" action="">
    Nome do Cliente: <input type="text" name="nome_cliente" required><br><br>
    Produto: <input type="text" name="nome_produto" required><br><br>
    Quantidade: <input type="number" name="quantidade" required><br><br>
    Data do Pedido: <input type="date" name="data_pedido" required><br><br>
    <input type="submit" name="create" value="Adicionar Pedido">
</form>

<h2>Lista de Pedidos</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nome do Cliente</th>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Data do Pedido</th>
        <th>Ação</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['nome_cliente']; ?></td>
        <td><?php echo $row['nome_produto']; ?></td>
        <td><?php echo $row['quantidade']; ?></td>
        <td><?php echo $row['data_pedido']; ?></td>
        <td>
            <a href="index.php?delete=<?php echo $row['id']; ?>">Excluir</a>
            <a href="index.php?update=<?php echo $row['id']; ?>">Update</a>
        </td>
    </tr>
    <?php } ?>
</table>

<h2>Atualizar Pedido</h2>

<form method="POST" action="">
    ID do Pedido: <input type="number" name="id" required><br><br>
    Nome do Cliente: <input type="text" name="nome_cliente" required><br><br>
    Produto: <input type="text" name="nome_produto" required><br><br>
    Quantidade: <input type="number" name="quantidade" required><br><br>
    Data do Pedido: <input type="date" name="data_pedido" required><br><br>
    <input type="submit" name="update" value="Adicionar Pedido">
</form>


</body>
</html>

<?php $conn->close(); ?>