<?php
include 'includes/config.php';
include 'includes/header.php';

// Inscription
if (isset($_POST['inscrire'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mdp) VALUES (?, ?, ?)");
    $stmt->execute([$nom, $email, $mdp]);
    echo "<p>Compte créé avec succès !</p>";
}

// Connexion
if (isset($_POST['connexion'])) {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($mdp, $user['mdp'])) {
        echo "<p>Connexion réussie !</p>";
        session_start();
        $_SESSION['user'] = $user['nom'];
    } else {
        echo "<p>Email ou mot de passe incorrect.</p>";
    }
}
?>

<section>
    <h2>Mon compte</h2>
    <div style="max-width:400px;margin:auto;">
        <h3>Inscription</h3>
        <form method="post">
            <input type="text" name="nom" placeholder="Nom complet" required><br><br>
            <input type="email" name="email" placeholder="Email" required><br><br>
            <input type="password" name="mdp" placeholder="Mot de passe" required><br><br>
            <button type="submit" name="inscrire" class="btn">S'inscrire</button>
        </form>

        <h3>Connexion</h3>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required><br><br>
            <input type="password" name="mdp" placeholder="Mot de passe" required><br><br>
            <button type="submit" name="connexion" class="btn">Se connecter</button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
