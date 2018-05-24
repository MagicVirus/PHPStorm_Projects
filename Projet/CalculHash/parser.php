<?php
/**
 * Created by PhpStorm.
 * User: Magi
 * Date: 11/02/2018
 * Time: 16:34
 */


$document_xml = new DomDocument(); // Instanciation de la classe DomDocument : création d'un nouvel objet
$resultat_html = ''; // Initialisation de la chaîne qui contient le résultat
$document_xml->load('../model/examples/document.xml'); // Chargement à partir de document.xml
/*$elements = $document_xml->getElementsByTagName('document');
$element = $elements->item(0); // On obtient le nœud document
$enfants = $element->childNodes; // On récupère les nœuds enfants de document avec childNodes
foreach($enfants as $enfant) // On prend chaque nœud enfant séparément
{
    $nom = $enfant->nodeName; // On prend le nom de chaque nœud

    if ($nom == 'lastname') {
        $resultat_html .= '<strong>' . $enfant->nodeValue . '</strong>';
    } elseif ($nom == '#text') {
        $resultat_html .= $enfant->nodeValue;
    } else {
        $resultat_html .= $enfant->nodeValue;
    }
}*/
$domres= 'le DOM<br/>';
echo $domres;
echo $document_xml->saveXML();
$simple = "<para><note>simple note</note></para>";
/*$p = xml_parser_create();
xml_parse_into_struct($p, $simple, $values, $index);
xml_parser_free($p);
echo "Index array\n";
print_r($index);
echo "\nValues array\n";
print_r($values);*/


//PARSER
$getfile = file_get_contents('../model/examples/document.xml');
$getfileres='<br/>le GetFile<br/>';
$getfileres.=$getfile;
echo $getfileres;
$arr = simplexml_load_string($getfile);
$arrres= '<br/>le Array<br/>';
$arrres.=$arr;
echo $arrres;
/*foreach($arr-> as $a => $b) {
    echo "<br>".$a,'="',$b,"\"\n";
}*/