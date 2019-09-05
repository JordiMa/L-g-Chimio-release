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
  font-size: small;
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}

div.extraits{
  width: 32%;
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
  word-break: break-all;
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

#popup_modif.popup {
  margin: 30px auto;
  padding: 20px;
  background: #fff;
  border-radius: 5px;
  width: 30%;
  position: relative;
  transition: all 5s ease-in-out;
  top: 0%;
}

#popup_select.popup {
  margin: 30px auto;
  padding: 20px;
  background: #fff;
  border-radius: 5px;
  width: 95%;
  position: relative;
  transition: all 5s ease-in-out;
  top: 0%;
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

#popup_modif.popup .content {
  max-height: 80%;
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
  <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet.gif\"><a class=\"onglet\" href=\"modification_Extrait.php\">Extraits</a></td>
  <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet1.gif\"><a class=\"onglet\" href=\"modification_Echantillon.php\">Échantillon</a></td>
  ";
  if ($row[0]=='{ADMINISTRATEUR}') {
  print"
  <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet.gif\"><a class=\"onglet\" href=\"modification_Condition.php\">Condition</a></td>
  <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet.gif\"><a class=\"onglet\" href=\"modification_Specimen.php\">Specimen</a></td>
  <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet.gif\"><a class=\"onglet\" href=\"modification_Taxonomie.php\">Taxonomie</a></td>
  <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet.gif\"><a class=\"onglet\" href=\"modification_Expedition.php\">Mission de récolte</a></td>
  <td width=\"82\" height=\"23\" align=\"center\" valign=\"middle\" background=\"images/onglet.gif\"><a class=\"onglet\" href=\"modification_autorisation.php\">Autorisation</a></td>
  ";
  }
  print"
  </tr>
  </table><br/>";

if (isset($_GET['echantillon'])) {
  $_POST['echantillon'] = $_GET['echantillon'];
}
// [JM - 05/07/2019] gestion des modification
  if(isset($_POST["type"])){
    switch ($_POST["type"]) {
      case 'Extraits':
        $stmt = $dbh->prepare("UPDATE extraits SET ext_solvant = :ext_solvant, ext_type_extraction = :ext_type_extraction, ext_etat = :ext_etat, ext_disponibilite = :ext_disponibilite, ext_protocole = :ext_protocole, ext_stockage = :ext_stockage, ext_observations = :ext_observations, typ_id_type = :typ_id_type WHERE ext_Code_Extraits = :ext_Code_Extraits");
        $stmt->bindParam(':ext_solvant', $_POST['Solvant']);
        $stmt->bindParam(':ext_type_extraction', $_POST['TypeExtra']);
        $stmt->bindParam(':ext_etat', $_POST['Etat']);

        if (isset($_POST['Disponibilite'])) $_POST['Disponibilite'] = "TRUE"; else $_POST['Disponibilite'] = "FALSE";
        $stmt->bindParam(':ext_disponibilite', $_POST['Disponibilite']);

        $stmt->bindParam(':ext_protocole', $_POST['Protocole']);
        $stmt->bindParam(':ext_stockage', $_POST['Lieu']);
        $stmt->bindParam(':ext_observations', $_POST['Observations']);
        $stmt->bindParam(':typ_id_type', $_POST['Extrait_typ_id_type']);

        $stmt->bindParam(':ext_Code_Extraits', $_POST['id']);

        $stmt->execute();
        break;

      case 'fic_pur_suppr':
        $stmt = $dbh->prepare("DELETE FROM fichier_purification WHERE fic_id = :fic_id");
        $stmt->bindParam(':fic_id', $_POST['id']);
        $stmt->execute();
        break;

      case 'Purification':
        $stmt = $dbh->prepare("UPDATE purification SET pur_purification = :pur_purification, pur_ref_book = :pur_ref_book WHERE pur_id = :pur_id");
        $stmt->bindParam(':pur_purification', $_POST['purification']);
        $stmt->bindParam(':pur_ref_book', $_POST['ref_book']);
        $stmt->bindParam(':pur_id', $_POST['id']);
        $stmt->execute();

        if(isset($_FILES['fichier'])){
          foreach ($_FILES['fichier']['name'] as $key => $value) {
            if ($_FILES['fichier']['size'][$key] != 0) {
              $extension_fichier=strtolower(pathinfo($_FILES['fichier']['name'][$key], PATHINFO_EXTENSION));
              $fichier=file_get_contents($_FILES['fichier']['tmp_name'][$key]);
              $fichier=Base64_encode($fichier);

              $stmt = $dbh->prepare("INSERT INTO fichier_purification (fic_fichier, fic_type, pur_id) VALUES (:fic_fichier, :fic_type, :pur_id)");
              $stmt->bindParam(':fic_fichier', $fichier);
              $stmt->bindParam(':fic_type', $extension_fichier);
              $stmt->bindParam(':pur_id', $_POST['id']);
              $stmt->execute();
            }
          }
        }

        break;

      case 'Purification_add':
        $stmt = $dbh->prepare("INSERT INTO purification (pur_purification, pur_ref_book, ext_Code_Extraits) VALUES (:pur_purification, :pur_ref_book, :ext_Code_Extraits)");
        $stmt->bindParam(':pur_purification', $_POST['purification']);
        $stmt->bindParam(':pur_ref_book', $_POST['ref_book']);
        $stmt->bindParam(':ext_Code_Extraits', $_POST['id']);
        $stmt->execute();
        $pur_id = $dbh->lastInsertId();

        if(isset($_FILES['fichier'])){
          foreach ($_FILES['fichier']['name'] as $key => $value) {
            if ($_FILES['fichier']['size'][$key] != 0) {
              $extension_fichier=strtolower(pathinfo($_FILES['fichier']['name'][$key], PATHINFO_EXTENSION));
              $fichier=file_get_contents($_FILES['fichier']['tmp_name'][$key]);
              $fichier=Base64_encode($fichier);

              $stmt = $dbh->prepare("INSERT INTO fichier_purification (fic_fichier, fic_type, pur_id) VALUES (:fic_fichier, :fic_type, :pur_id)");
              $stmt->bindParam(':fic_fichier', $fichier);
              $stmt->bindParam(':fic_type', $extension_fichier);
              $stmt->bindParam(':pur_id', $pur_id);
              $stmt->execute();
            }
          }
        }

        break;

      case 'Echantillon':
        $stmt = $dbh->prepare("UPDATE echantillon SET ech_contact = :ech_contact, ech_publication_doi = :ech_publication_doi, ech_stock_disponibilite = :ech_stock_disponibilite, ech_stock_quantite = :ech_stock_quantite, ech_lieu_stockage = :ech_lieu_stockage WHERE ech_code_echantillon = :ech_code_echantillon");
        $stmt->bindParam(':ech_contact', $_POST['contact']);
        $stmt->bindParam(':ech_publication_doi', $_POST['DOI']);

        if (isset($_POST['Disponibilite'])) $_POST['Disponibilite'] = "TRUE"; else $_POST['Disponibilite'] = "FALSE";
        $stmt->bindParam(':ech_stock_disponibilite', $_POST['stock']);

        $stmt->bindParam(':ech_stock_quantite', $_POST['quantite']);
        $stmt->bindParam(':ech_lieu_stockage', $_POST['lieu']);

        $stmt->bindParam(':ech_code_echantillon', $_POST['id']);

        $stmt->execute();
        break;

      case 'condition':
        $stmt = $dbh->prepare("UPDATE echantillon SET con_id = :con_id WHERE ech_code_echantillon = :ech_code_echantillon");
        if ($_POST['id'] == "NULL")
          $_POST['id'] = NULL;
        $stmt->bindParam(':con_id', $_POST['id']);
        $stmt->bindParam(':ech_code_echantillon', $_POST['echantillon']);

        $stmt->execute();
        break;

      case 'specimen':
        $stmt = $dbh->prepare("UPDATE echantillon SET spe_code_specimen = :spe_code_specimen WHERE ech_code_echantillon = :ech_code_echantillon");
        $stmt->bindParam(':spe_code_specimen', $_POST['id']);
        $stmt->bindParam(':ech_code_echantillon', $_POST['echantillon']);

        $stmt->execute();
        break;

      default:
        // code...
        break;
    }
    echo '<script>window.location.replace("modification_Echantillon.php?echantillon='.$_POST['echantillon'].'");</script>';
  }
  ?>

  <h3 align="center">Modification d'échantillon</h3>
  <hr>

  <form id="myForm" action="" method="POST" style=" text-align: center;">
    <!-- [JM - 01/02/2019] Recherche du produit -->
    <table id="tab_echantillon" class="display">
      <thead>
      <tr>
        <th></th>
        <th>Code</th>
        <th>Contact</th>
        <th>DOI</th>
        <th>Disponibilité</th>
        <th>Quantité</th>
        <th>Lieu de stockage</th>
      </tr>
    </thead>
    <tbody>
      <?php

      // [JM 07/2019] selection selon le type de compte
      if ($row[0]=='{CHIMISTE}') {
        $sql_recherche = "
        SELECT * FROM echantillon
        INNER JOIN extraits on extraits.ech_code_echantillon = echantillon.ech_code_echantillon
        WHERE extraits.chi_id_chimiste = ".$row[1]."
        ORDER BY echantillon.ech_code_echantillon
        ";
      }
      elseif ($row[0]=='{RESPONSABLE}') {
        $sql_recherche = "
        SELECT echantillon.ech_code_echantillon, ech_contact, ech_publication_doi, ech_stock_disponibilite, ech_stock_quantite, ech_lieu_stockage, par_id, spe_code_specimen, con_id
        FROM echantillon
        INNER JOIN extraits on extraits.ech_code_echantillon = echantillon.ech_code_echantillon
        INNER JOIN chimiste on extraits.chi_id_chimiste = chimiste.chi_id_chimiste
        WHERE (chi_id_responsable = ".$row[1]."  or chimiste.chi_id_chimiste = ".$row[1].")
        GROUP BY echantillon.ech_code_echantillon
        ORDER BY echantillon.ech_code_echantillon;
        ";
      }
      elseif ($row[0]=='{CHEF}') {
        $sql_recherche = "
        SELECT echantillon.ech_code_echantillon, ech_contact, ech_publication_doi, ech_stock_disponibilite, ech_stock_quantite, ech_lieu_stockage, par_id, spe_code_specimen, con_id FROM echantillon
        INNER JOIN extraits on extraits.ech_code_echantillon = echantillon.ech_code_echantillon
        INNER JOIN chimiste as chim ON chim.chi_id_chimiste = extraits.chi_id_chimiste
        INNER JOIN chimiste as res ON res.chi_id_chimiste = chim.chi_id_responsable
        WHERE res.chi_id_responsable = ".$row[1]."
        GROUP BY echantillon.ech_code_echantillon
        ORDER BY echantillon.ech_code_echantillon;
        ";
      }
      elseif ($row[0]=='{ADMINISTRATEUR}') {
        $sql_recherche = "
        SELECT * FROM echantillon
        ORDER BY echantillon.ech_code_echantillon
        ";
      }

      // [JM 07/2019] affichage du tableau
      foreach ($dbh->query($sql_recherche) as $row_r) {
        echo '
        <tr>
        <td><input class="echantillon_nouveau specimen_nouveau expedition_existant" type="radio" name="echantillon" value="'.urldecode($row_r[0]).'"';if (isset($_POST['echantillon']) && $row_r[0] == $_POST['echantillon']) echo "checked"; ;echo '></td>
        <td>'.urldecode($row_r[0]).'</td>
        <td>'.urldecode($row_r[1]).'</td>
        <td>'.urldecode($row_r[2]).'</td>
        <td>';if ($row_r[3]) {echo "Oui";} else {echo "Non";} echo '</td>
        <td>'.urldecode($row_r[4]).' g</td>
        <td>'.urldecode($row_r[5]).'</td>
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

  // [JM 07/2019] Sélection des détaille de l'échantillon
  if(isset($_POST['echantillon'])){
    $sql_echantillon =
    "SELECT * FROM Echantillon
    INNER JOIN specimen on specimen.spe_code_specimen = echantillon.spe_code_specimen
    INNER JOIN expedition on expedition.exp_id = specimen.exp_id
    INNER JOIN pays on pays.pay_code_pays = expedition.pay_code_pays
    INNER JOIN taxonomie on taxonomie.tax_ID = specimen.tax_ID
    INNER JOIN type_taxonomie on type_taxonomie.typ_tax_id = taxonomie.typ_tax_id
    INNER JOIN partie_organisme on partie_organisme.par_id = echantillon.par_id
    LEFT OUTER JOIN condition on condition.con_id = echantillon.con_id
    WHERE Echantillon.ech_code_echantillon = '".$_POST['echantillon']."';
    ";

    $result_echantillon = $dbh->query($sql_echantillon);
    $row_echantillon = $result_echantillon->fetch(PDO::FETCH_NUM);
    // [JM - 05/07/2019] affichage des information liée à l'echantillon
    if (!empty($row_echantillon[0])) {
      echo "<div style=\"margin-left: 10px;\">";
      echo "<strong>Code echantillon : </strong>" .$row_echantillon[0];
      echo "<br/>";
      echo "<br/><strong>Contact : </strong>" .$row_echantillon[1];
      echo "<br/>";
      echo "<br/><strong>DOI : </strong>" .$row_echantillon[2];
      echo "<br/>";
      echo "<br/><strong>Stock : </strong>"; if ($row_echantillon[3] == 1) echo "Oui"; else echo "Non";
      echo "<br/><strong>Quantité : </strong>" .$row_echantillon[4] . ' g';
      echo "<br/><strong>Lieu de stockage : </strong>" .$row_echantillon[5];
      echo "<br/>";
      echo "<br/>";
      if ($row[0]=='{ADMINISTRATEUR}') {
        echo "<a class='btnFic' href=\"#modif_ech_".$row_echantillon[0]."\">Modifier</a>";
      }
      echo "<br/>";
      echo "<br/>";
      if ($row[0]=='{ADMINISTRATEUR}') {
        echo '
        <div id="modif_ech_'.$row_echantillon[0].'" class="overlay">
          <div id="popup_modif" class="popup">
            <h2>Code echantillon '.$row_echantillon[0].'</h2>
            <a class="close" href="#return">&times;</a>
            <div class="content">
              <form id="myForm" action="" method="POST">
                <input type="hidden" name="echantillon" value="'.$row_echantillon[0].'">
                <input type="hidden" name="type" value="Echantillon">
                <input type="hidden" name="id" value="'.$row_echantillon[0].'">
                <br/><strong>Contact : </strong><br/><input name="contact" type="text" value="'.$row_echantillon[1].'">
                <br/><br/><strong>DOI : </strong><br/><input name="DOI" type="text" value="'.$row_echantillon[2].'">
                <br/><br/><strong>Stock : </strong><br/><input name="stock" type="checkbox" '; if ($row_echantillon[3] == 1) echo "checked"; echo '>
                <br/><br/><strong>Quantité : </strong><br/><input name="quantite" type="number" min="0" step="any" value="'.$row_echantillon[4].'"> g
                <br/><br/><strong>Lieu de stockage : </strong><br/><textarea name="lieu" rows="5" cols="50">'.$row_echantillon[5].'</textarea>
                <br/><br/><input type="submit" style="float: right;">
              </form>
            </div>
          </div>
        </div>
        ';
      }
      echo "</div>";


      echo "<div class='hr click_extraits'>Extraits</div>";

      echo "<div class='container'>";
      // [JM - 05/07/2019] cree une liste des extrait et de leur purification

      if ($row[0]=='{CHIMISTE}') {
        $req_extrait = "
        SELECT ext_Code_Extraits, sol_solvant, ext_type_extraction, ext_etat, ext_disponibilite, ext_protocole, ext_stockage, ext_observations, chi_nom, chi_prenom, equi_nom_equipe FROM extraits
        INNER JOIN chimiste ON chimiste.chi_id_chimiste = extraits.chi_id_chimiste
        INNER JOIN Solvant on extraits.ext_solvant = Solvant.sol_id_solvant
        LEFT OUTER JOIN equipe ON equipe.equi_id_equipe = chimiste.chi_id_equipe
        WHERE ech_code_echantillon = '".$_POST['echantillon']."'
        AND extraits.chi_id_chimiste = ".$row[1]."
        ORDER BY ext_Code_Extraits";
      }
      elseif ($row[0]=='{RESPONSABLE}') {
        $req_extrait = "
        SELECT ext_Code_Extraits, sol_solvant, ext_type_extraction, ext_etat, ext_disponibilite, ext_protocole, ext_stockage, ext_observations, chi_nom, chi_prenom, equi_nom_equipe FROM extraits
        INNER JOIN chimiste ON chimiste.chi_id_chimiste = extraits.chi_id_chimiste
        INNER JOIN Solvant on extraits.ext_solvant = Solvant.sol_id_solvant
        LEFT OUTER JOIN equipe ON equipe.equi_id_equipe = chimiste.chi_id_equipe
        WHERE ech_code_echantillon = '".$_POST['echantillon']."'
        AND (chimiste.chi_id_responsable = ".$row[1]." or chimiste.chi_id_chimiste = ".$row[1].")
        ORDER BY ext_Code_Extraits";
      }
      elseif ($row[0]=='{CHEF}') {
        $req_extrait = "
        SELECT ext_Code_Extraits, sol_solvant, ext_type_extraction, ext_etat, ext_disponibilite, ext_protocole, ext_stockage, ext_observations, chim.chi_nom, chim.chi_prenom, equi_nom_equipe FROM extraits
        INNER JOIN chimiste as chim ON chim.chi_id_chimiste = extraits.chi_id_chimiste
        INNER JOIN chimiste as res ON res.chi_id_chimiste = chim.chi_id_responsable
        INNER JOIN Solvant on extraits.ext_solvant = Solvant.sol_id_solvant
        LEFT OUTER JOIN equipe ON equipe.equi_id_equipe = chim.chi_id_equipe
        WHERE ech_code_echantillon = '".$_POST['echantillon']."'
        AND res.chi_id_responsable = ".$row[1]."
        ORDER BY ext_Code_Extraits";
      }
      elseif ($row[0]=='{ADMINISTRATEUR}') {
        $req_extrait = "
        SELECT ext_Code_Extraits, sol_solvant, ext_type_extraction, ext_etat, ext_disponibilite, ext_protocole, ext_stockage, ext_observations, chi_nom, chi_prenom, equi_nom_equipe, typ_type FROM extraits
        INNER JOIN chimiste ON chimiste.chi_id_chimiste = extraits.chi_id_chimiste
        INNER JOIN Solvant on extraits.ext_solvant = Solvant.sol_id_solvant
        INNER JOIN type on extraits.typ_id_type = type.typ_id_type
        LEFT OUTER JOIN equipe ON equipe.equi_id_equipe = chimiste.chi_id_equipe
        WHERE ech_code_echantillon = '".$_POST['echantillon']."'
        ORDER BY ext_Code_Extraits";
      }

      $query_extrait = $dbh->query($req_extrait);
      $resultat_extrait = $query_extrait->fetchALL(PDO::FETCH_NUM);

      $req_purif = "SELECT purification.pur_id, pur_purification, pur_ref_book, count(fic_id), ext_Code_Extraits FROM purification LEFT OUTER JOIN fichier_purification ON fichier_purification.pur_id = purification.pur_id GROUP BY purification.pur_id ORDER BY pur_id";
      $query_purif = $dbh->query($req_purif);
      $resultat_purif = $query_purif->fetchALL(PDO::FETCH_NUM);
      // [JM - 05/07/2019] affichage des resultat
      foreach ($resultat_extrait as $key => $value) {
        echo "<div class='extraits'>";
        echo "<a class='btnFic' style=\"float: right;\" href=\"#modif_ext_".$value[0]."\">Modifier</a>";
        echo "<strong>ID extrait : </strong>" .$value[0];
        echo "<br/>";
        echo "<br/><strong>Solvant : </strong>" .constant($value[1]);
        echo "<br/><strong>Type d'extraction : </strong>" .$value[2];
        echo "<br/><strong>Etat : </strong>" .$value[3];
        echo "<br/>";
        echo "<br/><strong>Disponibilité : </strong>"; if ($value[4] == 1) echo "Oui"; else echo "Non";
        echo "<br/><strong>Protocole : </strong>" .$value[5];
        echo "<br/><strong>Lieu de stockage : </strong>" .$value[6];
        echo "<br/>";
        echo "<br/><strong>Observations : </strong>" .$value[7];
        echo "<br/><br/><strong>Licence : </strong>" .constant($value[11]);
        echo "<br/>";
        echo "<br/><strong>Nom du chimiste : </strong>" .$value[8]. " " .$value[9] ;
        echo "<br/><strong>Equipe : </strong>" .$value[10];
        echo "<div class='hr'>Purifications</div>";
        echo '
        <div id="modif_ext_'.$value[0].'" class="overlay">
          <div id="popup_modif" class="popup">
            <h2>ID Extraits '.$value[0].'</h2>
            <a class="close" href="#return">&times;</a>
            <div class="content">
              <form id="myForm" action="" method="POST">
                <input type="hidden" name="echantillon" value="'.$row_echantillon[0].'">
                <input type="hidden" name="type" value="Extraits">
                <input type="hidden" name="id" value="'.$value[0].'">
                <br/><strong>Solvant : </strong><br/>
                <select name="Solvant" required>
                  <option value=""></option>';
                    foreach ($dbh->query("select * from solvant") as $key1 => $value1) {
                      echo'<option value="'.$value1[0].'"'; if($value[1] == $value1[1]) echo "selected"; echo '>'.constant($value1[1]).'</option>';
                    }
                echo '
                </select>
                <br/><br/><strong>Type d\'extraction : </strong><br/><input name="TypeExtra" type="text" value="'.$value[2].'">
                <br/><br/><strong>Etat : </strong><br/><input name="Etat" type="text" value="'.$value[3].'">
                <br/><br/><strong>Disponibilité : </strong><br/><input name="Disponibilite" type="checkbox" '; if ($value[4] == 1) echo "checked"; echo '>
                <br/><br/><strong>Protocole : </strong><br/><textarea name="Protocole" rows="5" cols="50">'.$value[5].'</textarea>
                <br/><br/><strong>Lieu de stockage : </strong><br/><textarea name="Lieu" rows="5" cols="50">'.$value[6].'</textarea>
                <br/><br/><strong>Observations : </strong><br/><textarea name="Observations" rows="5" cols="50">'.$value[7].'</textarea>';
                echo '
                <br/><br/><strong>licence</strong><br/>
                <select name="Extrait_typ_id_type">';
                    foreach ($dbh->query("select * from type") as $key => $value1) {
                      echo'<option value="'.$value1[0].'"'; if($value1[1] == $value[11]) echo "selected" ;echo '>'.constant($value1[1]).'</option>';
                    }
                  echo '
                </select><br/><br/>
                ';
                echo '
                <br/><br/><strong>Nom du chimiste : </strong>' .$value[8].' ' .$value[9].'
                <br/><br/><strong>Equipe : </strong>' .$value[10].'
                <br/><br/><input type="submit" style="float: right;">
              </form>
            </div>
          </div>
        </div>
        ';
        echo "
        <div style='max-height: 250px;overflow: auto; width: 100%;'>
        <table class=\"table-tableau\">
        <tr>
        <th>ID</th>
        <th>Purification</th>
        <th>Ref cahier de labo</th>
        <th>Fichiers</th>
        <th></th>
        </tr>
        ";

        foreach ($resultat_purif as $key1 => $value1) {
          if($value1[4] == $value[0]){
            if(isset($_POST['modif']) && $_POST['modif'] == "Purification" && $_POST['ID'] == $value1[0]){
      				echo '<form action="" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="echantillon" value="'.$row_echantillon[0].'">
              <input type="hidden" name="type" value="Purification">
              <input type="hidden" name="id" value="'.$value1[0].'">';
      				echo "
                <tr>
                  <td>".$value1[0]."</td>
                  <td><input style=\"width: 100%;\" name='purification' value='".$value1[1]."'></td>
                  <td><input style=\"width: 100%;\" name='ref_book' value='".$value1[2]."'></td>
                  <td><input style=\"width: 100%;\" type=\"file\" name=\"fichier[]\" accept=\"image/*, .pdf, .xls,.xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel, .txt, application/msword\" multiple></td>
                  <td><button type=\"submit\" name=\"envoi_modif\" value=\"type\" title=\"Envoyer\" style=\"border: 0px;padding: 0px;background: transparent;\"><img border=\"0\" src=\"images/ok.gif\" width=\"20\" height=\"20\" alt=\"valider\"></button> <a href=\"?echantillon=".$_POST['echantillon']."\"><img border=\"0\" src=\"images/pasok.gif\" width=\"20\" height=\"20\" alt=\"annuler\"></a></td>
                </tr>
      				";
      				echo '</form>';
      			}
      			else{
              echo '
              <tr>
                <td>'.$value1[0].'</td>
                <td>'.$value1[1].'</td>
                <td>'.$value1[2].'</td>
                <td><a href="#fic_pur_'.$value1[0].'">'.$value1[3].' Fichier(s)</a></td>
                <td>
                  <form id="btnModifForm'.$value1[0].'" method="POST" >
                    <input type="hidden" name="echantillon" value="'.$row_echantillon[0].'"/>
                    <input type="hidden" name="modif" value="Purification" />
                    <input type="hidden" name="ID" value="'.$value1[0].'"/>
                  </form>
                  <a href="#" onclick="document.getElementById(\'btnModifForm'.$value1[0].'\').submit()"><img border="0" src="images/modifier.gif" width="20" height="20" alt="modifier"/></a>
                </td>
              </tr>
              ';
            }
          }
        }
        ?>
        <!-- [JM 07/2019] Formulaire de modif !-->
        <form id="myForm2" action="" method="POST" enctype="multipart/form-data">
        <?php if (isset($_POST['Ajouter2'.$value[0]])): ?>
          <tr>
            <td></td>
            <input type="hidden" name="echantillon" value="<?php echo $row_echantillon[0]; ?>">
            <input type="hidden" name="type" value="Purification_add">
            <input type="hidden" name="id" value="<?php echo $value[0]; ?>">
            <td><input style="width: 100%;" name='purification'></td>
            <td><input style="width: 100%;" name='ref_book'></td>
            <td><input style="width: 100%;" type="file" name="fichier[]" accept="image/*, .pdf, .xls,.xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel, .txt, application/msword" multiple></td>
            <td><button type="submit" name="save" value="type" title="Envoyer" style="border: 0px;padding: 0px;background: transparent;"><img border="0" src="images/ok.gif" width="20" height="20" alt="valider"></button> <a href="?echantillon=<?php echo $_POST['echantillon'];?>"><img border="0" src="images/pasok.gif" width="20" height="20" alt="annuler"></a></td>
          </tr>
        <?php endif; ?>

        </table>

        <?php if (!isset($_POST['Ajouter2'.$value[0]]) && !isset($_POST['modif']) || (isset($_POST['modif']) && $_POST['modif'] != "Purification")): ?>
          <input type="hidden" name="echantillon" value="<?php echo $row_echantillon[0]; ?>">

          <input type="hidden" name="id" value="<?php echo $value1[0]; ?>">
          <input type="submit" name="Ajouter2<?php echo $value[0]; ?>" value="Ajouter">
        <?php endif; ?>
        </form>
        <?php

        echo "</div>";
        echo "</div>";
      }
      echo "</div>";
      ?>

      <?php
      echo "<hr>";
      echo "<br/>";
      echo "<div class='container'>";
      echo "<div class='infos'>";
      echo "<div class='hr click_specimen'>Specimen</div>";
      if ($row[0]=='{ADMINISTRATEUR}') {
        echo "<a class='btnFic' style=\"float: right;\" href=\"#modif_specimen\">Modifier</a>";
      }
      echo "<br/>";
      echo "<br/>";
      echo "<br/><strong>Code specimen : </strong>" .$row_echantillon[9];
      echo "<br/>";
      echo "<br/><strong>Date de recolte : </strong>" .$row_echantillon[10];
      echo "<br/><strong>Lieu de recolte : </strong>" .$row_echantillon[11];
      echo "<br/><strong>Position GPS : </strong>" .$row_echantillon[12];
      echo "<br/>";
      echo "<br/><strong>Observations : </strong>" .$row_echantillon[13];
      echo "<br/>";
      echo "<br/><strong>Collection : </strong>" .$row_echantillon[14];
      echo "<br/><strong>Contact : </strong>" .$row_echantillon[15];
      echo "<br/><strong>Collecteur : </strong>" .$row_echantillon[16];
      echo "<br/><br/><a class='btnFic' href=\"#fic_spe_".$row_echantillon[9]."\">Voir les fichiers</a>";
      echo "<br/>";
      echo "</div>";

      echo "<div class='infos'>";
      echo "<div class='hr click_expedition'>Mission de récolte</div>";
      echo "<br/>";
      echo "<br/>";
      echo "<br/><strong>ID Mission de récolte : </strong>" .$row_echantillon[19];
      echo "<br/>";
      echo "<br/><strong>Nom : </strong>" .$row_echantillon[20];
      echo "<br/><strong>Contact : </strong>" .$row_echantillon[21];
      echo "<br/>";
      echo "<br/><strong>Pays : </strong>" .$row_echantillon[24];
      echo "<br/><strong>Collaboration : </strong>";if ($row_echantillon[25] == 1) echo "Oui"; else echo "Non";
      echo "</div>";

      echo "<div class='infos'>";
      echo "<div class='hr click_taxonomie'>Taxonomie</div>";
      echo "<br/><strong>ID taxonomie : </strong>" .$row_echantillon[26];
      echo "<br/>";
      echo "<br/><strong>Phylum : </strong>" .$row_echantillon[27];
      echo "<br/><strong>Classe : </strong>" .$row_echantillon[28];
      echo "<br/><strong>Ordre : </strong>" .$row_echantillon[29];
      echo "<br/><strong>Famille : </strong>" .$row_echantillon[30];
      echo "<br/><strong>Genre : </strong>" .$row_echantillon[31];
      echo "<br/><strong>Espece : </strong>" .$row_echantillon[32];
      echo "<br/><strong>Sous-espece : </strong>" .$row_echantillon[33];
      echo "<br/><strong>Varieté : </strong>" .$row_echantillon[34];
      echo "<br/>";
      echo "<br/><strong>Protocole : </strong>" .$row_echantillon[35];
      echo "<br/><strong>Sequence : </strong>" .$row_echantillon[36];
      echo "<br/><strong>Sequence ref cahier de labo : </strong>" .$row_echantillon[37];
      echo "<br/>";
      echo "<br/><strong>Type : </strong>" .$row_echantillon[40];
      echo "<br/><br/><a class='btnFic' href=\"#fic_tax_".$row_echantillon[26]."\">Voir les fichiers</a>";
      echo "<br/>";
      echo "</div>";

      echo "<div class='infos'>";
      echo "<div class='hr click_partie_organisme'>Partie organisme</div>";

      echo "<br/><strong>ID partie organisme : </strong>" .$row_echantillon[41];
      echo "<br/>";
      echo "<br/><strong>Origine : </strong>" .$row_echantillon[42];
      echo "<br/><strong>Partie : </strong>" .$row_echantillon[43]; //$row_echantillon[43] => FR; $row_echantillon[44] => EN
      echo "<br/>";
      echo "<br/><strong>Observations : </strong>" .$row_echantillon[45];
      echo "</div>";

      echo "<div class='infos'>";
      echo "<div class='hr click_condition'>Condition</div>";
      if ($row[0]=='{ADMINISTRATEUR}') {
        echo "<a class='btnFic' style=\"float: right;\" href=\"#modif_condition\">Modifier</a>";
      }
      if($row_echantillon[46]){
        echo "<br/>";
        echo "<br/>";
        echo "<br/><strong>ID condition : </strong>" .$row_echantillon[46];
        echo "<br/>";
        echo "<br/><strong>Milieu : </strong>" .$row_echantillon[47];
        echo "<br/><strong>Temperature : </strong>" .$row_echantillon[48].'°C';
        echo "<br/><strong>Type de culture : </strong>" .$row_echantillon[49];
        echo "<br/><strong>Mode operatoir : </strong>" .$row_echantillon[50];
        echo "<br/>";
        echo "<br/><strong>Observations : </strong>" .$row_echantillon[51];
        echo "<br/><br/><a class='btnFic' href=\"#fic_con_".$row_echantillon[46]."\">Voir les fichiers</a>";
        echo "<br/>";
      }
      echo "</div>";
      echo "</div>";

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
            echo '
            <form id="btnSupprForm'.$value1[0].'" method="POST" >
              <input type="hidden" name="echantillon" value="'.$row_echantillon[0].'"/>
              <input type="hidden" name="type" value="fic_pur_suppr" />
              <input type="hidden" name="id" value="'.$value1[0].'"/>
            </form>
            ';
            $liste_fic_purif .='<li><a href="telecharge.php?id='.$value1[0].'&rankExtra=purification" target="_blank"> Fichier '.$value1[0].' : '.$value1[2].'</a> | <a href="#" onclick="if (confirm(\'Etes-vous sûr ?\')){document.getElementById(\'btnSupprForm'.$value1[0].'\').submit();}">Supprimer</a></li>';
          }
        }
        if ($liste_fic_purif != "") {
          echo $liste_fic_purif;
        }
        else {
          echo "Aucun fichier";
        }

        echo '
        </div>
        </div>
        </div>
        ';
      }

      //Specemen
      echo '
      <div id="fic_spe_'.$row_echantillon[9].'" class="overlay">
      <div class="popup">
      <h2>Fichiers specimen '.$row_echantillon[9].'</h2>
      <a class="close" href="#return">&times;</a>
      <div class="content">
      ';
      $liste_spe = "";
      foreach ($dbh->query("SELECT * FROM fichier_specimen WHERE spe_code_specimen = '".$row_echantillon[9]."'") as $key => $value1) {
          $liste_spe .='<li><a href="telecharge.php?id='.$value1[0].'&rankExtra=specimen" target="_blank"> Fichier '.$value1[0].' : '.$value1[2].'</a></li>';
      }
      if ($liste_spe != "") {
        echo $liste_spe;
      }
      else {
        echo "Aucun fichier";
      }

      echo '</div>
      </div>
      </div>
      ';

      if ($row[0]=='{ADMINISTRATEUR}') {
        echo '
        <div id="modif_specimen" class="overlay">
        <div id="popup_select" class="popup">
        <h2>Conditions</h2>
        <a class="close" href="#return">&times;</a>
        <form id="myForm" action="" method="POST">
          <input type="hidden" name="echantillon" value="'.$row_echantillon[0].'">
          <input type="hidden" name="type" value="specimen">
        ';
        ?>
        <table id="tab_Specimen" class="display">
          <thead>
          <tr>
            <th></th>
            <th>Code</th>
            <th>Date</th>
            <th>Lieu</th>
            <th>GPS</th>
            <th style="width: 35%;">Observation</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($dbh->query("SELECT * FROM specimen ORDER BY spe_code_specimen") as $row_spe) {
            echo '
            <tr>
            <td><input class="echantillon_nouveau specimen_nouveau expedition_existant" type="radio" name="id" value="'.urldecode($row_spe[0]).'"></td>
            <td>'.urldecode($row_spe[0]).'</td>
            <td>'.urldecode($row_spe[1]).'</td>
            <td>'.urldecode($row_spe[2]).'</td>
            <td>'.urldecode($row_spe[3]).'</td>
            <td style="width: 35%;">'.urldecode($row_spe[4]).'</td>
            </tr>
            ';
          }
          ?>
        </tbody>
        </table>
        <br/>
        <center><input type="submit"></center>
        <?php
        echo '
        </form>
        </div>
        </div>
        ';
      }
      //Taxonomie
      echo '
      <div id="fic_tax_'.$row_echantillon[26].'" class="overlay">
      <div class="popup">
      <h2>Fichiers taxonomie '.$row_echantillon[26].'</h2>
      <a class="close" href="#return">&times;</a>
      <div class="content">
      ';
      $liste_tax = "";
      foreach ($dbh->query("SELECT * FROM fichier_taxonomie WHERE tax_id = '".$row_echantillon[26]."'") as $key => $value1) {
          $liste_tax .='<li><a href="telecharge.php?id='.$value1[0].'&rankExtra=taxonomie" target="_blank"> Fichier '.$value1[0].' : '.$value1[2].'</a></li>';
      }
      if ($liste_tax != "") {
        echo $liste_tax;
      }
      else {
        echo "Aucun fichier";
      }

      echo '</div>
      </div>
      </div>
      ';

      //condition
      if ($row[0]=='{ADMINISTRATEUR}') {
        if($row_echantillon[48]){
          echo '
          <div id="fic_con_'.$row_echantillon[48].'" class="overlay">
          <div class="popup">
          <h2>Fichiers conditions '.$row_echantillon[48].'</h2>
          <a class="close" href="#return">&times;</a>
          <div class="content">
          ';
          $liste_con = "";
          foreach ($dbh->query("SELECT * FROM fichier_conditions WHERE con_id = '".$row_echantillon[48]."'") as $key => $value1) {
              $liste_con .='<li><a href="telecharge.php?id='.$value1[0].'&rankExtra=conditions" target="_blank"> Fichier '.$value1[0].' : '.$value1[2].'</a></li>';
          }
          if ($liste_con != "") {
            echo $liste_con;
          }
          else {
            echo "Aucun fichier";
          }

          echo '</div>
          </div>
          </div>
          ';
        }

        echo '
        <div id="modif_condition" class="overlay">
        <div id="popup_select" class="popup">
        <h2>Conditions</h2>
        <a class="close" href="#return">&times;</a>
        <form id="myForm" action="" method="POST">
          <input type="hidden" name="echantillon" value="'.$row_echantillon[0].'">
          <input type="hidden" name="type" value="condition">
        ';
        ?>
        <center>
        <input type="radio" name="id" value="NULL"> Aucune condition
        <br/><br/>
        OU
        <br/><br/>
      </center>
        <table id="tab_Condition" class="display">
          <thead>
          <tr>
            <th></th>
            <th>ID</th>
            <th>Milieu</th>
            <th>Temperature</th>
            <th>Type de culture</th>
            <th>Mode operatoir</th>
            <th>Observation</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($dbh->query("SELECT * FROM condition ORDER BY con_id") as $row) {
            echo '
            <tr>
            <td><input class="echantillon_nouveau specimen_nouveau expedition_existant" type="radio" name="id" value="'.urldecode($row[0]).'"></td>
            <td>'.urldecode($row[0]).'</td>
            <td>'.urldecode($row[1]).'</td>
            <td>'.urldecode($row[2]).'°C</td>
            <td>'.urldecode($row[3]).'</td>
            <td>'.urldecode($row[4]).'</td>
            <td>'.urldecode($row[5]).'</td>
            </tr>
            ';
          }
          ?>
        </tbody>
        </table>
        <br/>
        <center><input type="submit"></center>
        <?php
        echo '
        </form>
        </div>
        </div>
        ';
      }

    }
    else {
      echo "<center><h2>Aucun résultat trouvé</h2></center>";
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

    $('#tab_Specimen').DataTable({select: {style: 'single'}});

    $('#tab_Specimen tr').click(function() {
      $(this).find('td input:radio').prop('checked', true);
    });

    $('#tab_Condition').DataTable({select: {style: 'single'}});

    $('#tab_Condition tr').click(function() {
      $(this).find('td input:radio').prop('checked', true);
    });
});
</script>
