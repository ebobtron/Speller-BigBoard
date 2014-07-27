<?php 

    error_reporting(E_ALL);  // E_ALL | E_STRICT
    
    require_once (__DIR__ . '/../include/jpgraph-3.5.0b1/src/jpgraph.php');
    require_once (__DIR__ . '/../include/jpgraph-3.5.0b1/src/jpgraph_line.php');
    require_once (__DIR__ . '/../include/jpgraph-3.5.0b1/src/jpgraph_scatter.php');
    require_once (__DIR__ . '/../include/jpgraph-3.5.0b1/src/jpgraph_regstat.php');

/*     
    $ydata = array(11,11,11,8,3);

    // Create the graph.
    $graph = new Graph(350,250);	
    $graph->SetScale("intlin");
    $graph->img->SetMargin(30,90,40,50);
    $graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
    $graph->title->Set("Example 1.1 same y-values");

    // Create the linear plot
    $lineplot= new LinePlot($ydata);
    $lineplot->SetLegend("Test 1");
    $lineplot->SetColor("blue");
    $lineplot->SetWeight(5);

    // Add the plot to the graph
    $graph->Add($lineplot);
    
    // breaks it
    // render header
    require("../template/header.php");

    // Display the graph
    $graph->Stroke();

    // breaks it
    // render footer
    require("../template/footer.php");  */
    
    /*
    
    // Some (random) data
$ydata = array(11,3,8,12,5,1,9,13,5,7);

// Size of the overall graph
$width=600;
$height=400;

// Create the graph and set a scale.
// These two calls are always required
$graph = new Graph($width,$height);
$graph->SetScale('intlin');

// Create the linear plot
$lineplot= new LinePlot($ydata);

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke(); */



// Original data points
$xdata = array(.05,.1,.15,.20,.25,.30,.35,.40,.45);
$ydata = array(0,0,2,13,13,8,10,3,0);

/*
$xdata = array(1,3,5,7,9,12,15,17.1);
$ydata = array(5,1,9,6,4,3,19,12);

0.000 - 0.050 , 0
0.100 - 0.150 , 2
0.150 - 0.200 , 13
0.200 - 0.250 , 13
0.250 - 0.300 , 8
0.300 - 0.350 , 10
0.350 - 0.400 , 3
0.350 - 0.400 , 0
0.400 - 0.450 , 1
0.400 - 0.450 , 0
0.500 - 0.550 , 1
*/

// Get the interpolated values by creating
// a new Spline object.
$spline = new Spline($xdata,$ydata);

// For the new data set we want 40 points to
// get a smooth curve.
list($newx,$newy) = $spline->Get(50);

// Create the graph
$g = new Graph(600,400);
$g->SetMargin(30,40,40,30);
$g->title->Set("Leader Board Times");
//$g->title->SetFont(FF_ARIAL,FS_NORMAL,12);
$g->subtitle->Set('(Control points shown in red)');
$g->subtitle->SetColor('darkred');
$g->SetMarginColor('lightblue');

$g->img->SetAntiAliasing();

// We need a linlin scale since we provide both
// x and y coordinates for the data points.
$g->SetScale('linlin');

// We want 0.00 decimal for the X-label
$g->xaxis->SetLabelFormat('%1.2f');
$g->xaxis->SetTextLabelInterval(1);

// We use a scatterplot to illustrate the original
// contro points.
//$splot = new ScatterPlot($ydata,$xdata);
//$splot->mark->SetFillColor('red@0.3');
//$splot->mark->SetColor('red@0.5');

// And a line plot to stroke the smooth curve we got
// from the original control points
$lplot = new LinePlot($newy,$newx);
$lplot->SetColor('navy');

// Add the plots to the graph and stroke
$g->Add($lplot);
//$g->Add($splot);
$g->Stroke();

?>