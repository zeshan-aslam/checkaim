<?php $postid = isset($_GET['cid']) ? $_GET['cid'] : -1; ?>
							 <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">                                   
                                    </p>
                                </div>
                                <div class="card-body all-icons">
                                    <div class="row">
                                        <div class="font-icon-list col-lg-8  ">
                                            <div class="font-icon-detail">


                                   <div class="row">
								   <div class="col-lg-2"></div>
								   <div class="col-lg-3">
											<!-- Trigger the Modal -->
                                   <a href="https://avazai.com/StandardTemplate.php" target="_blank"><img src="https://avazai.com/img/standardtemplates.png" alt="Standard-Template" style="width:100%;max-width:300px"></a>

                                     <!-- The Modal -->
                                 <div id="myModal" class="modal">

                                  <!-- The Close Button -->
                                  <span class="close">&times;</span>

                                <!-- Modal Content (The Image) -->
                                    <img class="modal-content" id="img-01">

                               <!-- Modal Caption (Image Text) -->
                                <div id="caption"></div>
                                      </div> 
								  </div>
						                  <div class="col-lg-5">
											
                                                <a href="<?php echo LEADURL;?>index.php/?Act=standard&campid=<?=$postid?>"><b>Standard Template.<br>For quick and easy lead generation!</b></a>
                                            </div>
                                        </div>                                   
                                    </div>
								</div>
                           </div>
									<div class="row">
                                        <div class="font-icon-list col-lg-8 ">
                                            <div class="font-icon-detail">
											<div class="row">
											<div class="col-lg-2"></div>
                                               <div class="col-lg-3">
											<!-- Trigger the Modal -->
                                   <a href="https://avazai.com/CustomTemplate.php" target="_blank"><img src="https://avazai.com/img/customtemplate.png" alt="Custom-Template" style="width:100%;max-width:300px"></a>

                                     <!-- The Modal -->
                                 <div id="myModal2" class="modal">

                                  <!-- The Close Button -->
                                   <span class="close1">&times;</span>
								   
								   
                                <!-- Modal Content (The Image) -->
                                    <img class="modal-dailog" id="img-02">

                               <!-- Modal Caption (Image Text) -->
                                <div id="caption2"></div>
                                      </div> 
											
											</div>
											   
											   <div class="col-lg-5">
                                               <a href="<?php echo LEADURL;?>index.php/?Act=custom&campid=<?=$postid?>"><b>Custom Designed Template. <br>We can design one for you!</b>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
					<div class="row">

					</div>
                   
                </div>
            </div>

		<script>	
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("Standard-template");
var modalImg = document.getElementById("img-01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
   modal.style.display = "none";
} 

</script>

<script>	
// Get the modal
var modal = document.getElementById("myModal2");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("custom-template");
var modalImg = document.getElementById("img-02");
var captionText = document.getElementById("caption2");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close1")[0];

// When the user clicks on <span> (x), close the modal
 span.onclick = function() {
   modal.style.display = "none";
} 

</script>
<link rel="stylesheet" href="css/style.css">