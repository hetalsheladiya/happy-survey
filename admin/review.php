<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/libs/css/style.css">
	<link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">	
	<title>Happy Survey - review</title>
	<!-- Favicon -->
	<link rel="icon" href="assets/images/logo@3x.png">  

	<style>
	html,
	body {
		height: 100%;
	}

	body {
		display: -ms-flexbox;
		display: flex;
		-ms-flex-align: center;
		align-items: center;
		padding-top: 40px;
		padding-bottom: 40px;
	}
	.card{
	    margin-bottom:60px;
	}
	.hideDiv{display: none;}
	.demo-table {width: 100%;border-spacing: initial;margin: 20px 0px;word-break: break-word;table-layout: auto;line-height:1.8em;color:#333;}
	.demo-table th {background: #999;padding: 5px;text-align: left;color:#FFF;}
	.demo-table td {border-bottom: #f0f0f0 1px solid;background-color: #ffffff;padding: 5px;}
	.demo-table td div.feed_title{text-decoration: none;color:#00d4ff;font-weight:bold;}
	.demo-table ul{margin: 6px 8px; font-size: 15px; display: block;padding: 5px;}
	.demo-table li{cursor:pointer;list-style-type: none;display: inline-block;color: #fff;text-shadow: 0 0 1px #666666;font-size:29px;margin: 7px 1px;text-align: -webkit-right;
					text-shadow: 0 0 2px #F48F0A;}
	.demo-table .highlight, .demo-table .selected {color:#FFCC16;text-shadow: 0 0 1px #F48F0A;}
	#cover-spin {
        position:fixed;
        width:100%;
        left:0;right:0;top:0;bottom:0;
        background-color: rgba(255,255,255,0.7);
        z-index:9999;
        display:none;
    }

    @-webkit-keyframes spin {
      from {-webkit-transform:rotate(0deg);}
      to {-webkit-transform:rotate(360deg);}
    }

    @keyframes spin {
      from {transform:rotate(0deg);}
      to {transform:rotate(360deg);}
    }

    #cover-spin::after {
        content:'';
        display:block;
        position:absolute;
        left:48%;top:40%;
        width:40px;height:40px;
        border-style:solid;
        border-color:#FFC750;
        border-top-color:transparent;
        border-width: 4px;
        border-radius:50%;
        -webkit-animation: spin .8s linear infinite;
        animation: spin .8s linear infinite;
    }
</style>
<script type="text/javascript">
	function getprofile(){
        $(".alert").remove();
        var userId = url.searchParams.get("u");
        $.ajax({
            url: server+"/profile.php?userId= " + userId,
            type: 'GET',
            contentType: 'application/json',
            success: function(response){
                
                var data = response.profile;                                 
                
                if(data.logo != ''){
                    $("#userImage").attr('src', '../'+data.logo );                    
                }               
                     
            },
            error: function(error){                   
            }

        });
    }
</script>
</head>
<body style="background: #f6f4ef" onload="getprofile()">
	<div id="cover-spin"></div>
	<!-- ============================================================== -->
	<!-- REVIEW page  -->
	<!-- ============================================================== -->
	<div class="splash-container" >
		<div class="card " id="ratingDiv" style="display: block;">
			<div class="card-header text-center">
				<a href="#.">
					<img class="user-avatar-xl" src="assets/images/logo@3x.png" alt="logo" id="userImage">
				</a>
				<span class="splash-description"></span>
				<div class="showemoji" style="margin-top: 12px;">
					<input type="hidden" name="emojis" id="emojis">
					<img src="assets/images/sad@1x.png"
						 onclick="$('.hideDiv').hide();$('.firstdiv').show();$('#emojis').val(0);" 
						 class="user-avatar-lg1 emoji-sad" name="emoji" value="0" style="margin-left: auto;"/> 

					<img src="assets/images/neutral@1x.png" 
						 onclick="$('.hideDiv').hide();$('.seconddiv').show();$('#emojis').val(1);" 
						 class="user-avatar-lg1 emoji-neautral" name="emoji" value="1" />

					<img src="assets/images/happy@1x.png" 
						 onclick="$('.hideDiv').hide();$('.thirddiv').show();$('#emojis').val(2);" 
						 class="user-avatar-lg1 emoji-happy" name="emoji" value="2" />                      
				</div>
			</div>


			<div class="hideDiv firstdiv">
				<div class="demo-table" id="categoryDiv">
					<?php 
					require_once './../dbconfig.php';
					require_once './../classes/category.php';
					$userId = $_GET['u'];
					$storeId = $_GET['s'];
					$category = new Category();
					$list = $category->getCategoryWithStore($userId, $storeId);
					$i = 1;
					foreach($list as $categoryValue)
					{
						$categoryValue = (array)$categoryValue;
						?>
						<div id="tutorial-<?php echo $categoryValue['id'].'001'; ?>" class="row">
							<input type="hidden" class="ratings" name="rating[]" id="rating" value="0" />
							<input type="hidden" class="ratingsid" name="ratings[]" value="<?php echo $categoryValue['id']; ?>" />
                        <div style="width: 30%;padding-left: 37px;display: inline-block;padding-top: 12px;font-size: 15px;text-transform:capitalize"><?php echo $categoryValue['name']?></div>
							<ul onMouseOut="resetRating(<?php echo $categoryValue['id'].'001'; ?>);" style="margin: 0px;width: 68%;display: inline-block;" align="center">
								<li onmouseover="highlightStar(this,<?php echo $categoryValue['id'].'001'; ?>);" 
									onmouseout="removeHighlight(<?php echo $categoryValue['id'].'001'; ?>);"
									onClick="addRating(this,<?php echo $categoryValue['id'].'001'; ?>);">&#9733;
								</li>  
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id'].'001'; ?>);" 
									onmouseout="removeHighlight(<?php echo $categoryValue['id'].'001'; ?>);"		
									onClick="addRating(this,<?php echo $categoryValue['id'].'001'; ?>);">&#9733;
								</li>  
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id'].'001'; ?>);" 
									onmouseout="removeHighlight(<?php echo $categoryValue['id'].'001'; ?>);"		
									onClick="addRating(this,<?php echo $categoryValue['id'].'001'; ?>);">&#9733;
								</li>  
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id'].'001'; ?>);"
									 onmouseout="removeHighlight(<?php echo $categoryValue['id'].'001'; ?>);"      	
									 onClick="addRating(this,<?php echo $categoryValue['id'].'001'; ?>);">&#9733;
								</li>  
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id'].'001'; ?>);"
									 onmouseout="removeHighlight(<?php echo $categoryValue['id'].'001'; ?>);"      	
									 onClick="addRating(this,<?php echo $categoryValue['id'].'001'; ?>);">&#9733;
								</li>
							</ul>
						</div>
						<?php
						$i++;
					}
					?>                                
				</div> 
				<div class="card-footer bg-white p-0 text-center">					
					<div class="card-footer-item card-footer-item-bordered">
						<button class="btn reviewbtn" data-toggle="modal" data-target="#commentmodal" >SUBMIT</button>
					</div>                
				</div>             
			</div>
			<!-- Neautral emoji -->
			<div class="hideDiv seconddiv">
				<div class="demo-table" id="categoryDiv">
					<?php 
					require_once './../dbconfig.php';
					require_once './../classes/category.php';
					$userId = $_GET['u'];
					$storeId = $_GET['s'];
					$category = new Category();
					$list = $category->getCategoryWithStore($userId, $storeId);
					$i = 1;
					foreach($list as $categoryValue)
					{
						$categoryValue = (array)$categoryValue;
						?>
						<div id="tutorial-<?php echo $categoryValue['id'].'002'; ?>" class="row">
							<input type="hidden" class="ratings1" name="rating[]" id="rating" value="0" />
							<input type="hidden" class="ratingsid1" name="ratings[]" value="<?php echo $categoryValue['id']; ?>" />
							<div style="width: 30%;padding-left: 37px;display: inline-block;padding-top: 12px;font-size: 15px;text-transform: capitalize;"><?php echo $categoryValue['name']?></div>
							<ul onMouseOut="resetRating(<?php echo $categoryValue['id'].'002'; ?>);" style="margin: 0px;width: 68%;display: inline-block;" align="center">
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id'].'002'; ?>);" onmouseout="removeHighlight(<?php echo $categoryValue['id'].'002'; ?>);"
									 onClick="addRating(this,<?php echo $categoryValue['id'].'002'; ?>);">&#9733;</li>  
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id'].'002'; ?>);" onmouseout="removeHighlight(<?php echo $categoryValue['id'].'002'; ?>);"
									 onClick="addRating(this,<?php echo $categoryValue['id'].'002'; ?>);">&#9733;</li>  
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id'].'002'; ?>);" onmouseout="removeHighlight(<?php echo $categoryValue['id'].'002'; ?>);"
									 onClick="addRating(this,<?php echo $categoryValue['id'].'002'; ?>);">&#9733;</li>  
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id'].'002'; ?>);" onmouseout="removeHighlight(<?php echo $categoryValue['id'].'002'; ?>);"
									 onClick="addRating(this,<?php echo $categoryValue['id'].'002'; ?>);">&#9733;</li>  
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id'].'002'; ?>);" onmouseout="removeHighlight(<?php echo $categoryValue['id'].'002'; ?>);"
									 onClick="addRating(this,<?php echo $categoryValue['id'].'002'; ?>);">&#9733;</li>
							</ul>
						</div>
						<?php
						$i++;
					}
					?>                                  
				</div> 
				<div class="card-footer bg-white p-0 text-center">
					<div class="card-footer-item card-footer-item-bordered">
						<button class="btn reviewbtn" data-toggle="modal" data-target="#commentmodal">SUBMIT</button>
					</div>                
				</div> 
			</div>

			<!-- Happy emoji -->
			<div class="hideDiv thirddiv">
				<div class="demo-table" id="categoryDiv">
					<?php 
					require_once './../dbconfig.php';
					require_once './../classes/category.php';
					$userId = $_GET['u'];
					$storeId = $_GET['s'];
					$category = new Category();
					$list = $category->getCategoryWithStore($userId, $storeId);
					$i = 1;
					foreach($list as $categoryValue)
					{
						$categoryValue = (array)$categoryValue;
						?>
						<div id="tutorial-<?php echo $categoryValue['id']; ?>" class="row">
							<input type="hidden" class="ratings2" name="rating[]" id="rating" value="0" />
							<input type="hidden" class="ratingsid2" name="ratings[]" value="<?php echo $categoryValue['id']; ?>" />
							<div style="width: 30%;padding-left: 37px;display: inline-block;padding-top: 12px;font-size: 15px;text-transform: capitalize;"><?php echo $categoryValue['name']?></div>
							<ul onMouseOut="resetRating(<?php echo $categoryValue['id']; ?>);" style="margin: 0px;width: 68%;display: inline-block;" align="center">
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id']; ?>);" onmouseout="removeHighlight(<?php echo $categoryValue['id']; ?>);"
									 onClick="addRating(this,<?php echo $categoryValue['id']; ?>);">&#9733;</li>  
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id']; ?>);" onmouseout="removeHighlight(<?php echo $categoryValue['id']; ?>);"
									 onClick="addRating(this,<?php echo $categoryValue['id']; ?>);">&#9733;</li>  
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id']; ?>);" onmouseout="removeHighlight(<?php echo $categoryValue['id']; ?>);"
									 onClick="addRating(this,<?php echo $categoryValue['id']; ?>);">&#9733;</li>  
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id']; ?>);" onmouseout="removeHighlight(<?php echo $categoryValue['id']; ?>);"
									 onClick="addRating(this,<?php echo $categoryValue['id']; ?>);">&#9733;</li>  
								<li  onmouseover="highlightStar(this,<?php echo $categoryValue['id']; ?>);" onmouseout="removeHighlight(<?php echo $categoryValue['id']; ?>);"
									 onClick="addRating(this,<?php echo $categoryValue['id']; ?>);">&#9733;</li>
							</ul>
						</div>
						<?php
						$i++;
					}
					?>                                  
				</div> 
				<div class="card-footer bg-white p-0 text-center">
					<div class="card-footer-item card-footer-item-bordered">
						<button class="btn reviewbtn" data-toggle="modal" data-target="#commentmodal">SUBMIT</button>                            
					</div>                
				</div> 
			</div>

		</div>

	<!-- ============================================================== -->
	<!-- Success MESSAGE  -->
	<!-- ============================================================== -->
		<div class="text-center" id="messageDiv" style="display: none;">
		    <img src="assets/images/success.png" height="80" width="80" style="margin-bottom: 25px;">
		    <h2 style="font-size: 25px;"><b>Thank You for Your Feedback</b></h2>		    
		</div>		
		<div class="text-center">					
			<div class="card-footer-item card-footer-item-bordered">
				<button class="btn btn-brand" id="googleReviewBtn" style="display: none;">Review us on google</button>
			</div>                
		</div>
		
	</div>
	<!-- ============================================================== -->
    <!-- MODAl -->
    <!-- ============================================================== -->
	<div class="modal fade" id="commentmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thanks for your feedback</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>                    
                </div>               
                <div class="modal-body"> 
                 	<h4 id="msgHeader"></h4>                                                               
                    <label for="message"><b>Comment</b></label>                                                    
                    <textarea class="form-control form-control-lg" placeholder="Enter your message" id="comment"></textarea>                             
                </div>
                <div class="modal-body">                                                                
                    <label for="email"><b>Name</b></label>
                    <input type="text" class="form-control form-control-lg" placeholder="Name" id="name">                                              
                </div>
                <div class="modal-body">                                                                
                    <label for="rating"><b>Phone Number</b></label>                                                    
                    <input type="tel" class="form-control form-control-lg" placeholder="Phone Number" id="phone">                             
                </div>
                <div class="modal-body">                                                                
                    <label for="rating"><b>Email</b></label>                                                    
                    <input type="email" class="form-control form-control-lg" placeholder="Email" id="email">                             
                </div>
                <div class="modal-footer">
                    <a href="#" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-brand" id="saveCommentBtn">Submit </a>                   
                </div>
            </div>
        </div>
    </div>
    
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <!-- <div class="footer text-center" style="background: #f6f4ef;font-size:16px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                   All rights reserved. Powered by <a href="https://hpysrvy.com" target="_blank">HappySurvey</a>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="text-md-right footer-links d-none d-sm-block">
                        <a href="javascript: void(0);">About</a>
                        <a href="javascript: void(0);">Support</a>
                        <a href="javascript: void(0);">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
	<!-- jquery 3.3.1 -->
	<!-- bootstap bundle js -->
	<script src="./assets/vendor/jquery/jquery-3.3.1.min.js"></script>
	<script src="./assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>	
	<script src="./assets/libs/js/rating.js"></script> 

</body>
</html>
