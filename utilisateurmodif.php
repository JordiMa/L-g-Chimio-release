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
include_once 'protection.php';
include_once 'langues/'.$_SESSION['langue'].'/presentation.php';
include_once 'presentation/entete.php';
$menu=10;
include_once 'presentation/gauche.php';
if (isset($_GET['idutill']) and $_GET['idutill']>0 and $_GET['ok']==1) {
		require 'script/connectionb.php';
		$sql="DELETE FROM chimiste WHERE chi_id_chimiste='".$_GET['idutill']."'";
		$dele=$dbh->exec($sql);
		unset($dbh);
		include_once 'modifutilisateur.php';
}
elseif (!empty($_POST["idutil"]) and $_POST["param"]=="false") {
	require 'script/connectionb.php';
	if (!empty($_POST["nomequi"]) or !empty($_POST["iniequi"])) {
		$sql="INSERT INTO equipe (equi_nom_equipe,equi_initiale_numero) VALUES ('".$_POST['nomequi']."','".$_POST['iniequi']."')";
		$insert=$dbh->exec($sql);
		$idequi=$dbh->lastInsertId();
	}
	if (!empty($_POST["equipe"])) $idequi=$_POST["equipe"];
	else $idequi="";
	if (!isset($_POST["responsable"])) $_POST["responsable"]="";
	
	if (empty($_POST["responsable"])) $_POST["responsable"]=0;
	if (empty($idequi)) $idequi=0;
	$sql="UPDATE chimiste SET chi_nom='".preg_replace("/\'/", "''",$_POST["nom"])."', chi_prenom='".preg_replace("/\'/", "''",$_POST["prenom"])."', chi_email='".$_POST["email"]."', chi_statut='{".$_POST["statut"]."}', chi_langue='".$_POST["langue"]."', chi_id_responsable='".$_POST["responsable"]."', chi_id_equipe='".$idequi."' WHERE chi_id_chimiste='".$_POST["idutil"]."'";
	$update=$dbh->exec($sql);
	
	//enl�ve l'ID du responsable aupres des chimistes/responsable
	if (($_POST['exstatu']=="RESPONSABLE" and ($_POST["statut"]=="CHEF" or $_POST["statut"]=="CHIMISTE")) or ($_POST['exstatu']=="CHEF" and ($_POST["statut"]=="RESPONSABLE" or $_POST["statut"]=="CHIMISTE"))) {
		$sql="UPDATE chimiste SET chi_id_responsable='0' WHERE chi_id_responsable='".$_POST["idutil"]."'";
		$updateres=$dbh->exec($sql);			
	}
	
	if ($_POST["statut"]=="CHEF") {
		$sql="UPDATE chimiste SET chi_id_responsable='' WHERE chi_id_responsable='".$_POST["idutil"]."'";
		$updat=$dbh->exec($sql);

		if (!empty($_POST['srespo'])) {
			$nb=count($_POST['srespo']);
			$req="";
			$i=1;
			foreach ($_POST['srespo'] as $elem) {
				$req.="chi_id_chimiste='".$elem."'";
				if ($i<$nb) $req.=" or ";
				$i++;
			}
			$sql="UPDATE chimiste SET chi_id_responsable='".$_POST["idutil"]."' WHERE ($req)";
			$updat1=$dbh->exec($sql);
		}
	}
	if ($_POST['exstatu']=="CHEF" and $_POST["statut"]!="CHEF") {
		$sql="UPDATE chimiste set chi_id_responsable='' WHERE chi_id_responsable='".$_POST["idutil"]."'";
		$updat=$dbh->exec($sql);
	}
	unset($dbh);
	include_once 'corps/modifutilisateur.php';
}
elseif ((isset($_GET["idutil"]) and !empty($_GET["idutil"]) and $_GET["param"]==true) or (isset($_POST["idutil"]) and !empty($_POST["idutil"]) and $_POST["param"]==true)) include_once 'corps/modifutil.php';
else include_once 'corps/modifutilisateur.php';
include_once 'presentation/pied.php';
?>