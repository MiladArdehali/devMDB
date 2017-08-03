<?php

switch ($_GET["paysRecherche"]) {
    case "Recherche en France":
        $_GET["paysRecherche"] = "FR";
        break;
    case "Recherche dans le Monde":
        $_GET["paysRecherche"] = "";
        break;
    default:
        $_GET["paysRecherche"] = "";
        break;
}

$country = $_GET["paysRecherche"];

switch ($_GET["langueResultat"]) {
    case "Francais":
        $_GET["langueResultat"] = "lang_fr";
        break;
    case "Anglais":
        $_GET["langueResultat"] = "lang_en";
        break;
    default:
        $_GET["langueResultat"] = "lang_fr";
        break;
}
$language = $_GET["langueResultat"];
$query = urlencode($_GET["query"]);
$startIndex = (isset($_GET["start"])) ? $_GET["start"] : "1";
$num = (isset($_GET["maxResult"])) ? $_GET["maxResult"] : "10";
$api_key = "AIzaSyCkYsVmlhuPBYNFXvgTDX7syg9nW2sS0yU";
$cx = "008959875526066767825%3Awnxz1i3p5ys"; //The custom search engine ID
$source = "etools";
$algorithm = "lingo3g";
$hierarchy = "max-hierarchy-depth";
$level_hierarchie= $_GET["deep"] ? $_GET["deep"] : "1";

// arraylist composée des parametres à envoyer à carrot2
/*
 $parametre = array(
    "max-clustering-passes-top" => "0",
    "max-clustering-passes-sub" => "0",
    "hierarchical-merging-with-labels" => "true",
    "max-cluster-size" => "1",
    "combined-cluster-score-balance" => "1.0"
    "flatMerging" => "true"
 
  );
 */
 
   
