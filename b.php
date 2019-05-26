<form action="b.php" method="post">
    Nombre usuario: <input type="text" name="username" /><br />
    Email:  <input type="text" name="email" /><br />
    <input type="submit" name="submit" value="¡Enviarme!" />
</form>

<?php
echo $_POST['username'];
echo $_REQUEST['username'];
?>