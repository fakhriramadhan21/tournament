<!-- Php functions and variables-->
<?php
	global $TeamArray;
	global $PositionArray;

	

	if (isset($_POST['data'])) {
		$message = "wrong answer";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
	
	function scheduler($teams){
		if (count($teams)%2 != 0){
			array_push($teams,"bye");
		}
		$away = array_splice($teams,(count($teams)/2));
		$home = $teams;
		for ($i=0; $i < count($home)+count($away)-1; $i++){
			for ($j=0; $j<count($home); $j++){
				$round[$i][$j]["Home"]=$home[$j];
				$round[$i][$j]["Away"]=$away[$j];
			}
			if(count($home)+count($away)-1 > 2){
				array_unshift($away,array_shift(array_splice($home,1,1)));
				array_push($home,array_pop($away));
			}
		}
		return $round;
	}


	function someFunction($errno, $errstr) {
		$message = "wrong answer";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
	
	function writeTeamSquareToPosition($name, $pos, $BracketArray,$updatedscore,$id,$winner) {
		?>
			
		<?php
    $BracketArray1 = unserialize(file_get_contents('yourfile.bin'));
    
		?>
		<div class="card" style="width: 10rem;height: 2rem;position:absolute;z-index:2;left:<?php echo $pos[0]; ?>px;top:<?php echo $pos[1]; ?>px">
					<div class="card-body cardsaya">
					<h5 class="card-title">
		<?php
		$i=count( $BracketArray1 );
		$i=$i/2;
		$i = round($i);
		$j = $i/2;
		$k = $j/2;
		$k--;
		// echo $j." ".$k;

		for($index=count( $BracketArray )-1;$index > 0;$index-=2) {
				$index1 = $index-1;
				if($id%2 && $id!="0" && $BracketArray[$id][0]!=" "&&$BracketArray1[$index][0]!=" "&&$BracketArray1[$index1][0]!=" "){
					$id1 = $id++;
					// echo $id1;
					$tim= $BracketArray[$id][0];
					$tim1= $BracketArray[$id1][0];
					?>
					<button style="margin-left:-50%;font-size : 10px;" onclick="test('<?php print_r($id);?>','<?php print_r($id1);?>','<?php print_r($tim);?>','<?php print_r($tim1);?>');"><i class='fas fa-edit' style='font-size:25px;color:#428bca'></i><button>
					<?php
				}
			}	
    ?>
        <button>
    <?php
	
      ?><?php print_r($name) ; ?> :<?php print_r($updatedscore) ; ?><?php
		?>			
		<?php
		?>
    </button>
		</h5>
		</div>
				</div>
		<?php
		// echo "</div>";
  }
  
	function add($a,$b){
		$c=$a+$b;
		return $c;
		$message = "wrong answer";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}

	function writeTeamSquare($name) {
		echo "<div class=\"TeamSquare\">".$name."</div>";
		
	}
	
	function drawLine($start, $end) {
		?>
		<svg style="position:absolute;width:100%;height:100%;top:0px;left:0px;z-index:1">
		<?php
		echo "<line x1=$start[0] y1=$start[1] x2=$end[0] y2=$end[1] style=\"stroke:black;stroke-width:2px\" />";
		?>
		</svg>
		<?php
	}
	
	function drawLineToParent($array, $index, $PositionArray,$id) {
		$childPos = $PositionArray[$index];
		$parentPos = $PositionArray[floor(($index - 1) / 2)];
		
		drawLine([$childPos[0] + 150, $childPos[1] + 15], [midpoint($childPos[0] + 150, $parentPos[0]), $childPos[1] + 15],NULL); //Draw Horizontal Line halfway between end of child to beginning of parent
		drawLine([midpoint($childPos[0] + 150, $parentPos[0]), $childPos[1] + 15], [midpoint($childPos[0] + 150, $parentPos[0]), $parentPos[1] + 15],NULL); //Vertical Line to parent's height
    drawLine([midpoint($childPos[0] + 150, $parentPos[0]), $parentPos[1] + 15], [$parentPos[0], $parentPos[1] + 15],$id); //Draw Horizontal Line the rest of the way to Parent
    ?>
			</button>
		<?php
	}
	
	function getDepth($arrayTree) {
		return ceil(log((count($arrayTree) + 1))/log(2)) - 1;
	}
	
	function hasChildren($array, $index) {
		if(isset($array[$index * 2 + 1]) && isset($array[$index * 2 + 2]))
			return true;
		return false;
	}
	
	function midpoint($first, $second) {
		return ($first + $second) / 2;
	}
?>

<?php 
if($_POST != null) {
	$TeamArray = preg_split("/[\n\r]+/", $_POST["Teams"], NULL, PREG_SPLIT_NO_EMPTY);
	shuffle($TeamArray);
	$BracketArraySingle = array_fill(0, pow(2, ceil(log(count($TeamArray))/log(2)) + 1) - 1, " ");
	$lastRowIndex = floor(count($BracketArraySingle) / 2);
	$offset = ceil(count($BracketArraySingle) / 2) - count($TeamArray);

	
	
	for($i = 0; $i < count($TeamArray); $i++) {
		$BracketArraySingle[$lastRowIndex + $i - $offset] = $TeamArray[$i];
	}

	$BracketArray = array();
	for($i = 0; $i < count($BracketArraySingle); $i++) {
		$BracketArray[$i][2] = $i;
	}
	foreach ($BracketArraySingle as $key => $value) {
		$BracketArray[$key][0] = $value;
		$BracketArray[$key][1] = "";
		
	}
	file_put_contents('yourfile.bin', serialize($BracketArray));

}
$BracketArray = unserialize(file_get_contents('yourfile.bin'));

?>