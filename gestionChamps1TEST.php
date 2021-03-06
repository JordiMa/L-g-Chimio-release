<script type="text/javascript" src="js/jquery.min.js"></script>
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
$menu=11;
include_once 'presentation/gauche.php';
require 'script/connectionb.php';
$sql="SELECT chi_statut,chi_id_chimiste,chi_id_equipe FROM chimiste WHERE chi_nom='".$_SESSION['nom']."'";
//les résultats sont retournées dans la variable $result
$result =$dbh->query($sql);
$row =$result->fetch(PDO::FETCH_NUM);
if ($row[0]=='{ADMINISTRATEUR}') {

  $sql="SELECT * FROM \"champsAnnexe\"";
  //les résultats sont retournées dans la variable $result
  $result = $dbh->query($sql);
  if ($result){
    echo '<form id="form1" name="form1" action="" method="GET">';
    foreach ($result as $key => $value) {
      echo $value[1];
    }
    echo '<input type="submit" name="submit">';
    echo '<form>';
    echo "<br/>";
    echo "<br/>";
  }
  $result->execute();
  $r = $result->fetchAll();

  function customSearch($keyword, $arrayToSearch){
    foreach($arrayToSearch as $key => $arrayItem){
      if(stristr( $arrayItem, $keyword)){
        return $key;
      }
    }
  }

  foreach ($_GET as $key => $value) {
    if (strstr($key, "champsAnnexe_")){
      $keyid = customSearch($key, array_column($r, 'HTML'));
      echo $key . " : " . $value . " :: " . $r[$keyid][0];
      echo "<br/>";
    }
  }

};
include_once 'presentation/pied.php';
?>
