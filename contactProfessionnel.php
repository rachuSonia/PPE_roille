<?php
require('application/database.php');
if(isset($_POST['envoyer']))
{
    if(!empty($_POST) && isset($_POST)){

        $nom=htmlspecialchars($_POST['nom']);
        $mdp=htmlspecialchars($_POST['mdp']);
        $addresse=htmlspecialchars($_POST['addresse']);
        $codeP=htmlspecialchars($_POST['codeP']);
        $ville=htmlspecialchars($_POST['ville']);
        $pays=htmlspecialchars($_POST['pays']);
        $phone=htmlspecialchars($_POST['phone']);
        $mail=htmlspecialchars($_POST['mail']);
        $siret=htmlspecialchars($_POST['siret']);
        $stautJ=htmlspecialchars($_POST['stautJ']);
        
        print_r($_POST);
        $errors=array();
        if(!empty($nom)){
            if(!empty($mdp)){
                if(strlen($mdp)>=8){
                    if(!empty($addresse)){
                        if(!empty($codeP)){
                            if(!empty($ville)){
                                if(!empty($pays)){
                                    if(!empty($phone)){
                                        if(preg_match("#^\d{6,10}$#",$phone)){
                                            if(!empty($mail)){
                                                if(filter_var($mail,FILTER_VALIDATE_EMAIL) && !preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9].[a-z]{2,4}$#", $mail)){
                                                    $pdo=createconnection();
                                                    $req=$pdo->prepare('SELECT mail FROM client WHERE mail=?');
                                                    $req->execute(array($mail));
                                                    $emailExite=$req->rowCount();
                                                    if($emailExite==0){
                                                        if(!empty($siret)){
                                                            if(!empty($stautJ)){
                                                                registerProfessionnel($nom,$mdp,$addresse,$codeP,$ville,$pays,$phone,$mail,$siret,$stautJ);
                                                                $succes='Votre compte ?? bien ??t?? cr??er !!';
                                                                unset($nom);
                                                                unset($mdp);
                                                                unset($birth_date);
                                                                unset($addresse);
                                                                unset($codeP);
                                                                unset($ville);
                                                                unset($pays);
                                                                unset($phone);
                                                                unset($mail);
                                                                unset($siret);
                                                                unset($stautJ);
                                                            }else{$errors['stautJ']="Entrez votre statut juridique !!";}
                                                        }else{$errors['siret']="Entrez votre Siret !!";}
                                                    }else{$errors['mail']="Votre mail existe d??j?? !!";}
                                                }else{$errors['mail']="Votre mail n'est pas valide!!";}
                                            }else{$errors['mail']="Entrez votre mail !!";}
                                        }else{$errors['phone']="Votre num??ro de t??l??phone n'ets pas valide !!";}
                                    }else{$errors['phone']='Entrez votre t??l??phone mobile !!';}
                                }else{$errors['pays']='Entrez votre pays de r??sidence !!';}
                            }else{$errors['ville']='Entrez votre ville !!';}
                        }else{$errors['codeP']='Entrez votre code postale !!';}
                    }else{$errors['addresse']='Entrez votre adresse !!';}
                }else{$error['mdp']="Votre mot de passe doit contenir au moins 8 caract??res";}
            }else{$errors['mdp']='Entrez votre mot de passe';}
        }else{$errors['nom']='Entre votre nom !';}
                                        
    }
}

// S??lection et affichage du template PHTML.
$template = 'contactProfessionnel';
include 'layout.phtml';
?>