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
//permet de protéger les variables POST et GET contre la saisie de codes malicieux par l'intermédiaire des formulaires

if (isset($_POST)) {
  reset($_POST);
  foreach ($_POST as $k=>$elem){
    if (is_array($_POST[$k])) {
      foreach ($_POST[$k] as $w=>$val) {
        $_POST[$k][$w]=$_POST[$k][$w];
        $_POST[$k][$w]=strip_tags($_POST[$k][$w]);
      }
    }
    elseif ($k!="mol" or $k!="smiles" or $k!="inchi") {
        $_POST[$k]=strip_tags($_POST[$k],'<a><br/><li><ul><p><sub><sup><em><strong><h1><h2><h3><span>');
    }
  }
}
if (isset($_GET)) {
  reset($_GET);
  foreach ($_GET as $k=>$elem){
    if (is_array($_GET[$k])) {
      foreach ($_GET[$k] as $w=>$val) {
        $_GET[$k][$w]=rawurlencode($_GET[$k][$w]);

      }
    }
    if ($k!="mol" or $k!="smiles" or $k!="inchi") {
        $_GET[$k]=rawurlencode($_GET[$k]);

    }
  }
}
?>