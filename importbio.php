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
$menu=7;
include_once 'presentation/gauche.php';

if (isset($_POST['nomcible']) and !empty($_POST['nomcible']) and isset($_POST['conccible']) and !empty($_POST['conccible']) and isset($_POST['protocible']) and !empty($_POST['protocible'])  and isset($_POST['labocible']) and !empty($_POST['labocible']) and isset($_POST['uniprot']) and !empty($_POST['uniprot'])) {
	require 'script/connectionb.php';
	$_POST['conccible']=str_replace(",",".",$_POST['conccible']);
	$sql="SELECT * FROM cible WHERE cib_nom='".$_POST['nomcible']."' or cib_uniprot='".$_POST['uniprot']."'";
	$result=$dbh->query($sql);
	$num=$result->rowCount();
	if ($num>0) $erreur='ERREURCIBLE';
	else {
		require 'script/connectionb.php';
		$sql="INSERT INTO cible (cib_nom,cib_uniprot) VALUES ('".$_POST['nomcible']."','".$_POST['uniprot']."')";
		$insert1=$dbh->exec($sql);
		$_POST['cible'] =$dbh->lastInsertId('cible_cib_id_cible_seq');
		$sql="INSERT INTO labocible (lab_concentration,lab_protocol,lab_laboratoire,lab_id_cible) VALUES('".$_POST['conccible']."','".$_POST['protocible']."','".$_POST['labocible']."','".$_POST['cible']."')";
		$insert2=$dbh->exec($sql);
		$_POST['labo'] = $dbh->lastInsertId('labocible_lab_id_labocible_seq');
	}
}
 elseif (!empty($_POST['cible']) and isset($_POST['conccible']) and !empty($_POST['conccible']) and isset($_POST['protocible']) and !empty($_POST['protocible'])  and isset($_POST['labocible']) and !empty($_POST['labocible'])) {
	require 'script/connectionb.php';
	$_POST['conccible']=str_replace(",",".",$_POST['conccible']);
	$sql="INSERT INTO labocible (lab_concentration,lab_protocol,lab_laboratoire,lab_id_cible) VALUES('".$_POST['conccible']."','".$_POST['protocible']."','".$_POST['labocible']."','".$_POST['cible']."')";
	$insert2=$dbh->exec($sql);
	$_POST['labo'] = $dbh->lastInsertId('labocible_lab_id_labocible_seq');
 } 
unset ($dbh);
include_once 'importresbio.php';
include_once 'presentation/pied.php';
?>