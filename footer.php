		</div> <!-- TextBody -->
	</div> <!-- table -->
	<!-- <div class="footer">Tournament Bracket generator</div> -->
	
</div> <!-- Table -->
</body>
<script type="text/javascript">
$(document).ready(function() {
	// textFit(document.querySelector("h5"));
	// jQuery("h5").fitText(0.38);
	// $('h5').quickfit();
        });
function test(id,id1,tim,tim1){
	// alert("bisa nih gan");
		swal({
		title: 'Input skor',
		showCancelButton: true,
		html:
			'<input id="swal-input1" class="swal2-input" placeholder="Skor tim '+tim+'">' +
			'<input id="swal-input2" class="swal2-input" placeholder="Skor tim '+tim1+'">',
		preConfirm: function () {
			return new Promise(function (resolve) {
			resolve([
				skor1 = $('#swal-input1').val(),
				skor2 = $('#swal-input2').val()
			])
			})
		},
		onOpen: function () {
			$('#swal-input1').focus()
		}
		}).then(function (result) {
		getnilai(id,id1,tim,tim1);
		}).catch(swal.noop)

}
function winner(){
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
		
}
function getnilai(id,id1,tim,tim1){
	$.ajax({
						type:'GET',
     					 url:'index.php',
    					 data:{action:"en"},
						success: function () {
							window.location.href = "index.php?index="+id+"&index1="+id1+"&score="+skor1+"&score1="+skor2;
						},
						error: function () {
							alert("ajax error ");
							// OnError(cartObject.productID)
						},
						complete: function () {
						}
						});  // end Ajax   

					
}
function sweet (name,index,id){
					var txt;
					var person = prompt("Insert Score for "+name+" index "+id+" :", "0");
					if (person == null || person == "") {
						txt = "User cancelled the prompt.";
					} else {
						txt = "Hello " + person + "! How are you today?";

					$.ajax({
						type:'GET',
     					 url:'index.php',
    					 data:{action:"en"},
						success: function () {
							alert("ajax success ");
							window.location.href = "index.php?index="+id+"&value="+person;
						},
						error: function () {
							alert("ajax error ");
							// OnError(cartObject.productID)
						},
						complete: function () {
						}
						});  // end Ajax   

					}
				}
</script>



</html>