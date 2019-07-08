		</div> <!-- TextBody -->
	</div> <!-- table -->
	<!-- <div class="footer">Tournament Bracket generator</div> -->
	
</div> <!-- Table -->
</body>
<script type="text/javascript">
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