<?php 
session_start();
if(isset($_POST['ok']))
{
    $login=$_POST["mail"];
    $mdp=$_POST["mdp"];
    //$id= mysqli_connect("127.0.0.1","sonia","sonia","roille");
    $id= mysqli_connect("127.0.0.1","root","","roilleun");
    $connect= mysqli_query($id,"SET NAMES 'utf8'");
    $req="select * from client where mail='$login' and mdp='$mdp'";
    $result=mysqli_query($id,$req);
    
    if(mysqli_num_rows($result)>0)
    {
        if (isset($_POST['rememberMe']))
        {
            setcookie('nom',$login,time()+365*24*3600,null,null,false,true);
            setcookie('mdp',$mdp,time()+365*24*3600,null,null,false,true);
        }
        $ligne=mysqli_fetch_assoc($result);
        $_SESSION['id_client']=$ligne['id_client'];$_SESSION['nom']=$ligne['nom'];
        $_SESSION['addresse']=$ligne['addresse'];$_SESSION['codeP']=$ligne['codeP'];
        $_SESSION['ville']=$ligne['ville'];$_SESSION['pays']=$ligne['pays'];
        $_SESSION['phone']=$ligne['phone'];$_SESSION['mail']=$ligne['mail'];

        $log=$_SESSION['id_client'];
        $req2="insert into histoConnexion (dateD,dateF,id_client)
            values (NOW(),'',$log)";
            mysqli_query($id,$req2);
        header('location:index.php?id='. $_SESSION["id_client"]);
    }
    else
    {
        $erreur= "connexion impossible, login ou mot de passe incorrect ....";
    }
}

   
    // Sélection et affichage du template PHTML.
$template = 'connexion';
include 'layout.phtml';







