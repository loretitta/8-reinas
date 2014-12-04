<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * @param $board - the board rows which are filled with column numbers
 * @param $index - the current row number
 * @param $filledPositions - the columns which are filled with the corresponding row number
 * @param $indexIteration - a counter to determine how many times the index has been tried.
 */
function placeQueens(&$board, &$index, &$filledPositions, $rand=null, $startRand=null, $rolledOver=false){
	//check if we're done here.	
	if($index[0] == count($board)){
		//done
		return;
	}
	//http://imgur.com/delete/z5O40E9aHn0BLmZ
	if(!is_null($rand) && $rand >= count($board)){
		//roll over to 0
		$rand = 0;
		$rolledOver = true;
	}
	//generate a new random number starting position
//	echo "rand: ".$rand.",".$startRand." -- <br />";
//	var_dump(!is_null($rand) && ($rand == $startRand));
	if(!is_null($rand) && ($rand == $startRand)){ //rolled over, game unsolvable in current state. Try again.
//		echo $rand.'=='.$startRand."<br />";
		$board = array_fill(0,count($board) ,null);
		$filledPositions = array();
		$index = array(0);
		placeQueens($board, $index, $filledPositions);
		return false;
	}else if(is_null($rand)){
		$rand = mt_rand(0,count($board)-1);
		$startRand = $rand;
	}
	
//	echo "finding position for {$index[0]},{$rand}<br />";
	if(isset($filledPositions[$rand])){
//		echo "fillpos set at {$filledPositions[$rand]},{$rand}<br />";
		//try this again, post increment
		placeQueens($board, $index, $filledPositions, ++$rand, $startRand, $rolledOver);
		$index[0] = $index[0]+1;
		return;
	}
	//check diagonal
	if($index[0] > 0){
//		echo "finding diag for {$index[0]},{$rand}<br />";
		for($i=1; $i < count($board); $i++){
			if(isCollision($index[0]+$i, $rand+$i, $board, $filledPositions)
				|| isCollision($index[0]+$i, $rand-$i, $board, $filledPositions)
				|| isCollision($index[0]-$i, $rand+$i, $board, $filledPositions)
				|| isCollision($index[0]-$i, $rand-$i, $board, $filledPositions)
			){
				placeQueens($board, $index, $filledPositions, ++$rand, $startRand, $rolledOver);
				$index[0] = $index[0]+1;
				return;
			}
		}
	}
	
	//fallthrough
	//successful placement
	$board[$index[0]] = $rand;
	$filledPositions[$rand] = $index[0];
//	echo "placed ".$index[0].",".$rand."<br />";
	$index[0] = $index[0]+1;
	placeQueens($board, $index, $filledPositions);
	return true;
}


function isCollision($row, $col, &$board, &$filledPositions){
	if($row < 0 || $col < 0 || $row >= count($board) || $col >= count($board)) return false;
//echo $row." - ".$col;
//print_r($board);
//print_r($filledPositions);
//var_dump(!is_null($board[$row]));
//var_dump(isset($filledPositions[$col]));
//echo "<br />";
	if(!is_null($board[$row]) && $board[$row] == $col){
		return true;
	}
	return false;
}

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/reset.css">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<style>
			div{
				float:left;
				
			}
			div.black{
				background-color:#B58862;
				width:20px;
				height:20px;
				text-align:center;
				
			}
			div.white{
				background-color:#F0D9B5;
				width:20px;
				height:20px;
				text-align:center;
				
			}
		</style>
	</head>
	<body>
		<h1>Recursion: Lighter N-Queens</h1>
		<p style="width:500px;">My <a href="nqueens.php">first nqueens implementation</a> pushed the server to its allocated memory limits at about n=16.  After posting the <a href="http://ericjankowski.com/php/nqueens.php">demo</a> and <a href="https://github.com/jankenstein/php/blob/master/recursion/nqueens.php">source code</a> to both <a href="http://www.reddit.com/r/PHP/comments/145fch/recursion_brute_force_nqueens_any_suggestions_for/">reddit</a> and <a href="http://stackoverflow.com/questions/13670955/optimizing-n-queens-solution-in-php">stackoverflow</a>, I received this project's first pull request from <a href="https://github.com/ajbogh">ajbogh</a>.</p>
		<p style="width:500px;">This is his solution, and while I am impressed that it can support a much higher n (40's - 50's depending on the random numbers that are chosen), I am more impressed that he took the time.  PHP's biggest strong points are its low barrier to entry and its ubiquitous presence on server platforms.  I really appreciate the fact the ajbogh took the time to play with a pretty pesky but (at the end of the day) trivial problem of optimizing a PHP system that I fumbled through enough to be computationally intensive.</p>
		<p style="width:500px">I am just getting started with PHP, so I haven't interacted much with the PHP community, yet, but if ajbogh is any indication, I'm going to meet some very smart and very helpful developers out there.</p>
		<p>Thanks.</p>
		<form action="nqueens_2.php" method="GET">
			<p>Number of queens: <input name="queens" type="text" /><input name="submit" type="submit" value="Go" /></p>
		</form>
		<div style='margin:50px;border:1px solid black;'>
<?php

if(isset($_GET['queens']) && is_numeric($_GET['queens']) && $_GET['queens'] > 4){
	$queens = $_GET['queens'];
}else{
	$queens = 8;
}

//build an array that is the size of the queens number
$placements = array_fill(0,$queens,null); //either null or -1
$filledPositions = array();
$index = array(0);

placeQueens($placements, $index, $filledPositions);
//doesn't get here on 26

//print_r($placements);

//places queens on the board.
for ($i=0;$i<$queens;$i++){
	echo "<div style='clear:left;'>\n";
	for($j=0;$j<$queens;$j++){
		if(($i+$j)%2==0){
			echo "<div class='black'>";
		}else{
			echo "<div class='white'>";
		}
		if ($placements[$i]==$j){
			echo "<img height='20' src='../images/queen.png'/>";
		}else{
			echo "&nbsp;";
		}
		echo "</div>\n";
	}
	echo"</div>\n";
}

?>
		</div>
	</body>
</html>
