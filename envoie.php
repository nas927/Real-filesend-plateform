<?php
/* Erreur du $_FILES
0 = Fichier uploadé.
1 = Le(s) fichier uploadé(s) dépasse la taille maximum dans php.ini.
2 = Le(s) fichier uploadé(s) dépasse la taille maximum spécifié dans dans le formulaire HTML.
3 = Le(s) fichier est/sont uploadé(s) partiellement.
4 = Pas de fichier uploadé.
5 = ?
6 = Manque un dossier temporaire.
7 = Échec d'écriture du/des fichier(s) dans le disque.
8 = Une extension PHP a stoppé l'upload du fichier.
*/

$error = array("Fichier uploadé avec succès.",
				"Le(s) fichier uploadé(s) dépasse la taille maximum dans php.ini.",
				"Le(s) fichier uploadé(s) dépasse la taille maximum spécifié dans dans le formulaire HTML.",
				"Le(s) fichier est/sont uploadé(s) partiellement.",
				"Pas de fichier uploadé.",
				"Une erreur est survenu.",
				"Il manque un dossier temporaire.",
				"Échec d'écriture du/des fichier(s) dans le disque.",
				"Une extension PHP a stoppé l'upload du fichier.");

//On vérifie que la variable $_FILES qui porte nos fichier n'est pas vide.
if(!empty($_FILES)){
	
	//On s'en servira plus tard comme vérification de taille du fichier.
	$taillemax = 4000000;
	$extention = array("jpeg","jpg","png","gif");
	$image = $_FILES["photo"];
	$verifstr = strtolower(substr(strrchr($image["name"], "."), 1));

		if($image["size"] <= $taillemax)
		{
			if(in_array($verifstr, $extention))
			{
				$dest = "image/".mt_rand(0,500000)."-".$image["name"];
				move_uploaded_file($image["tmp_name"],$dest);
				echo "<font color='green'>Le fichier a bien été uploadé</font><br/><br/>";
			}
			else 
			{
				echo "<font color='red'>Le fichier que vous avez posté n'est pas dans le format jpeg,jpg,png ou gif</font><br/><br/>";
			}
		}
		else
		{
			echo "<font color='red'>Il y a une erreur sur le fichier que vous avez posté cette erreur est : <strong>".$error[2]." (4Mo)</strong></font><br/><br/>";
		}
}

//Ici c'est juste pour envoyer le formulaire multiple sans js.
 
/*
	$image = $_FILES["photo"];
	$img = organise($image);
	$taillemax = 4000000;
	$extention = array("jpeg","jpg","png","gif");
	for($x = 0 ; $x < count($img) ; $x++)
	{
		if(isset($img) && $img[$x]["error"] != 4)
		{
			if($img[$x]["size"] <= $taillemax)
			{
				$verifstr = strtolower(substr(strrchr($img[$x]["name"], "."), 1));
				if(in_array($verifstr, $extention))
				{
					$dest = "image/".mt_rand(0,500000)."-".$img[$x]["name"];
					move_uploaded_file($img[$x]["tmp_name"],$dest);
					echo "<font color='green'>Le fichier n°$x a bien été uploadé</font><br>";
				}
				else
				{
					echo "<font color='red'>Le fichier n°$x que vous avez posté n'est pas dans le format jpeg,jpg,png ou gif</font><br/>";
				}
			}
			else
			{
				echo "<font color='red'> Il y a une erreur sur le fichier n°$x que vous avez posté cette erreur est : <strong>".$error[2]." (4Mo)</strong></font><br/>";
			}		
		}
		else
		{
			echo "<font color='red'> Il y a une erreur sur le fichier n°$x que vous avez posté cette erreur est : <strong>".$error[4]."</strong></font><br/>";
		}
	}


function organise($file_post)
{
	$fichier_array = array();
	$fichier_count = count($file_post["name"]);
	$fichier_keys = array_keys($file_post);
	
	for($i = 0 ; $i < $fichier_count ; $i++)
	{	
		foreach($fichier_keys as $key)
			$fichier_array[$i][$key] = $file_post[$key][$i];
	}
	return $fichier_array;
}

function pre($tableau)
{
	echo "<pre>";
	print_r($tableau);
	echo "</pre>";
}
*/
?>