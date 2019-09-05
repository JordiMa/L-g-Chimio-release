<script src="./js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="./presentation/DataTables/datatables.min.css"/>
<script type="text/javascript" src="./presentation/DataTables/datatables.js"></script>
<link rel="stylesheet" type="text/css" href="./presentation/DataTables/RowReorder-1.2.4/css/rowReorder.dataTables.css"/>
<script type="text/javascript" src="./presentation/DataTables/RowReorder-1.2.4/js/dataTables.rowReorder.js"></script>
<link rel="stylesheet" type="text/css" href="./presentation/DataTables/Select-1.3.0/css/select.dataTables.css"/>
<script type="text/javascript" src="./presentation/DataTables/Select-1.3.0/js/dataTables.select.js"></script>
<style>

table.table-tableau {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

table.table-tableau td, th {
  border: 1px solid #ddd;
  padding: 8px;
}

table.table-tableau tr:nth-child(even) {
  background-color: #f2f2f2;
}

table.table-tableau tr:hover {
  background-color: #ddd;
}

table.table-tableau th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}

div.extraits{
  width: 100%;
  display: inline-block;
  margin: 5px;
  vertical-align: top;
  padding: 5px;
  border-color: #3399CC;
  border-top-style: solid;
  border-right-style: dashed;
  border-bottom-style: dashed;
  border-left-style: solid;
  text-align: justify;
}

div.container{
  display: flex;
  flex-direction: row;
  justify-content: normal;
  flex-wrap: wrap;
}

.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.7);
  transition: opacity 250ms;
  visibility: hidden;
  opacity: 0;
}

.overlay:target {
  visibility: visible;
  opacity: 1;
  z-index: 1;
}

.popup {
  margin: 70px auto;
  padding: 20px;
  background: #fff;
  border-radius: 5px;
  width: 30%;
  position: relative;
  transition: all 5s ease-in-out;
  top: 25%;
}

.popup h2 {
  margin-top: 0;
  color: #333;
  font-family: Tahoma, Arial, sans-serif;
}
.popup .close {
  position: absolute;
  top: 20px;
  right: 30px;
  transition: all 200ms;
  font-size: 30px;
  font-weight: bold;
  text-decoration: none;
  color: #333;
}
.popup .close:hover {
  color: darkblue;
}
.popup .content {
  max-height: 30%;
  overflow: auto;
}

@media screen and (max-width: 700px){
  .box{
    width: 70%;
  }
  .popup{
    width: 70%;
  }
}

.infos {
  width: 48%;
  text-align: center;
  margin: 1%;
  vertical-align: top;
}

a.btnFic {
  font-size: small;
  background-color: silver;
  color: black;
  border: 2px solid green;
  padding: 5px 10px;
  text-align: center;
  text-decoration: none;
}

a.btnFic:hover {
  background-color: green;
  color: white;
}

</style>

<?php
/*
Copyright Laurent ROBIN CNRS - Université d'Orléans 2011
Distributeur : UGCN - http://chimiotheque-nationale.org

Laurent.robin@univ-orleans.fr
Institut de Chimie Organique et Analytique
Université d’Orléans
Rue de Chartre – BP6759
45067 Orléans Cedex 2

Ce logiciel est un programme informatique servant à la gestion d'une chimiothèque de produits de synthèses.

Ce logiciel est régi par la licence CeCILL soumise au droit français et respectant les principes de diffusion des logiciels libres.
Vous pouvez utiliser, modifier et/ou redistribuer ce programme sous les conditions de la licence CeCILL telle que diffusée par le CEA,
le CNRS et l'INRIA sur le site "http://www.cecill.info".

En contrepartie de l'accessibilité au code source et des droits de copie, de modification et de redistribution accordés par cette licence,
il n'est offert aux utilisateurs qu'une garantie limitée. Pour les mêmes raisons, seule une responsabilité restreinte pèse sur l'auteur du
programme, le titulaire des droits patrimoniaux et les concédants successifs.

A cet égard l'attention de l'utilisateur est attirée sur les risques associés au chargement, à l'utilisation, à la modification et/ou au développement
et à la reproduction du logiciel par l'utilisateur étant donné sa spécificité de logiciel libre, qui peut le rendre complexe à manipuler et qui le
réserve donc à des développeurs et des professionnels avertis possédant des connaissances informatiques approfondies. Les utilisateurs sont donc
invités à charger et tester l'adéquation du logiciel à leurs besoins dans des conditions permettant d'assurer la sécurité de leurs systèmes et ou de
leurs données et, plus généralement, à l'utiliser et l'exploiter dans les mêmes conditions de sécurité.

Le fait que vous puissiez accéder à cet en-tête signifie que vous avez pris connaissance de la licence CeCILL, et que vous en avez accepté les
termes.
*/
include_once 'script/secure.php';
//include_once 'protection.php';

//appel le fichier de connexion à la base de données
require 'script/connectionb.php';

  print"<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
    <tr>
    <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet1.gif\"><a class=\"onglet\" href=\"recherche_Extrait.php\">Extrait</a></td>
    <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet.gif\"><a class=\"onglet\" href=\"recherche_Echantillon.php\">Échantillon</a></td>
    <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet.gif\"><a class=\"onglet\" href=\"recherche_Condition.php\">Condition</a></td>
    <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet.gif\"><a class=\"onglet\" href=\"recherche_Specimen.php\">Specimen</a></td>
    <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet.gif\"><a class=\"onglet\" href=\"recherche_Taxonomie.php\">Taxonomie</a></td>
    <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet.gif\"><a class=\"onglet\" href=\"recherche_Expedition.php\">Mission de récolte</a></td>
    <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet.gif\"><a class=\"onglet\" href=\"recherche_autorisation.php\">Autorisation</a></td>
    </tr>
    </table><br/>";

  ?>
  <h3 align="center">Recherche d'extraits</h3>
  <hr>

  <form id="myForm" action="" method="get" style=" text-align: center;">
    <!-- [JM - 07/2019] Recherche des extraits -->
    <table id="tab_echantillon" class="display">
      <thead>
      <tr>
        <th></th>
        <th>Code</th>
        <th>Solvant</th>
        <th>Type extraction</th>
        <th>Etat</th>
        <th>Disponibilité</th>
        <th>Chimiste</th>
        <th>Echantillon</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // [JM - 05/07/2019] selectionne les extraits selon le type de compte
      if ($row[0]=='{CHIMISTE}') {
        $req_recherche = "
        SELECT ext_code_extraits, sol_solvant, ext_type_extraction, ext_etat, ext_disponibilite, chi_nom, chi_prenom, ech_code_echantillon FROM extraits
        INNER JOIN Solvant on extraits.ext_solvant = Solvant.sol_id_solvant
        INNER JOIN chimiste on extraits.chi_id_chimiste = chimiste.chi_id_chimiste
        WHERE extraits.chi_id_chimiste = ".$row[1]."
        ";
      }
      elseif ($row[0]=='{RESPONSABLE}') {
        $req_recherche = "
        SELECT ext_code_extraits, sol_solvant, ext_type_extraction, ext_etat, ext_disponibilite, chi_nom, chi_prenom, ech_code_echantillon FROM extraits
        INNER JOIN Solvant on extraits.ext_solvant = Solvant.sol_id_solvant
        INNER JOIN chimiste on extraits.chi_id_chimiste = chimiste.chi_id_chimiste
        WHERE (chimiste.chi_id_responsable = ".$row[1]." or extraits.chi_id_chimiste = ".$row[1].")
        ";
      }
      elseif ($row[0]=='{CHEF}') {
        $req_recherche = "
        SELECT ext_code_extraits, sol_solvant, ext_type_extraction, ext_etat, ext_disponibilite, chim.chi_nom, chim.chi_prenom, ech_code_echantillon FROM extraits
        INNER JOIN Solvant on extraits.ext_solvant = Solvant.sol_id_solvant
        INNER JOIN chimiste chim on extraits.chi_id_chimiste = chim.chi_id_chimiste
        INNER JOIN chimiste resp ON chim.chi_id_responsable = resp.chi_id_chimiste
        WHERE resp.chi_id_responsable = ".$row[1]."
        and chim.chi_id_chimiste in (SELECT chi_id_chimiste FROM extraits)
        ";
      }
      elseif ($row[0]=='{ADMINISTRATEUR}') {
        $req_recherche = "
        SELECT ext_code_extraits, sol_solvant, ext_type_extraction, ext_etat, ext_disponibilite, chi_nom, chi_prenom, ech_code_echantillon FROM extraits
        INNER JOIN Solvant on extraits.ext_solvant = Solvant.sol_id_solvant
        INNER JOIN chimiste on extraits.chi_id_chimiste = chimiste.chi_id_chimiste
        ";
      }

      foreach ($dbh->query($req_recherche) as $row) {
        echo '
        <tr>
        <td><input class="echantillon_nouveau specimen_nouveau expedition_existant" type="radio" name="chimiste" value="'.urldecode($row[0]).'"';if (isset($_GET['chimiste']) && $row[0] == $_GET['chimiste']) echo "checked"; ;echo '></td>
        <td>'.urldecode($row[0]).'</td>
        <td>'.urldecode(constant($row[1])).'</td>
        <td>'.urldecode($row[2]).'</td>
        <td>'.urldecode($row[3]).'</td>
        <td>';if ($row[4]) {echo "Oui";} else {echo "Non";} echo '</td>
        <td>'.urldecode($row[5]).' '.urldecode($row[6]).'</td>
        <td>'.urldecode($row[7]).'</td>
        </tr>
        ';
      }
      ?>
    </tbody>
    </table>
    <br/>
    <input type="submit" name="Rechercher" id="Rechercher" value="Rechercher">
    <br><br>
  </form>
  <hr>
  <?php

  if(isset($_GET['chimiste'])){
      echo "<div class='hr click_extraits'>Extraits</div>";

      echo "<div class='container'>";
      // [JM - 05/07/2019] cree une liste des extrait et de leur purification
      $req_extrait = "
      SELECT extraits.ext_Code_Extraits, sol_solvant, ext_type_extraction, ext_etat, ext_disponibilite, ext_protocole, ext_stockage, ext_observations, ech_code_echantillon, count(pur_id), typ_type FROM extraits
      INNER JOIN Solvant on extraits.ext_solvant = Solvant.sol_id_solvant
      INNER JOIN type on extraits.typ_id_type = type.typ_id_type
      LEFT JOIN purification on extraits.ext_Code_Extraits = purification.ext_Code_Extraits
      WHERE extraits.ext_Code_Extraits = '".$_GET['chimiste']."'
      GROUP BY extraits.ext_Code_Extraits, sol_solvant, ext_type_extraction, ext_etat, ext_disponibilite, ext_protocole, ext_stockage, ext_observations, ech_code_echantillon, typ_type";

      $query_extrait = $dbh->query($req_extrait);
      $resultat_extrait = $query_extrait->fetchALL(PDO::FETCH_NUM);

      // [JM - 05/07/2019] selectionne les purifications
      $req_purif = "SELECT purification.pur_id, pur_purification, pur_ref_book, count(fic_id), ext_Code_Extraits FROM purification LEFT OUTER JOIN fichier_purification ON fichier_purification.pur_id = purification.pur_id GROUP BY purification.pur_id";
      $query_purif = $dbh->query($req_purif);
      $resultat_purif = $query_purif->fetchALL(PDO::FETCH_NUM);
      // [JM - 05/07/2019] affichage des resultat
      foreach ($resultat_extrait as $key => $value) {
        echo "<div class='extraits'>";
        echo "<strong>ID extrait : </strong>" .$value[0];
        echo "<br/><strong>Code Echantillon : </strong>" .$value[8]. ' - <a href="recherche_Echantillon.php?echantillon='.$value[8].'" style="color: red; font-size: small;">voir l\'échantillon</a>';
        echo "<br/><strong>Solvant : </strong>" .constant($value[1]);
        echo "<br/><strong>Type d'extraction : </strong>" .$value[2];
        echo "<br/><strong>Etat : </strong>" .$value[3];
        echo "<br/><strong>Disponibilité : </strong>"; if ($value[4] == 1) echo "Oui"; else echo "Non";
        echo "<br/><strong>Protocole : </strong>" .$value[5];
        echo "<br/><strong>Lieu de stockage : </strong>" .$value[6];
        echo "<br/><strong>observations : </strong>" .$value[7];
        echo "<br/><br/><strong>Licence : </strong>" .constant($value[10]);
        
        // [JM - 05/07/2019] si des purifications existe
        if ($value[9] != 0) {
          echo "<div class='hr'>Purifications</div>";
          echo "
          <div style='max-height: 250px;overflow: auto; width: 100%;'>
          <table class=\"table-tableau\">
          <tr>
          <th>ID</th>
          <th>Purification</th>
          <th>Ref cahier de labo</th>
          <th>Fichiers</th>
          </tr>
          ";
          // [JM - 05/07/2019] affiche les purifications
          foreach ($resultat_purif as $key1 => $value1) {
            if($value1[4] == $value[0]){
              echo "
              <tr>
              <td>".$value1[0]."</td>
              <td>".$value1[1]."</td>
              <td>".$value1[2]."</td>
              <td><a href=\"#fic_pur_".$value1[0]."\">".$value1[3]." Fichier(s)</a></td>
              </tr>
              ";
            }
          }
          echo "</table>";
          echo "</div>";
        }
        echo "</div>";
      }
      echo "</div>";

      echo "<hr>";
      echo "<br/>";

      // [JM - 05/07/2019] Creation de popup pour afficher la liste des fichiers

      //Purification
      $req_fic_purif = "SELECT * FROM fichier_purification";
      $query_fic_purif = $dbh->query($req_fic_purif);
      $resultat_fic_purif = $query_fic_purif->fetchALL(PDO::FETCH_NUM);

      foreach ($resultat_purif as $key => $value) {
        echo '
        <div id="fic_pur_'.$value[0].'" class="overlay">
        <div class="popup">
        <h2>Fichiers purification '.$value[0].'</h2>
        <a class="close" href="#return">&times;</a>
        <div class="content">
        ';
        $liste_fic_purif = "";
        foreach ($resultat_fic_purif as $key => $value1) {
          if ($value[0] == $value1[3]) {
            $liste_fic_purif .='<li><a href="telecharge.php?id='.$value1[0].'&rankExtra=purification" target="_blank"> Fichier '.$value1[0].' : '.$value1[2].'</a></li>';
          }
        }
        if ($liste_fic_purif != "") {
          echo $liste_fic_purif;
        }
        else {
          echo "Aucun fichier";
        }
        echo '</div>
        </div>
        </div>
        ';
      }

    }

unset($dbh);
?>

<script>
$(document).ready(function() {
    $('#tab_echantillon').DataTable({select: {style: 'single'}});

    $('#tab_echantillon tr').click(function() {
      $(this).find('td input:radio').prop('checked', true);
    });
});
</script>
