<?php

session_start();

if($_SESSION['username'] !== ""){
    $user = $_SESSION['username'];
    echo "Bonjour $user, vous êtes connecté";
}

$con = new PDO('mysql:host=localhost;dbname=livreor', 'root', '');

echo nl2br("\nétape 0");
if(isset($_POST['envoyer'])) 
{
    echo nl2br("\nétape 1 : Le bouton est bien appuyé");

    if (!empty($user) && !empty($_POST['com']))
    {
      $iduser = $user;
      $com = $_POST['com'];
      $today = date("F j, Y, g:i a");
      echo nl2br("\nétape 2 : identifiants : $iduser, le message : $com et la date : $today");

        if($iduser !== "" && $com !== "") 
        {
            echo nl2br("\nétape 3 : les champs sont bien remplis");
            $sql = "INSERT INTO comment(id, coment, id_user, date) VALUES ('', '$com', '$iduser', '$today')";
            $statement = $con->prepare($sql);
            $result = $statement->execute();
            echo nl2br("\nétape 4 : le message $result est bien partit");
            
            if($result)
            {
                $sql2 = "SELECT * FROM comment";
                $statement = $con->prepare($sql2);
                $recupmessages = $statement->execute();
                echo nl2br("\nétape 5 : Recupmessages est bien pris en compte");
                if(!empty($recupmessages))
                {
                    echo nl2br("\nentré dans la boucle if de l'affichage");
                    foreach(array_column($recupmessages, 'id_user') as $userresult) //Vérification de la présence du login dans la colonne login de la BDD.
                    { 
                        echo
                        foreach(array_column($recupmessages, 'coment') as $comresult) ////Vérification de la présence du password dans la colonne password de la BDD.
                        {
                            foreach(array_column($recupmessages, 'date') as $dateresult) ////Vérification de la présence du password dans la colonne password de la BDD.
                            {
                                echo nl2br("\n$userresult à écrit $comresult le $dateresult");
                            }
                        }
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
</head>

<body>
    <h1> Page du livre d'or </h1>

    <form action="<?php echo($_SERVER['REQUEST_URI']); ?>" method="post">
        <div class="inputbox">
            <span>Ton commentaire :</span>
            <br>
            <input type="text" required="required" name="com" id="com" value="" />
        </div>

        <div class="inputbox">
            <input type="submit" value="envoyer" id="btn" name= "envoyer" />
        </div>
    </form>

    <div class="displaybox">
        <?php if(!empty($recupmessages))
                {
                    echo("$recupmessages");
                }
        ?>
    </div>

</body>
</html>