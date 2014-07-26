<?php // content="text/plain; charset=utf-8"
    require_once (__DIR__ . '/../include/jpgraph-3.5.0b1/src/jpgraph.php');
    require_once (__DIR__ . '/../include/jpgraph-3.5.0b1/src/jpgraph_line.php');
     
    $ydata = array(11,11,11);

    // Create the graph.
    $graph = new Graph(350,250);	
    $graph->SetScale("textlin");
    $graph->img->SetMargin(30,90,40,50);
    $graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
    $graph->title->Set("Example 1.1 same y-values");

    // Create the linear plot
    $lineplot=new LinePlot($ydata);
    $lineplot->SetLegend("Test 1");
    $lineplot->SetColor("blue");
    $lineplot->SetWeight(5);

    // Add the plot to the graph
    $graph->Add($lineplot);
    
    // render header
    require("../template/header.php");

    // Display the graph
    $graph->Stroke();

    // render footer
    require("../template/footer.php");

?>