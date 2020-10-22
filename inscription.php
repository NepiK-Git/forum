<?php
session_start();
require "constants.php";
require "functions.php";
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Forum Gamer</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/product/">

    <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/4.5/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/4.5/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/4.5/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/4.5/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/4.5/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
<link rel="icon" href="/docs/4.5/assets/img/favicons/favicon.ico">
<meta name="msapplication-config" content="/docs/4.5/assets/img/favicons/browserconfig.xml">
<meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="main.css" rel="stylesheet">
  </head>
  
  <body>
        <nav class="site-header sticky-top py-1">
  <div class="container d-flex flex-column flex-md-row justify-content-between bg-success">
    <h4>Minecraft</h4>
    <a class="py-2 d-none d-md-inline-block" href="index.php">Acceuil</a>
    <a class="py-2 d-none d-md-inline-block" href="#">Categories</a>
    <a class="py-2 d-none d-md-inline-block" href="inscription.php">Inscription</a>
    <a class="py-2 d-none d-md-inline-block" href="compte.php">Compte</a>
    
    <a class="py-2 d-none d-md-inline-block" href="deconexion.php">Deconexion</a>

  </div>
</nav>
<?php
        
        $bdd = connectBDD(NAMEBDD,ROOT,HOST,MDPBDD);
    
    if(isset($_GET['mdp']) && $_GET['mdp'] == "forget"){
        
        $mdp = generateMdp();
        
       // mail("aaa@gmail","Reinit mdp","Votre nouveau mdp est".$mdp);
        
        $mdp = sha1($mdp);
        
        $requete = $bdd->query("UPDATE users SET mdp = '".$mdp."' where id_u = 1");
        
       
        
        ?>
    <div class="container">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Votre nouveau mdp vous a été envoyé par email!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <?php
        
        
    }
    
    if(isset($_POST['submit'])){
    //recuperation des informations
        $civ = $_POST['civ'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $mdp = sha1($_POST['mdp']);// crypte le mot de passe
        
       
        $requete = $bdd->prepare('INSERT INTO users(lastName,firstName,email,mdp) VALUES(:lastName,:firstName,:email,:mdp)');
        $requete->bindValue(':lastName',$lastName,PDO::PARAM_STR);
        $requete->bindValue(':firstName',$firstName,PDO::PARAM_STR);
        $requete->bindValue(':email',$email,PDO::PARAM_STR);
        $requete->bindValue(':mdp',$mdp,PDO::PARAM_STR);
        $requete->execute();
        
        $_SESSION['id_u'] = $bdd->lastInsertId();
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        
        //redirection
        header("Location:compte.php");
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12">

                <form class="mt-5" action="#" method="post">
                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">Civilité</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="civ" id="gridRadios1" value="Mr" checked>
                                    <label class="form-check-label" for="gridRadios1">
                                        Mr
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="civ" id="gridRadios2" value="Mme">
                                    <label class="form-check-label" for="gridRadios2">
                                        Mme
                                    </label>
                                </div>

                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group row">
                        <label for="inputLastName" class="col-sm-2 col-form-label">Nom</label>
                        <div class="col-sm-10">
                            <input type="text" name="lastName" class="form-control" id="inputLastName" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputfirstName" class="col-sm-2 col-form-label">Prenom</label>
                        <div class="col-sm-10">
                            <input type="text" name="firstName" class="form-control" id="inputfirstName" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" class="form-control" id="inputEmail3" required pattern="^[a-z0-9.-_]+@[a-z0-9.-_]+\.[a-z]{2,6}$">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Mot de passe</label>
                        <div class="col-sm-10">
                            <input type="password" name="mdp" class="form-control" id="inputPassword3" required pattern="[A-Aa-z0-9]+">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2">Se souvenir de moi</div>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1">
                                <label class="form-check-label" for="gridCheck1">

                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <!--- le ? signifie passage d'argument. --->
                            <a href="index.php?mdp=forget">Mot de passe oublié</a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" name="submit" class="btn btn-primary">Inscription</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>





<footer class="container py-5">
  <div class="row">
    <div class="col-12 col-md">
      <small class="d-block mb-3 text-muted">&copy; 2020-2021</small>
    </div>
    
  </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>
</html>
