<?php
    $file = 'resultatSearch10result.xml';
    $xml = simplexml_load_file($file);

    // generation des  elements
    $sElements = '';
    for ($i = 0; $i < $xml->document->count(); $i++) {
        $oDoc = $xml->document[$i];
        $sElements .= "{id: 'ele_" .$oDoc['id']. "', label: '" . substr($oDoc->title, 0, 5) . "', shape: 'square', group: 2, url: '".urlencode( $oDoc->url )."'},\n";
    }
    $sElements = rtrim(trim($sElements), ',');
    
    //recupere tous les groupes
    $oGroups = $xml->xpath('//group');
    
    // tous les groupes du documents avec imbrication    
    if( count( $oGroups ) > 0 ){
        $sElements .= ",\n";
        for ($i = 0; $i < count($oGroups); $i++) {
            $sElements .= "{id: 'grp_" .$oGroups[$i]['id']. "', label: '" . substr($oGroups[$i]->title->phrase, 0, 6) . "', shape: 'diamond', group: 1},\n";
        }
        $sElements = rtrim(trim($sElements), ',');
    }
    
    // generation des liens
    $sLinks = '';
    
    // liste des references documents/groupes
    $oRefDocsGrps = array();
    
    // pour les groupes
    if( count( $oGroups ) > 0 ){
        //$sElements .= ",\n";
        for ($i = 0; $i < count($oGroups); $i++) {
            
            // determine si le parent est un groupe
            $oGroup = $oGroups[$i];
            $oParent = $oGroup->xpath("..");
            $sIdParent = (
                $oParent[0]->getName() == 'group' ?
                    'grp_'.$oParent[0][ 'id' ] :
                    '0'
            );
            $sLinks .= "{from: 'grp_".$oGroup[ 'id' ]."', to: '".$sIdParent. "'},\n";
            
            // si il y a des documents
            if (isset($oGroup->document) && $oGroup->document->count() > 0) {
                for ($a = 0; $a < $oGroup->document->count(); $a++) {
                    $sRefIdDoc = $oGroup->document[$a]['refid'].'';
                    
                    // determine si le document doit etre reference par le goupe, en fonction du score
                    if( !isset( $oRefDocsGrps[ $sRefIdDoc ] ) ){
                        $oRefDocsGrps[ $sRefIdDoc ] = $oGroup;
                    }else if( floatval( $oGroup[ 'score' ] ) > floatval( $oRefDocsGrps[ $sRefIdDoc ][ 'score' ] ) ){
                        $oRefDocsGrps[ $sRefIdDoc ] = $oGroup;
                    }

                    
//                    
//                    $sLinks .= "{from: 'grp_" . $oGroup['id'] . "', to: 'ele_" . $sRefIdDoc . "'},\n";
                }
            }
        }
        $sLinks = rtrim(trim($sLinks), ',');
    }
    
    // pour les liaisons documents et groupes
    if( count( $oRefDocsGrps ) > 0 ){
        if( $sLinks != '' ){
            $sLinks .= ",\n";
        }
        foreach( $oRefDocsGrps as $sRefIdDoc=>$oGroup ){
            $sLinks .= "{from: 'grp_" . $oGroup['id'] . "', to: 'ele_" . $sRefIdDoc . "'},\n";
        }
        $sLinks = rtrim(trim($sLinks), ',');
    }
    
   // var_dump( $oRefDocsGrps );
    //exit();
    
    // generation des Urls
    $sUrls = '';
    for ($i = 0; $i < $xml->document->count(); $i++) {
        $oDoc = $xml->document[$i];
        $sUrls .= '"ele_'.$oDoc['id'].'":"'.urlencode( $oDoc->url ).'",';
    }
    $sUrls = rtrim(trim($sUrls), ',');
    
    // generation du visuel
    $sQuery = $xml->query;

?><!doctype html>
<html>
    <head>
        <title>Network | Basic usage</title>

        <script type="text/javascript" src="../MetaMoteurLingo3G/js/vis.js"></script>
        <!-- <script src="http://visjs.org/dist/vis.js"></script>-->
        <link href="../css/vis-network.min.css" rel="stylesheet" type="text/css" />

        <style type="text/css">
            #mynetwork {
                width: auto;
                height: 800px;
                border: 1px solid lightgray;
            }
        </style>
    </head>
    <body>
        <h3 style="color: blue; text-align: center">Referencement des resultats pour votre recherche : <?php echo $sQuery; ?></h3>
        <hr>
        <div id="eventSpan"></div>
        <hr>
        <div id="mynetwork"></div>

        <script type="text/javascript">
            
            // create an array with nodes
            var nodes = new vis.DataSet([
                {id: 0, label: '<?php echo $sQuery; ?>', shape: 'big database', group: 0},
                <?php echo $sElements; ?>
            ]);

            var edges = new vis.DataSet([
                <?php echo $sLinks; ?>
            ]);

            var oUrls = {<?php echo urldecode($sUrls); ?>};
            var container = document.getElementById('mynetwork');
            var data = {
                nodes: nodes,
                edges: edges
            };
            var options = {};
            var network = new vis.Network(container, data, options);
            
            network.on("click", function (params) {
                 // determine si c'est un document
                if( oUrls[ params.nodes[0] ] === undefined ){

return;
                }
                params.event = "[original event]";
                document.getElementById('eventSpan').innerHTML = '<h2>Lien:</h2> <a href="' + oUrls [params.nodes[0] ] + '" target="blank">' + oUrls [params.nodes[0] ] +'</a>';
                console.log( 'Identifiant : ' + params.nodes[0] );
                //console.log( JSON.stringify(params, null, 4) );
                console.log( oUrls[ params.nodes[0] ] );
                });
            
			
			// test pour le bon fonctionnement de git
    
    
        </script>
    </body>
</html>