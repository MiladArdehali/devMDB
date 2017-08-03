<?php
$query = $_GET["query"];
$num = $_GET["maxResult"];
$source = "etools";
$algorithm = "lingo3g";
$format = $_GET["fts"];
$hierarchy = "max-hierarchy-depth";
$level_hierarchie = $_GET["deep"] ? $_GET["deep"] : "1";

require_once('model/Carrot2.php');

$processor = new Carrot2Processor();
$job = new Carrot2Job();
$job->setSource($source);
$job->setQuery($query);
$job->setAlgorithm($algorithm);
$job->setAttribute("results", $num);
$job->setAttribute($hierarchy, $level_hierarchie);

try {
    $result = $processor->cluster($job);
} catch (Carrot2Exception $e) {
    echo 'An error occurred during processing: ' . $e->getMessage();
    exit(10);
}

switch ($format) {
    case "xml":

        //displayRawXml($result->getXml());
        break;
    case "json":
        $xml = simplexml_load_string($result->getXml());

        $json = json_encode($xml);
        $array = json_decode($json, true);
        var_dump($array);
        //echo json_encode($xml, JSON_FORCE_OBJECT);
        break;
    default:

        break;
}

function displayRawXml($xml) {
    echo "<pre class='xml'>";
    echo htmlspecialchars($xml);
    echo "</pre>";
}

$xml = simplexml_load_string($result->getXml());



$oDocuments = array();
for ($i = 0; $i < $xml->document->count(); $i++) {
    $oDoc = $xml->document[$i];
    $oDocuments[$oDoc['id'] . ''] = $oDoc;
}





$documents = htmlspecialchars($result->getXml());

$nbreGroup = $xml->group->count();
?>
<!doctype html>
<html>
    <head>
        <title>Network | Basic usage</title>

        <script type="text/javascript" src="../js/vis.js"></script>
        <!-- <script src="http://visjs.org/dist/vis.js"></script>-->
        <link href="../css/vis-network.min.css" rel="stylesheet" type="text/css" />

        <style type="text/css">
            #mynetwork {
                width: auto;
                height: 760px;
                border: 1px solid lightgray;
            }
        </style>
    </head>
    <body>

        <p>
            Referencement des resultats pour votre recherche :  <?php echo $xml->query ?>
        </p>


        <div id="mynetwork"></div>

        <script type="text/javascript">
            // create an array with nodes
            var nodes = new vis.DataSet([
<?php
echo "{id: 0, label: '" . $xml->query . "', shape: 'big database', group: 0},";
for ($i = 0; $i <= $nbreGroup-1; $i++) {
    echo "{id: 'grp_" . $i . "', label: '" . substr($xml->group[$i]->title->phrase, 0, 10) . "', shape: 'circle', group: 1},";
}
foreach ($oDocuments as $sId => $oDoc) {

    echo "{id: 'ele_" . $sId . "', label: '" . substr($oDoc->title, 0, 10) . "', shape: 'square', group: 2},";

    
}

?>

            ]);


            var edges = new vis.DataSet([
<?php
for ($i = 0; $i <= $nbreGroup - 1; $i++) {
    echo "{from: 0, to: 'grp_" . $i . "'},";

    // si il y a des documents
    if ($xml->group[$i]->document->count() > 0) {
        for ($a = 0; $a < $xml->group[$i]->document->count(); $a++) {
            $sRefIdDoc = $xml->group[$i]->document[$a]['refid'];
            echo "{from: 'grp_" . $i . "', to: 'ele_" . $sRefIdDoc . "'},";
        }
    }
}
?>


            ]);


            var container = document.getElementById('mynetwork');
            var data = {
                nodes: nodes,
                edges: edges
            };
            var options = {};
            var network = new vis.Network(container, data, options);
        </script>


    </body>
</html>