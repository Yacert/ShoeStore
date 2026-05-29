<?php
session_start();
include 'includes/config.php';
include 'includes/header.php';

// Ajouter au panier si action "add" reçue
if (isset($_GET['add'])) {
    $id = intval($_GET['add']);
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
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

// Si tu veux, tu peux aussi récupérer tous les produits depuis la base
//$stmt = $pdo->query("SELECT * FROM produits");
//$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section id="produits">
    <h2>Nos chaussures</h2>

    <?php if (isset($message)) echo "<p style='color:green;'>$message</p>"; ?>

    <div class="products">
        <!-- Produit 1 -->
        <div class="product">
            <img src="https://images.pexels.com/photos/18681256/pexels-photo-18681256.jpeg" alt="Sneakers Sport">
            <h3>Sneakers Sport</h3>
            <p class="price">45 000 FCFA</p>
            <a href="chaussures.php?add=1" class="btn">Ajouter au panier</a>
        </div>

        <!-- Produit 2 -->
        <div class="product">
            <img src="https://images.pexels.com/photos/6764994/pexels-photo-6764994.jpeg" alt="Chaussures Classiques">
            <h3>Chaussures Classiques</h3>
            <p class="price">55 000 FCFA</p>
            <a href="chaussures.php?add=2" class="btn">Ajouter au panier</a>
        </div>

        <!-- Produit 3 -->
        <div class="product">
            <img src="https://images.pexels.com/photos/4490019/pexels-photo-4490019.jpeg" alt="Baskets Urbaines">
            <h3>Baskets Urbaines</h3>
            <p class="price">40 000 FCFA</p>
            <a href="chaussures.php?add=3" class="btn">Ajouter au panier</a>
        </div>

        <!-- Produit 4 -->
        <div class="product">
            <img src="https://images.pexels.com/photos/15693842/pexels-photo-15693842.jpeg" alt="Chaussures de Sport">
            <h3>Chaussures de Sport</h3>
            <p class="price">50 000 FCFA</p>
            <a href="chaussures.php?add=4" class="btn">Ajouter au panier</a>
        </div>

        <!-- Produit 5 -->
        <div class="product">
            <img src="https://images.pexels.com/photos/7887198/pexels-photo-7887198.jpeg" alt="Mocassins Élégants">
            <h3>Mocassins Élégants</h3>
            <p class="price">60 000 FCFA</p>
            <a href="chaussures.php?add=5" class="btn">Ajouter au panier</a>
        </div>

        <!-- Produit 6 -->
        <div class="product">
            <img src="https://images.pexels.com/photos/8830049/pexels-photo-8830049.jpeg" alt="Sandales Confort">
            <h3>Sandales Confort</h3>
            <p class="price">35 000 FCFA</p>
            <a href="chaussures.php?add=6" class="btn">Ajouter au panier</a>
        </div>

        <!-- Produit 7 -->
        <div class="product">
            <img src="https://images.pexels.com/photos/19882423/pexels-photo-19882423.jpeg" alt="Crampons nike">
            <h3>Crampons nike</h3>
            <p class="price">100 000 FCFA</p>
            <a href="chaussures.php?add=5" class="btn">Ajouter au panier</a>
        </div>

        <!-- Produit 8 -->
        <div class="product">
            <img src="https://images.pexels.com/photos/25906614/pexels-photo-25906614.jpeg" alt="Crocs">
            <h3>Crocs</h3>
            <p class="price">5 000 FCFA</p>
            <a href="chaussures.php?add=5" class="btn">Ajouter au panier</a>
        </div>


    </div>
</section>

<?php include 'includes/footer.php'; ?>
