<?php include 'header.php' ?>
<?php include 'function.php' ?>

<div class=".class"></div>

<form action="index.php" method="post">
	<div class="form-group">
		<label for="exampleFormControlInput1">Nama turnamen</label>
		<input name="nama" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Ex. Bojongsoang Cup">
	</div>
	<div class="form-group">
		<label for="exampleFormControlSelect1">Tipe Turnamen</label>
		<select name="tipe" class="form-control" id="exampleFormControlSelect1">
		<option value="single">Single elimination</option>
        <option value="double">Double elimination</option>
        <option value="robin">Round robin</option>
		</select>
	</div>
	<div class="form-group">
		<label for="exampleFormControlSelect1">Ukuran Bracket</label>
		<select name="ukuran" class="form-control" id="exampleFormControlSelect1">
          <option value="names">Use number of participants provided below</option>
          <option value="size">Select the size for a blank bracket</option>
        </select>
	</div>
	<div class="form-group">
		<label for="exampleFormControlTextarea1">Tim (Satu tim per line):</label>
		<textarea class="form-control" id="exampleFormControlTextarea1" rows=10 cols=15 name="Teams"><?php if($_POST) echo $_POST["Teams"]; ?></textarea>
	</div>
<input class="btn btn-primary btn-lg btn-block"type="submit">
</form>
<br><br>

<?php  
  
$output = unserialize(file_get_contents('yourfile.bin'));

$i=count( $output );
$i=$i/2;
$i = round($i);
$j = $i/2;

if(isset($_GET["index"])) {
	$BracketArray_index = unserialize(file_get_contents('yourfile.bin'));
	$index = $_GET["index"];
	$index1 = $_GET["index1"];
	$indexbaru = $index/2-1;
	$newscore = $_GET["score"];
	$newscore1 = $_GET["score1"];
	$BracketArray = unserialize(file_get_contents('yourfile.bin'));
	$BracketArray[$index][1]=$newscore;
	$BracketArray[$index1][1]=$newscore1;
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
$output = unserialize(file_get_contents('yourfile.bin'));
			if($output[0][0]!=" "){
				?>
				<script type="text/javascript">
				  swal({
					title: 'Congratulations',
					html:
						'<h2>The winner is '+'<?php echo $output[0][0];?>'+'</h2>',
					preConfirm: function () {
						return new Promise(function (resolve) {
						resolve([
						])
						})
					},
					onOpen: function () {
						$('#swal-input1').focus()
					}
					}).then(function (result) {
					}).catch(swal.noop)
				</script>
				<?php
			}
			echo "<div id=\"div1\" class=\"card border-success mb-3\" style=\"text-align:center;padding: 10%;height:" . ((pow(2, getDepth($BracketArray)) - 1) * 40 + 30 + 20) . "px;width:100% \">";
			?>
			
			<div id="div2" style="display:inline-block;" class="card-body text-success">
			<?php
			$offset = 0;
			for($i = floor(count($BracketArray)/2); $i < count($BracketArray); $i++) {
				$PositionArray[$i] = [10, $offset * 40 + 10];
				$offset++;
			}
			for($i = count($BracketArray) - 1; $i >= 0; $i--) {
				if(hasChildren($BracketArray, $i))
					$PositionArray[$i] = [$PositionArray[$i*2+1][0] + 190, midpoint($PositionArray[$i*2+1][1], $PositionArray[$i*2+2][1])];
			}
				writeTeamSquareToPosition($BracketArray[0][0], $PositionArray[0],$BracketArray,$BracketArray[0][1],$BracketArray[0][2],$BracketArray[0][0]); //Write First one without lines
				for($i = 1; $i < count($BracketArray); $i++) {
					if($i > (floor(count($BracketArray) / 2)) and $BracketArray[$i][0] == " ") { continue; } //Don't print empty squares in the last row
					writeTeamSquareToPosition($BracketArray[$i][0], $PositionArray[$i],$BracketArray,$BracketArray[$i][1],$BracketArray[$i][2],$BracketArray[0][0]);
					drawLineToParent($BracketArray, $i, $PositionArray,$BracketArray[$i][2]);
				}
			?>
					</div>
			</div>
			<button type="button" class="btn btn-primary" onclick="window.print();">Print this Bracket</button>
			<?php
			// echo '<pre>' , var_dump($BracketArray) , '</pre>';
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
		}
	}
?>


<?php include 'footer.php' ?>