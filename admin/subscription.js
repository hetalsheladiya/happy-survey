
getUserTrialTime();

getOrderData(sessionStorage.getItem('id'));

function helpSection(){
	$("#helpSection").css('display','block');
	$("#charts").css('display','none');
	$('#tblSurvey').css('display','none');
	$('.pageheader-title').text('Help');
}

function getUserTrialTime(){	
    var URL = server+"/getusertrialtime.php";
    var data = {'userId': sessionStorage.getItem('id')};
    $.post(URL, data,function(response){ 
    	var html = '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 dayCountDiv" style="text-align: center; position: relative;">'+
            			'Your trial has been expired. '+
            			'<a href="#" data-toggle="modal" data-target="#subscriptionModal">Please subscribe Happy Survey and upgrade today</a>.';
        			'</div>'; 
        if(response.status == true){  
        	sessionStorage.setItem("trial_start", response.data);      	         	
        	if(response.data < 7 && response.data > 0){
        		setTimeout(function(){
					$('#subscriptionModal').modal('show');
				}, 5000);
        	}
        	$(".trialTextDiv").css('display', 'block');
            (response.data > 0) ? $("#remainDays").text(response.data) : $(".dayCountDiv").html(html);  
        } 
        else{    	
			$(".dashboard-wrapper").css('z-index', -1);	
			$(".trialTextDiv").css('display', 'block');		  
            $(".dayCountDiv").html(html);             	
    	}            	                    
    })
}

function getPaymentInfo(){	
	var url = window.location.href;
	var arr = url.split('/');
    var server = arr[0]+"//"+window.location.hostname+"/hpysrvy.com";
    	
	var url_string = new URL(url);
    var userId = url_string.searchParams.get("u"); 
    var subscriptionId = url_string.searchParams.get("s"); 
    $.ajax({
    	url: server+"/getorderstatus.php",
    	type: 'POST',
    	data: {'userId': userId, 'subscriptionId': subscriptionId},
    	success: (response) => {	    		
    		var html = '';
    		if(response.status == 'success'){
    			sessionStorage.setItem('subscriptionId', subscriptionId);
    			html += "<h1 class=\"success\">"+response.message+"</h1>"
		
				html += 	"<h4>Payment Information</h4>"
				html +=			"<p><b>Reference Number:</b>  "+response.data.id+"</p>"
				html +=			"<p><b>Order ID:</b>  "+response.data.orderId+"</p>"
				html +=			"<!-- <p><b>Paid Amount:</b> <?php echo $paidAmount.' '.$paidCurrency; ?></p> -->"
				html +=			"<!-- <p><b>Payment Status:</b> <?php echo $payment_status; ?></p> -->"
							
				html +=			"<h4>Product Information</h4>"
				html +=			"<p><b>Name:</b>  "+response.data.itemName+"</p>"
				html +=			"<p><b>Price:</b>  "+response.data.itemPrice+" "+response.data.currency;+"</p>"
    		}
    		else{
    			html = "<h1 class=\"error\">Your payment has Failed</h1>";
    			$("<a href=\"subscription.html\" class=\"btn-link\">Back to payment page</a>").insertAfter('.status');
    		}
    		$(".status").html(html);

    		setTimeout(function(){
				window.location.href = 'dashboard.html';
			},3000);
    	}
    })
}

function getOrderData(userId){
	$.ajax({
		url: server+"/orderdata.php",
		type: 'GET',
		data: {'userId': userId},
		success: (response) => {
			var orderData = response.data;
			if(orderData != null){
				sessionStorage.setItem('subscriptionId', orderData.subscriptionId);
				sessionStorage.setItem('customerId', orderData.customerId);
				sessionStorage.setItem('current_period_end', orderData.current_period_end);
				if(orderData.payment_status == 'active'){	
					setInterval(function(){					
						if(sessionStorage.getItem('current_period_end')){
							var subscriptionEndTime = sessionStorage.getItem('current_period_end')*1000;
							if(subscriptionEndTime < Date.now()){				
								updateSubscriptionData(sessionStorage.getItem('id'), sessionStorage.getItem('subscriptionId')); 
							}
						}
					}, 300000);
					$(".dashboard-wrapper").css('z-index', 1);
					$(".trialTextDiv").css('display', 'none');				
					$(".subscriptionCancelButton").css('display', 'block');
					$(".priceButton").css('display', 'none');												
				}
			}
			else{				
				$(".trialTextDiv").css('display', 'block');	
				// setTimeout(function(){
				// 	$('#subscriptionModal').modal('show');
				// }, 5000);
				$(".subscriptionCancelButton").css('display', 'none');				
			}			
		},
		error: (response) => {

		}
	})
}

function updateSubscriptionData(userId, subscriptionId){
	$.ajax({
		type: 'GET',
		url: 'https://api.stripe.com/v1/subscriptions/'+subscriptionId,		
		headers: {
          Authorization: 'Bearer sk_test_10JUfvR1PKjcDJa01K8RUEzH00hOEVEQdd'
        },       
        success: (response) => {       
        var subscriptionEndTime = (response.current_period_end)*1000;        		
        	if(subscriptionEndTime <= Date.now()){
	        	$.ajax({
	        		type: 'POST',
	        		url: server+"/orderdata.php",
	        		data: {'userId': userId, 'customerId': response.customer, 'subscriptionId': subscriptionId, 'current_period_end': response.current_period_end, 'orderId': response.metadata.order_id},
	        		success: (response) => {
	        			if (response.status == 'success') {
	        				
	        			}
	        		},
	        		error: (response) => {
	        			
	        		}
	        	})
	        }          
        },
        error: (response) => {
          console.log(response);
        }
	})
}

$(".subscriptionCancelButton").on('click', () => {
	swal({
        title: "Are you sure?",
        text: "Are you sure you want to unsubscribe your plan?",
        icon: "info",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
			$.ajax({
				type: 'DELETE',
				url: 'https://api.stripe.com/v1/subscriptions/'+sessionStorage.getItem('subscriptionId'),	
				headers: {
		          Authorization: 'Bearer sk_test_10JUfvR1PKjcDJa01K8RUEzH00hOEVEQdd'
		        },
		        beforeSend: () => {
					$("#cover-spin").css('display', 'block');	
        		},
		        success: (response) => {        	
		        	if(response.status == "canceled"){
		        		$.ajax({
		        			url: server+"/orderdata.php"+'?' + $.param({'userId': sessionStorage.getItem('id'), 'subscriptionId': sessionStorage.getItem('subscriptionId'), 'orderId': response.metadata.order_id, 'status': response.status}),
			        		type: 'DELETE', 
			        		beforeSend: () => {
								$("#cover-spin").css('display', 'block');	
			        		},      		
			        		success: (response) => {
			        			if (response.status == 'success') {
			        				swal({title: "Canceled!", text: response.message, icon: response.status, timer:1500});
			        				$(".subscriptionCancelButton").css('display', 'none');
			        				$(".priceButton").css('display', 'block');
			        				$(".priceButton").text('Get Started');
			        				sessionStorage.removeItem("subscriptionId");
			        				$(".trialTextDiv").css('display', 'block');
			        				$(".dashboard-wrapper").css('z-index', -1);
			        			}
			        			else{
			        				swal({title: "Error!", text: response.message, icon: 'error', timer:1500});
			        			}
			        		},
			        		complete: () => {
								$("#cover-spin").css('display', 'none');
			        		},	
			        		error: (response) => {

			        		}
			        	})
		        	}
		        },
		        complete: () => {
					$("#cover-spin").css('display', 'none');
        		},
		        error: (response) => {
		        	console.log(response);
		        }
			})
		} 
	});
})

$(document.body).on('click', 'a.nav-link', function(){	
	if(sessionStorage.getItem('subscriptionId') || sessionStorage.getItem('trial_start') > 0){
		// $(".dashboard-wrapper").css('z-index', 1);
	}
	else{
		if($(this).attr("name") == 'subscription'){
			$(".footer.trialTextDiv").css({'display':'none', 'background-color': '#0e0c28'});	
			$(".dashboard-wrapper").css('z-index', 1);
		}
		else{
			$(".footer.trialTextDiv").css({'display': 'block', 'background-color': '#FFFFFF'});
			$(".dashboard-wrapper").css('z-index', -1);
		}
	}
})
