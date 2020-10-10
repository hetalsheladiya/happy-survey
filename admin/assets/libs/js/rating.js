    var u = window.location.href;
    var ar = u.split('/');
    var server = ar[0]+"//"+window.location.hostname+"/hpysrvy.com";
    var url_string = window.location.href; 
    var url = new URL(url_string);
    var userId = url.searchParams.get("u");
    var storeId = url.searchParams.get("s");
    var googleLink = "";
    var customMsg = "";
    var categoryArray = [];
    var rr = [];
    var rrid = [];
    var ii = iii = 0;
    var surveyId = 0;
    getRedirectCustomLink(userId, storeId);				
    
    var sad = $(".user-avatar-lg1.emoji-sad");
    var neautral = $(".user-avatar-lg1.emoji-neautral");
    var happy = $(".user-avatar-lg1.emoji-happy");
    
    // var rating = rat;
    function getRedirectCustomLink(userId, storeId){
    	$url = server+"/getcustomlink.php";
    	$data = {'userId' : userId, 'storeId' : storeId};
    	$.get($url, $data, function(response){
    		var data = response.data;
            var fields = response.fieldData;
    		if(response.status == 'success'){
    			googleLink =  data.link;
    			(data.message == null || data.message == "") ?	customMsg = 'What can we improve?' : customMsg = data.message;			    
                (data.welcomeMsg == null || data.welcomeMsg == '') ? welcomeMsg = '' : welcomeMsg = data.welcomeMsg;
                (fields.namefield == 0) ? $("#name").attr("placeholder", "Name (optional)") : "";
                (fields.phonefield == 0) ? $("#phone").attr("placeholder", "Phone Number (optional)") : "";
                (fields.emailfield == 0) ? $("#email").attr("placeholder", "Email (optional)") : "";
                (fields.commentfield == 0) ? $("#comment").attr("placeholder", "Enter your message (optional)") : "";

                $(".splash-description").text(welcomeMsg);
                $("#msgHeader").text(customMsg);
    		}
    	})
    }
    

    $("#googleReviewBtn").on('click', function(){            
        if(googleLink == null || googleLink == ""){
            $("#googleReviewBtn").css('display', 'none');
        }
        else{
            window.location.replace(googleLink);
        }
    })

    $(function(){
    	var rat = 0;
    	// var comment = "";	
    	
    	$(".user-avatar-lg1").on('click', function(){
    		if($(this).attr("name") == 'emoji'){
    			rat = $("#emojis").val();
    			if(rat == 0){
    				$(this).css({'border':'red solid 1.5px','padding': '2.5px 2.5px 3px', 'border-radius':'40px', 'height':'68px', 'width': '68px'});	
    				$(neautral).css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
    				$(happy).css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
    			}
    			if(rat == 1){
    				$(this).css({'border':'rgb(255, 151, 3) solid 1.5px','padding': '2.5px 2.5px 3px', 'border-radius':'40px', 'height':'68px', 'width': '68px'});
    				$(sad).css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
    				$(happy).css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
    			}	
    			if(rat == 2){
    				$(this).css({'border':'rgb(134, 209, 2) solid 1.5px','padding': '2.5px 2.5px 3px', 'border-radius':'40px', 'height':'68px', 'width': '68px'});
    				$(sad).css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
    				$(neautral).css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
    			}		
    		}
    	})
    	
    	$('.reviewbtn').on('click', function(){	
    		categoryArray = [];
            rr = [];
            rrid = [];

    		if(rat == 0){    			
    			$('.ratings').each(function(){
    				rr.push($(this).val());
    			});
    			var ii = 0;
    			$('.ratingsid').each(function(){
    				rrid.push($(this).val());
    			});
    			for (var i = 0; i< rr.length; i++) {
    				var cataray = {'id':rrid[i],'rating':rr[i]};
    				categoryArray.push(cataray);
    			}
                // sendReview(rat);
    		}else if(rat == 1) {
    			
    			$('.ratings1').each(function(){
    				rr.push($(this).val());
    			});
    			var ii = 0;
    			$('.ratingsid1').each(function(){
    				rrid.push($(this).val());
    			});
    			for (var i = 0; i< rr.length; i++) {
    				var cataray = {'id':rrid[i],'rating':rr[i]};
    				categoryArray.push(cataray);
    			}
                // sendReview(rat);
    		}
    		
   //  		if(rat <= 1){
   //  //             $('button.reviewbtn').attr('data-toggle','modal');
			// 	// $('button.reviewbtn').attr('data-target','#commentmodal');
			// }
			// else{
			// 	// $("#comment").val('');				
			// 	// $('button').removeAttr( "data-toggle" );
			// 	// $('button').removeAttr( "data-target" );
			// 	sendReview(rat);
			// }
    			if(rat == 2){    				
    				
    				$('.ratings2').each(function(){
    					rr.push($(this).val());
    				});
    				var ii = 0;
    				$('.ratingsid2').each(function(){
    					rrid.push($(this).val());
    				});
    				for (var i = 0; i < rr.length; i++) {
    					var cataray = {'id':rrid[i],'rating':rr[i]};
    					categoryArray.push(cataray);
    				}
                    // sendReview(rat);
    				
    				// $.ajax({
    				// 	url: server+"/savesurvey.php",
    				// 	type: 'GET',
    				// 	data: {'userId': userId, 'storeId': storeId, 'isHappy': rat, 'rating': JSON.stringify(categoryArray)},
    				// 	contentType: 'application/json',
    				// 	dataType: 'json',
    				// 	async: true,
    				// 	success: function(response) { 
    
    				// 		if(response.status == 'success'){
    				// 			// if(rating > 3){
        //                             if(googleLink == null || googleLink == ""){
        //                                 googleLink = "alert.html";
        //                                 window.location.replace(googleLink);
        //                             }
        //                             else{
        //                                 Swal.fire({
        //                                 type: "success",
        //                                 title: 'Thank you for your feedback',
        //                                 // text: `You rated us ${rat}/5`,                 
        //                                 buttons: true,
        //                                 confirmButtonText: 'Review us on google',
        //                                 }).then(
        //                                 function(){
        //                                     window.location.replace(googleLink);
        //                                 })
        //                             }
    								
    				// 			}
    				// 		},
    				// 		error: function(data){
    			 //            //console.log('error');
    			 //        }
    			 //    })
    			}
                $URL = server+"/savesurvey.php";
                $data = {'userId': userId, 'storeId': storeId, 'isHappy': rat, 'rating': JSON.stringify(categoryArray)};
                $.post($URL, $data, function(response){
                    if(response.status == 'success'){
                        var d = response.data;
                        surveyId = d.id;                        
                    } 
                })                
    			
    		})
    
    	$('#saveCommentBtn').click(function(){
            sendReview(rat);
            // $('.alert').remove();
            // var comment = $("#comment").val();
            // var name = $("#name").val();
            // var phonenumber = $("#phone").val();
            // var email = $("#email").val();

            // if(phone == ''){
            //     $('<div id="alert" class="alert alert-warning" role="alert">Please give your phone number<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertBefore(".modal-content");
            //     return false;
            //     $('#phone').focus();
            //     // Swal.fire('', "Please give Your Phone number", "info");
            // }
            // else if(name == ''){
            //     $('<div id="alert" class="alert alert-warning" role="alert">Please give your name<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertBefore(".modal-content");
            //     return false;
            //     $("#name").focus();
            //     // Swal.fire('', "Please give your name", "info");
            // }
            // $URL = server+"/savesurvey.php";
            // $data = {'userId': userId, 'storeId': storeId, 'isHappy': rat, 'comment': comment, 
            //             'name': name, 'phonenumber': phonenumber, 'email': email, 'rating': JSON.stringify(categoryArray)};
            // $.post($URL, $data, function(){
            //     if(response.status == 'success'){
            //         if(rat == 2){
            //             window.location.replace("alertwithreviewbtn.html");
            //         }
            //         else{
            //             window.location.replace("alert.html");
            //         }                    
            //     }
            // })

            // $("#commentmodal").modal("toggle");
    		// var count = $("#comment").val().length;
    		// (count == 0) ?  Swal.fire('Please give some feedback', "", "info"): sendReview(rat);
    
    	});
    })
    
    function sendReview(rat){
        $('.alert').remove();
        
        var comment = $("#comment").val();
        var name = $("#name").val();
        var phonenumber = $("#phone").val();
        var email = $("#email").val();
        comment = comment.trim();
        // if(phonenumber == ''){
        //     $('<div id="alert" class="alert alert-warning" role="alert">Please give your phone number<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".modal-header");
        //     return false;            
        //     // Swal.fire('', "Please give Your Phone number", "info");
        // }
        // else if(name == ''){
        //     $('<div id="alert" class="alert alert-warning" role="alert">Please give your name<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".modal-header");
        //     return false;            
        //     // Swal.fire('', "Please give your name", "info");
        // }
        
        $.ajax({
            url: server+"/rating.php",
            type: 'POST',
            data: {'surveyId': surveyId, 'comment': comment, 'name': name, 'phonenumber': phonenumber, 'email': email, 'userId': userId, 'storeId': storeId},
            beforeSend: () => {
                $("#cover-spin").css('display', 'block');
            },
            success: function(response){        
                if(response.status == 'success'){
                    if(rat == 2){
                        if(googleLink == null || googleLink == ''){
                            $("#googleReviewBtn").css('display', 'none');
                        }
                        else{
                            $("#googleReviewBtn").css('display', 'block');
                        }                                            
                    }
                    $("#commentmodal").modal("toggle");
                    $("#messageDiv").css('display', 'block');
                    $("#ratingDiv").css('display', 'none');                                      
                }
                else{
                    $('<div id="alert" class="alert alert-warning" role="alert">'+response.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".modal-header");
                    return false;
                }
            },
            complete: () => {
                 $("#cover-spin").css('display', 'none');
            }
        })
    }
    // function sendReview(rat){
    // 	$('.alert').remove();
    // 	// var comment = $("#comment").val();
    // 	// $data = {'userId': userId, 'storeId': storeId, 'rating': rating};
    // 	// $URL = "http://"+server+"/survey/rating.php";
    // 	$.ajax({
    // 		url: server+"/savesurvey.php",
    // 		type: 'GET',
    // 		data: {'userId': userId, 'storeId': storeId, 'isHappy': rat, 'rating': JSON.stringify(categoryArray)},
    // 		contentType: 'application/json',
    // 		dataType: 'json',
    // 		async: true,
    // 		success: function(response) { 
    
    // 			if(response.status == 'success'){
    // 				// if(rating > 3){
    // 					Swal.fire({
    // 						type: "success",
    // 						title: 'Thank you for your feedback',
    // 						// text: `You rated us ${rat}/5`,				  
    // 						buttons: true,
    // 						confirmButtonText: 'Review us on google',
    // 					}).then(
    // 					function(){
    // 						window.location.replace(googleLink);
    // 					})				
    // 				// }
    // 				// else{
    // 				// 	$("#comment").val('');
    // 			 	// 	$('#commentmodal').modal('hide');
    // 			 	// 	Swal.fire({
    // 					//   title: 'Thank you for your feedback',
    // 					//   text: `You rated us ${rating}/5`,
    // 					//   timer: 2500,
    // 					//   onOpen: function () {
    // 					//     swal.showLoading()
    // 					//   }
    // 					// }).then(
    // 					//   function () {				  		
    // 					//   	window.location.replace("http://www.google.com");			  		
    // 					// })
    // 				// }
    
    // 			}
    // 		},
    // 		error: function(data){
    //             //console.log('error');
    //         }
    
    //     })
    // }
    
    function highlightStar(obj,id) {
    	removeHighlight(id);		
    	$('.demo-table #tutorial-'+id+' li').each(function(index) {
    		$(this).addClass('highlight');
    		if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
    			return false;	
    		}
    	});
    }
    
    function removeHighlight(id) {
    	$('.demo-table #tutorial-'+id+' li').removeClass('selected');
    	$('.demo-table #tutorial-'+id+' li').removeClass('highlight');
    }
    
    function addRating(obj,id) {
    	$('.demo-table #tutorial-'+id+' li').each(function(index) {
    		$(this).addClass('selected');
    		$('#tutorial-'+id+' #rating').val((index+1));
    		if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
    			return false;	
    		}
    	});	
    }
    
    function resetRating(id) {
    	if($('#tutorial-'+id+' #rating').val() != 0) {
    		$('.demo-table #tutorial-'+id+' li').each(function(index) {
    			$(this).addClass('selected');
    			if((index+1) == $('#tutorial-'+id+' #rating').val()) {
    				return false;	
    			}
    		});
    	}
    } 