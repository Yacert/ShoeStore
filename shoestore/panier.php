<?php
session_start();
include 'includes/config.php';
include 'includes/header.php';

// Initialiser le panier si inexistant
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Ajouter un produit si l'utilisateur clique sur "Ajouter au panier"
if (isset($_GET['add'])) {
    $id = intval($_GET['add']);

    // Vérifier si le produit existe dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Ajouter au panier ou augmenter la quantité
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product['nom'],
                'price' => $product['prix'],
                'quantity' => 1
            ];
        }
        $message = "{$product['nom']} ajouté au panier !";
    }
}

// Supprimer un produit
if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    unset($_SESSION['cart'][$id]);
    $message = "Produit retiré du panier !";
}

// Validation de la commande
if (isset($_POST['valider_commande']) && !empty($_SESSION['cart'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $produits = json_encode($_SESSION['cart']);
    $total = array_sum(array_map(function($item) {
        return $item['price'] * $item['quantity'];
    }, $_SESSION['cart']));

    $stmt = $pdo->prepare("INSERT INTO commandes (nom_client, email, adresse, produits, total) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$nom, $email, $adresse, $produits, $total])) {
        $message = "✅ Commande validée avec succès ! Merci pour votre achat.";
        $_SESSION['cart'] = []; // vider le panier
    } else {
        $message = "❌ Erreur lors de la validation de la commande.";
    }
}
?>

<section id="panier">
    <h2>Votre panier</h2>

    <?php if (isset($message)) echo "<p style='color:green;'>$message</p>"; ?>

    <?php if (empty($_SESSION['cart'])): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php
            $grandTotal = 0;
            foreach ($_SESSION['cart'] as $id => $item):
                $total = $item['price'] * $item['quantity'];
                $grandTotal += $total;
            ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= number_format($item['price'], 0, '', ' ') ?> FCFA</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($total, 0, '', ' ') ?> FCFA</td>
                <td><a href="panier.php?remove=<?= $id ?>">Supprimer</a></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total général</strong></td>
                <td colspan="2"><strong><?= number_format($grandTotal, 0, '', ' ') ?> FCFA</strong></td>
            </tr>
        </table>

        <!-- Formulaire de validation -->
        <h3>Valider la commande</h3>
        <form method="POST">
            <input type="text" name="nom" placeholder="Nom complet" required><br><br>
            <input type="email" name="email" placeholder="Email" required><br><br>
            <input type="text" name="adresse" placeholder="Adresse de livraison" required><br><br>
            <button type="submit" name="valider_commande" class="btn">Valider la commande</button>
        </form>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
