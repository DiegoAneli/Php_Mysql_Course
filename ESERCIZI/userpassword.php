<?php
// verifico che username e password siano stati inviati
if(isset($_POST['username'], $_POST['password'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    // credenziali hardcoded
    $user_valido = "admin";
    $pass_valida = "12345";
    // verifico le credenziali
    if($user === $user_valido && $pass === $pass_valida){
        echo "<p>Accesso riuscito!</p>";
    } else {
        echo "<p>Credenziali errate!</p>";
    }
}
?>

<form method="post">
    Username : <input type="text" name="username" required>
    Password : <input type="text" name="password" required>
    <input type="submit" value="Login">
</form>


