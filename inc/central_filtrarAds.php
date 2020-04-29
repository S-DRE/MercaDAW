<form class = "my-2 my-lg-0 text-center" action = "/index.php?load=buscarAds" method = "post">
<?php
$pdo = Basedatos3::getConexion();

$filtro = '%'.$_POST['textoInput'].'%';

$stmt = $pdo->prepare("SELECT anuncios.*, usuarios.nick FROM anuncios JOIN usuarios ON anuncios.idusuario = usuarios.id WHERE idusuario = ? AND titulo LIKE ?");

$stmt->bindParam(1, $_SESSION['id']);
$stmt->bindParam(2, $filtro);

$stmt->execute();

$contador = 0;

if ($stmt->rowCount() >= 1) {
    header('location: index.php?load=buscarAds');
} else {
    echo "No hay anuncios que correspondan a los criterios seleccionados\n";
    echo "<br><br/>[DEBUG]CRITERIOS: TEXTO ->".$_POST['textoInput'];
    echo "<br><br/>USER -> ".$_SESSION['id'];
}
?>
</form>