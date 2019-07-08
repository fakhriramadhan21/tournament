<?php include 'header.php' ?>

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
		echo "<div class=\"TeamSquare\" style=\"position:absolute;z-index:2;left:$pos[0]px;top:$pos[1]px\">";
		$index = array_search($id, array_column($BracketArray,0));

		if($BracketArray1[0][0]!==""){
			?>
				<button onclick="sweet('<?php echo $name ; ?>','<?php echo $index ; ?>','<?php echo $id ; ?>')"><?php print_r($name) ; ?> Score :<?php print_r($updatedscore) ; ?><?php echo $BracketArray1[0][0] ; ?></button>
			<?php
		}else if ($BracketArray1[0][0]==""){

		?>
				<button>winner is <?php echo $BracketArray[0][0] ; ?></button>			
		<?php
		}
		
		echo "</div>";
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
		echo "<svg style=\"position:absolute;width:100%;height:100%;top:0px;left:0px;z-index:1\">";
		echo "<line x1=$start[0] y1=$start[1] x2=$end[0] y2=$end[1] style=\"stroke:black;stroke-width:2px\" />";
		echo "</svg>";
	}
	
	function drawLineToParent($array, $index, $PositionArray) {
		$childPos = $PositionArray[$index];
		$parentPos = $PositionArray[floor(($index - 1) / 2)];
		
		drawLine([$childPos[0] + 150, $childPos[1] + 15], [midpoint($childPos[0] + 150, $parentPos[0]), $childPos[1] + 15]); //Draw Horizontal Line halfway between end of child to beginning of parent
		drawLine([midpoint($childPos[0] + 150, $parentPos[0]), $childPos[1] + 15], [midpoint($childPos[0] + 150, $parentPos[0]), $parentPos[1] + 15]); //Vertical Line to parent's height
		drawLine([midpoint($childPos[0] + 150, $parentPos[0]), $parentPos[1] + 15], [$parentPos[0], $parentPos[1] + 15]); //Draw Horizontal Line the rest of the way to Parent
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
?>
<div class=".class"></div>

<form action="index.php" method="post">
<p>Nama Turnamen : <input type="text" name="nama"></p>
        <p>Tipe Turnamen :
            <select name="tipe">
                <option value="single">Single elimination</option>
                <option value="double">Double elimination</option>
                <option value="robin">Round robin</option>
            </select>
        </p>
        <p>Ukuran Bracket : 
                <select name="ukuran">
                        <option value="names">Use number of participants provided below</option>
                        <option value="size">Select the size for a blank bracket</option>
                </select>
        </p>
<h2>Tim (Satu tim per line):</h2>

<textarea rows=10 cols=15 name="Teams"><?php if($_POST) echo $_POST["Teams"]; ?></textarea> <br>
<input type="submit">
</form>
<br><br>

<?php
$BracketArray = unserialize(file_get_contents('yourfile.bin'));
$output = unserialize(file_get_contents('yourfile.bin'));
if(isset($_GET["index"])) {
	$index = $_GET["index"];
	$newscore = $_GET["value"];
	$BracketArray = unserialize(file_get_contents('yourfile.bin'));
	$BracketArray[$index][1]=$newscore;
	file_put_contents('yourfile.bin', serialize($BracketArray));
}

for( $i = 0; $i < count( $BracketArray ); $i=$i+2 )
{
		if($BracketArray[$i][1]!="" && $BracketArray[$i-1][1]!=""){
			$nilai1 = (int)$BracketArray[$i][1];
			$nilai2 = (int)$BracketArray[$i-1][1];
			if($nilai1 > $nilai2){
				$string1= $BracketArray[$i][0];
				$BracketArray[$i/2-1][0] = $string1;
				file_put_contents('yourfile.bin', serialize($BracketArray));
			}else{
				$string1 = $BracketArray[$i-1][0];
				$BracketArray[$i/2-1][0] = $string1;
				file_put_contents('yourfile.bin', serialize($BracketArray));
			}
			
		}
}

	if(isset($TeamArray)||isset($output)) {
		if(isset($_POST["nama"])){
			$nama = $_POST["nama"];
			$tipe = $_POST["tipe"];
			$ukuran = $_POST["ukuran"];	
		
		?>
		<p>Nama turnamen :<?php echo $nama ?></p>
		<p>Tipe turnamen:<?php echo $tipe ?></p>
		<p>Ukuran :<?php echo $ukuran ?></p>
		<p>Ukuran :<?php echo $ukuran ?></p>
		
		<?php
		}
			if(isset($_POST["nama"])){
				$tipe = $_POST["tipe"];
			}else{
				$tipe = "single";
			}

		if($tipe=="single"){ //For single elimination
			

			echo "<div class=\"BracketArea\" style=\"height:" . ((pow(2, getDepth($BracketArray)) - 1) * 40 + 30 + 20) . "px;width:" . (getDepth($BracketArray) * 190 + 150 + 20) . "px \">";
			$offset = 0;
			for($i = floor(count($BracketArray)/2); $i < count($BracketArray); $i++) {
				$PositionArray[$i] = [10, $offset * 40 + 10];
				$offset++;
			}
			for($i = count($BracketArray) - 1; $i >= 0; $i--) {
				if(hasChildren($BracketArray, $i))
					$PositionArray[$i] = [$PositionArray[$i*2+1][0] + 190, midpoint($PositionArray[$i*2+1][1], $PositionArray[$i*2+2][1])];
			}
				writeTeamSquareToPosition($BracketArray[0], $PositionArray[0],$BracketArray,$BracketArray[1],$BracketArray[2],$BracketArray[0][0]); //Write First one without lines
				for($i = 1; $i < count($BracketArray); $i++) {
					if($i > (floor(count($BracketArray) / 2)) and $BracketArray[$i][0] == " ") { continue; } //Don't print empty squares in the last row
					writeTeamSquareToPosition($BracketArray[$i][0], $PositionArray[$i],$BracketArray,$BracketArray[$i][1],$BracketArray[$i][2],$BracketArray[0][0]);
					drawLineToParent($BracketArray, $i, $PositionArray);
				}
			echo "</div>";
		} else if($tipe=="double"){ //For double elimination
			$rounds = log( count( $TeamArray ), 2 ) + 1;

				// round one
				for( $i = 0; $i < log( count( $TeamArray ), 2 ); $i++ )
				{
					$seeded = array( );
						foreach( $TeamArray as $competitor )
						{
						$splice = pow( 2, $i );

						$seeded = array_merge( $seeded, array_splice( $TeamArray, 0, $splice ) );
						$seeded = array_merge( $seeded, array_splice( $TeamArray, -$splice ) );
						}
					$TeamArray = $seeded;
				}

				$events = array_chunk( $seeded, 2 );

				if( $rounds > 2 )
				{
					$round_index = count( $events );

					// second round
					for( $i = 0; $i < count( $TeamArray ) / 2; $i++ )
					{
						array_push( $events, array(
						array( 'from_event_index' => $i, 'from_event_rank' => 1 ), // rank 1 = winner
						array( 'from_event_index' => ++$i, 'from_event_rank' => 1 )
						) );
					}

					$round_matchups = array( );
					for( $i = 0; $i < count( $TeamArray ) / 2; $i++ )
					{
						array_push( $round_matchups, array(
						array( 'from_event_index' => $i, 'from_event_rank' => 2 ), // rank 2 = loser
						array( 'from_event_index' => ++$i, 'from_event_rank' => 2 )
						) );
					}
					$events = array_merge( $events, $round_matchups );

					for( $i = 0; $i < count( $round_matchups ); $i++ )
					{
						array_push( $events, array(
						array( 'from_event_index' => $i + count( $TeamArray ) / 2, 'from_event_rank' => 2 ),
						array( 'from_event_index' => $i + count( $TeamArray ) / 2 + count( $TeamArray ) / 2 / 2, 'from_event_rank' => 1 )
						) );
					}
				}

				if( $rounds > 3 )
				{
				// subsequent rounds
				for( $i = 0; $i < $rounds - 3; $i++ )
				{
					$round_events = pow( 2, $rounds - 3 - $i );
					$total_events = count( $events );

					for( $j = 0; $j < $round_events; $j++ )
					{
						array_push( $events, array(
						array( 'from_event_index' => $j + $round_index, 'from_event_rank' => 1 ),
						array( 'from_event_index' => ++$j + $round_index, 'from_event_rank' => 1 )
						) );
					}

					for( $j = 0; $j < $round_events; $j++ )
					{
						array_push( $events, array(
						array( 'from_event_index' => $j + $round_index + $round_events * 2, 'from_event_rank' => 1 ),
						array( 'from_event_index' => ++$j + $round_index + $round_events * 2, 'from_event_rank' => 1 )
						) );
					}

					for( $j = 0; $j < $round_events / 2; $j++ )
					{
						array_push( $events, array(
						array( 'from_event_index' => $j + $total_events, 'from_event_rank' => 2 ),
						array( 'from_event_index' => $j + $total_events + $round_events / 2, 'from_event_rank' => 1 )
						) );
					}

					$round_index = $total_events;
				}

				}

				if( $rounds > 1 )
				{
				// finals
					array_push( $events, array(
					array( 'from_event_index' => count( $events ) - 3, 'from_event_rank' => 1 ),
					array( 'from_event_index' => count( $events ) - 1, 'from_event_rank' => 1 )
					) );
				}


				echo '<pre>' , var_dump($events) , '</pre>';
				
		} else if($tipe=="robin"){ //for round robin
			$leng=sizeof($TeamArray); //get array size
			$firstHalf=0;
			$lastHalf=$leng-1;

			$isHome=true;
			for ($t=0; $t <$leng-1 ; $t++) { 
				for ($i=0; $i < $leng/2; $i++) {
					$z = $t+1;
					if ($i==0){
						if($isHome){ //Home
							?>
							<table>
							<tr><th style="background-color:black;color:white;" colspan="3">Ronde <?php echo $z?><th></tr>
							<tr>
								<td style="background-color:#FF7F50;color:white;">Home</td>
								<td style="background-color:#FF7F50;color:white;text-align: center; vertical-align: middle;" rowspan="<?php echo $leng ;?>">VS</td>
								<td style="background-color:#FF7F50;color:white;">Away</td>
							</tr>
							<tr style="background-color:#A9A9A9;color:white;">
								<td>
									<?php echo $TeamArray[$i]; ?>
								</td>
								<td>
									<?php echo $TeamArray[$lastHalf-$i];?>
								</td>
							</tr>
							<?php
							$isHome=false;
						}else{ //Away
							?>
							<table>
							<tr>
								<th style="background-color:black;color:white;" colspan="3">Ronde <?php echo $z?><th>
							</tr>
							<tr>
								<td style="background-color:#FF7F50;color:white;">Home</td>
								<td style="background-color:#FF7F50;color:white;text-align: center; vertical-align: middle;" rowspan="<?php echo $leng ;?>">VS</td>
								<td style="background-color:#FF7F50;color:white;">Away</td>
							</tr>
							<tr style="background-color:#A9A9A9;color:white;">
								<td>
									<?php echo $TeamArray[$lastHalf-$i]; ?>
								</td>
								<td>
									<?php echo $TeamArray[$i]; ?>
								</td>
							</tr>
							<?php
							$isHome=true;
						}	
					}else{
						if($i%2==0){
							?>
							<tr style="background-color:#A9A9A9;color:white;">
								<td>
									<?php echo $TeamArray[$i]; ?>
								</td>
								<td><?php echo $TeamArray[$lastHalf-$i];?></td>
							</tr>
							<?php if ($i==$leng/2){ ?>
							</table>
							<?php 
							}else{
								?>
								</br></br>
								<?php
							}
							?>
							
							<?php
						}else{
							?>
								<tr style="background-color:#A9A9A9;color:white;">
									<td>
										<?php echo $TeamArray[$lastHalf-$i];?>
									</td>
									<td>
										<?php echo $TeamArray[$i];?>
									</td>
								</tr>
							<?php	
						}
						
					
					}


				}
				/*now rotate the array. For this first insert the last item into postion 1*/
				array_splice( $TeamArray, 1, 0, $TeamArray[$leng-1]);
				/*now pop up the last element*/
				array_pop($TeamArray);
				
			}


			// foreach ($TeamArray as $home) {
			// 	foreach ($TeamArray as $away) {
			// 		if ($home === $away) {
			// 		   continue;
			// 		}
			// 		echo 'Home Team => '.$home.' vs '.$away.' <= Away Team';
			// 	} 
			// }
		}
	}
?>


<?php include 'footer.php' ?>