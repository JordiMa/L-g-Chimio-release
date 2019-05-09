<?php
/*
Copyright Laurent ROBIN CNRS - Universit� d'Orl�ans 2011 
Distributeur : UGCN - http://chimiotheque-nationale.org

Laurent.robin@univ-orleans.fr
Institut de Chimie Organique et Analytique
Universit� d�Orl�ans
Rue de Chartre � BP6759
45067 Orl�ans Cedex 2

Ce logiciel est un programme informatique servant � la gestion d'une chimioth�que de produits de synth�ses. 

Ce logiciel est r�gi par la licence CeCILL soumise au droit fran�ais et respectant les principes de diffusion des logiciels libres.
Vous pouvez utiliser, modifier et/ou redistribuer ce programme sous les conditions de la licence CeCILL telle que diffus�e par le CEA,
 le CNRS et l'INRIA sur le site "http://www.cecill.info".

En contrepartie de l'accessibilit� au code source et des droits de copie, de modification et de redistribution accord�s par cette licence,
 il n'est offert aux utilisateurs qu'une garantie limit�e. Pour les m�mes raisons, seule une responsabilit� restreinte p�se sur l'auteur du
 programme, le titulaire des droits patrimoniaux et les conc�dants successifs.

A cet �gard l'attention de l'utilisateur est attir�e sur les risques associ�s au chargement, � l'utilisation, � la modification et/ou au d�veloppement
 et � la reproduction du logiciel par l'utilisateur �tant donn� sa sp�cificit� de logiciel libre, qui peut le rendre complexe � manipuler et qui le
r�serve donc � des d�veloppeurs et des professionnels avertis poss�dant des connaissances informatiques approfondies. Les utilisateurs sont donc 
invit�s � charger et tester l'ad�quation du logiciel � leurs besoins dans des conditions permettant d'assurer la s�curit� de leurs syst�mes et ou de
 leurs donn�es et, plus g�n�ralement, � l'utiliser et l'exploiter dans les m�mes conditions de s�curit�. 

Le fait que vous puissiez acc�der � cet en-t�te signifie que vous avez pris connaissance de la licence CeCILL, et que vous en avez accept� les
termes.
*/
include_once 'script/administrateur.php';
include_once 'script/secure.php';
include_once 'autoload.php';
include_once 'langues/'.$_SESSION['langue'].'/presentation.php';
include_once 'presentation/entete.php';
$menu=6;
include_once 'presentation/gauche.php';
//appel le fichier de connexion � la base de donn�es
require 'script/connectionb.php';
include 'numero.php';
$sql="SELECT chi_statut,chi_id_chimiste,chi_id_equipe,chi_prenom FROM chimiste WHERE chi_nom='".$_SESSION['nom']."'";
//les r�sultats sont retourn�es dans la variable $result
$result=$dbh->query($sql);
$row =$result->fetch(PDO::FETCH_NUM);
if ($row[0]=='{ADMINISTRATEUR}') {
	
	//echo "!!".$_POST["numero"]."!!".$_POST["L"]."!!".$_POST["H"]."!!".$_POST["id"]."!!".$_POST['sauvegarde']."!!".$_POST['supprimer'];
	
	if (!empty($_POST["numero"]) and !empty($_POST["L"]) and !empty($_POST["H"]) and !empty($_POST["id"]) and isset($_POST['sauvegarde']) and $_POST['sauvegarde']=="Sauvegarde") {
		
		//transforme la variable numerique $_POST["L"] en une variable comprise entre a et h
		$x="a";
		for($i=2;$i<10;$i++) {
			if ($i==$_POST["L"]) $positionl=$x;
			$x++;
		}
				
		if (isset($_POST["up"]) and $_POST["up"]==1) $sql="UPDATE position SET pos_mass_prod='".$_POST["massplaque"]."',pos_id_produit='".$_POST["numero"]."'  WHERE pos_id_plaque='".$_POST["id"]."' and pos_coordonnees='".$positionl.$_POST["H"]."'";
		else {
			if ($_POST['massety']==2) $sql="INSERT INTO position (pos_id_plaque,pos_id_produit,pos_coordonnees,pos_mass_prod) VALUES ('".$_POST["id"]."','".$_POST["numero"]."','".$positionl.$_POST["H"]."','".$_POST["massplaque"]."')";
			else $sql="INSERT INTO position (pos_id_plaque,pos_id_produit,pos_coordonnees) VALUES ('".$_POST["id"]."','".$_POST["numero"]."','".$positionl.$_POST["H"]."')";
		}
		$insert=$dbh->exec($sql);
	}
	elseif(!empty($_POST["numero"]) and !empty($_POST["L"]) and !empty($_POST["H"]) and !empty($_POST["id"]) and isset($_POST['supprimer']) and $_POST['supprimer']=="Supprimer"){
		//transforme la variable numerique $_POST["L"] en une variable comprise entre a et h
		$x="a";
		for($i=2;$i<10;$i++) {
			if ($i==$_POST["L"]) $positionl=$x;
			$x++;
		}
		$sql="DELETE FROM position WHERE pos_id_plaque='".$_POST["id"]."' and pos_id_produit='".$_POST["numero"]."' and pos_coordonnees='".$positionl.$_POST["H"]."'";
		//echo $sql;
		$sup=$dbh->exec($sql);
	}
}
else require 'deconnexion.php';
unset($dbh);
include_once 'corps/modif_plaque_faite.php';
include_once 'presentation/pied.php';
?>