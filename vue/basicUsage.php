<?php

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
                width: 600px;
                height: 400px;
                border: 1px solid lightgray;
            }
        </style>
    </head>
    <body>

        <p>
            Create a simple network with some nodes and edges.
        </p>


        <div id="mynetwork"></div>

        <script type="text/javascript">
            // create an array with nodes
            var nodes = new vis.DataSet([
                {id: 0, label: 'requete', shape: 'diamond', group: 0},
                {id: 1, label: 'Groupe2', shape: 'circle', group: 1},
                {id: 2, label: 'Groupe1', shape: 'circle', group: 2},
                {id: 3, label: 'reponse', shape: 'circle', group: 1},
                {id: 4, label: 'reponse', shape: 'circle', group: 1},
                {id: 5, label: 'reponse', shape: 'circle', group: 3},
            ]);

            // create an array with edges
            var edges = new vis.DataSet([
                {from: 1, to: 3},
                {from: 1, to: 2},
                {from: 2, to: 4},
                {from: 2, to: 5},
                {from: 3, to: 3}
            ]);

            // create a network
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


