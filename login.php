<?php

require 'db.php';

session_start(); //start de sessie


$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //checked of het get of post is
    
    $username = htmlspecialchars($_POST['username']); //beveiliging
    $password = htmlspecialchars($_POST['password']);


    $query = "SELECT * FROM users WHERE username = ?"; // Correcte SQL-query
    $stmt = $conn->prepare($query); // Bereid de query voor
    $stmt->bind_param("s", $username); // Bind de parameter
    $stmt->execute(); 
    $result = $stmt->get_result(); // Verkrijg het resultaat
    $user = $result->fetch_assoc(); // Haal de gebruiker op


    if ($user && password_verify($password, $user['password'])) { // controleer of gebruiker bestaat en wachtwoord overeenkomt
        $_SESSION['username'] = $username; // sessie gebruikersnaam instellen
        header('Location: read_boxers.php'); //stuur je door naar de hoofpagine dus read boxer
        exit; //stop de script
    } else {
        $error = 'Ongeldige inloggegevens'; //je krijgt ongeeldige inloggegevens te zien als je een error hebt
    }
    
    $stmt->close(); // sluit de statement
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inloggen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('img/boxing3.jpg');
            background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center; 
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            color: #d62828; /* Donkerrood */
        }

        a {
            color: #003049; /* Donkerblauw */
            text-decoration: none;
        }

        a:hover {
            color: #f77f00; /* Oranje */
        }

        button {
            background-color: #003049; /* Donkerblauw */
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #d62828; /* Donkerrood */
        }

        form {
            background-color: #C5C5C5;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 20px;
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .container {
            text-align: center;
        }

        .message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
<?php
// Als er een fout is, toon de foutmelding
if ($error) {
    echo '<p class="message">' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</p>';
}
?>
    <form method="post" action="login.php">
        <h1>Inloggen</h1>
        Gebruikersnaam: <input type="text" name="username" required>
        Wachtwoord: <input type="password" name="password" required>
        <button type="submit">Inloggen</button>
        <p>Nog geen account? <a href="register.php">Registreren</a></p>
    </form>
</div>
</body>
</html>
