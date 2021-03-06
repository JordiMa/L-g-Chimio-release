<?php
/*
Copyright Laurent ROBIN CNRS - Université d'Orléans 2011 
Distributeur : UGCN - http://chimiotheque-nationale.enscm.fr

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
class envoi_pass {
  
  public $id_nom;  //nom de la structure
  public $pass;    //nouveau mot de passe

  function __construct ($id_nom,$pass) {
    $this->id_nom=$id_nom;
    $this->pass=$pass;
  }

  function envoi() {
    $date=date("l d F Y à H:i");
	require 'script/connectionb.php';
    $sql="SELECT chi_email,chi_nom,chi_langue,chi_prenom FROM chimiste WHERE chi_id_chimiste='".$this->id_nom."'";
	$result=$dbh->query($sql);
    $row=$result->fetch(PDO::FETCH_NUM);
    include_once 'langues/'.$row[2].'/lang_email.php';
    $sql="SELECT para_nom_labo,para_email_envoie FROM parametres";
    $result1=$dbh->query($sql);
    $row1=$result1->fetch(PDO::FETCH_NUM);
    $sujet='=?utf-8?Q?' . quoted_printable_encode(SUJET) . '?=';
    $message=BONJOUR." ".$row[1]." ".$row[3].",\n\n";
    $message.=ACC.$row1[0].SON."\n\n\n";
    $message.=NEWLOG.$row[1]."\n";
    $message.=NEWPASS.$this->pass."\n\n\n";
    $message.=POLIT;
    $headers="From: ".$row1[1]."\n";
    $headers.="X-Accept-Language: ".$row[2]."\n";
	$headers.="Mime-Version: 1.0\n";
	$headers.="Content-Type: text/plain; charset=\"UTF-8\"\n";
	$headers.="Content-Transfer-Encoding: 8bit\n";
    ini_alter("sendmail_from",$row1[1]);
    mail($row[0],$sujet,$message,$headers);
    ini_restore("sendmail_from");
	unset ($dbh);
  }
}
?>