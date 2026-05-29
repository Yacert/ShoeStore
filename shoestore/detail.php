<?php
include 'config.php';

// Vérifie si l'ID du produit est passé dans l'URL
if (!isset($_GET['id'])) {
    die("Produit non spécifié !");
}

$id = intval($_GET['id']); // sécurise l'ID

// Récupère le produit depuis la base de données
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    die("Produit introuvable !");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail - <?= htmlspecialchars($produit['nom']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<h1><?= htmlspecialchars($produit['nom']); ?></h1>
<div class="product-detail">
    <img src="<?= htmlspecialchars($produit['image']); ?>" alt="<?= htmlspecialchars($produit['nom']); ?>">
    <p><?= htmlspecialchars($produit['description']); ?></p>
    <p class="price"><?= htmlspecialchars($produit['prix']); ?> FCFA</p>
    <a href="panier.php?add=<?= $produit['id']; ?>" class="btn">Ajouter au panier</a>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
