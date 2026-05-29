<?php
include 'includes/config.php';
include 'includes/header.php';

// Formulaire de contact
if (isset($_POST['envoyer'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $pdo->prepare("INSERT INTO contact (nom, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$nom, $email, $message]);

    echo "<p>Message envoyé avec succès !</p>";
}
?>

<section>
    <h2>Contactez-nous</h2>
    <form method="post" style="max-width:400px;margin:auto;">
        <input type="text" name="nom" placeholder="Nom" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <textarea name="message" placeholder="Votre message" required></textarea><br><br>
        <button type="submit" name="envoyer" class="btn">Envoyer</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
