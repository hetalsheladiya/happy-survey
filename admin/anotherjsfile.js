

	$(document).ready(function() {		
// 		$("#tblSurvey").hide();
		$("a.breadcrumb-link").css('display','none');	
		$("#adcategory").css('display', 'none');
		$("#adstore").css('display', 'none');
		$("#helpSection").css('display', 'none');
		$("#contactForm").css('display', 'none');
		$("#pricingPlan").css('display', 'none');	

		$("#example3Modal").on('shown.bs.modal', function(){
        	$(this).find('#oldPass').focus();
    	});

    	$("#emailModal").on('shown.bs.modal', function(){
        	$(this).find('#email').focus();
    	});    

    	$("#categoryModal").on('shown.bs.modal', function(){
        	$(this).find('#category').focus();
    	}); 	

    	$("#storeModal").on('shown.bs.modal', function(){
    		$(this).find('#storeName').focus();
    	})
    	
		$(document.body).on('click', 'a.nav-link' ,function(){
			$("#surveyTable").html("");
			$(".btn-primary").css('display', 'none');

			if($(this).attr("name") == "dashboard"){				
				$(this).addClass('active');				
				$("#charts").show();
				$("#pieChartRatingWithStore").css('display','block');		
				$("#pieChart").replaceWith("<div class=\"card-header\" id=\"pieChart\" style=\"padding-top:19px;\"> <h5>Survey Rating</h5>"+
		                                        "</div>" );
				$(".pageheader-title").html("Analytics");				
				$("#barChart").replaceWith(	"<div class=\"card-header\" id=\"barChart\"><div class=\"text-center\">" +
                                                "<img src=\"assets/images/sad@1x.png\" class=\"user-avatar-medium emoji-sad\" "+
                                                		
                                                		"onclick=\"getDataBarChart(0, sessionStorage.getItem('storeId'));\">" +                   
                                                "<img src=\"assets/images/neutral@1x.png\" class=\"user-avatar-medium emoji-neautral\" onclick=\"getDataBarChart(1, sessionStorage.getItem('storeId'))\">" +
                                                "<img src=\"assets/images/happy@1x.png\" class=\"user-avatar-medium emoji-happy\"  onclick=\"getDataBarChart(2, sessionStorage.getItem('storeId'))\">" +                                             
                                            "</div></div>" );
                storeWiseRating1();	
                getData(sessionStorage.getItem('storeId')); 
                getBarChart(sessionStorage.getItem('storeId'));							
				// getDataBarChart(0, sessionStorage.getItem('storeId'));				
				$("#tblSurvey").show();
				surveyList(sessionStorage.getItem('storeId'));
				$("#srvyList").css('display', 'block');
				$("#search").css('display', 'block');
				$(".exportDiv").css('display', 'block');
				$("#adcategory").css('display', 'none');
				$("#adstore").css('display', 'none');
				$("#helpSection").css('display', 'none');
				$("#contactForm").css('display', 'none');
				$("#pricingPlan").css('display', 'none');
				var table = "<select class=\"custom-select\" id=\"srvyList\" style=\"width:120px;\"> "+
                                                   "<option value=\"\" selected >-Select Time-</option>"+
                                                   "<option value=\"day\" >Day</option>" +
                                                   "<option value=\"week\" >Week</option>" +
                                                   "<option value=\"month\" >Month</option>" +
                                                   "<option value=\"year\" >Year</option>" +
                                               "</select>";
                $('#srvyList').html(table);
							
			}
			else if($(this).attr("name") == "getCat") {
			    $("#pieChartRatingWithStore").css('display','none');
			    $("#adstore").css('display', 'none');
				$("#ddd").removeClass('active');	
			    $("#tblSurvey").show();	
			    $("li#st").css("display", "block");
			    $("#adcategory").css('display', 'block');
			    $("#helpSection").css('display', 'none');
			    $("#pricingPlan").css('display', 'none');
			    $("#contactForm").css('display', 'none');
			    $("#srvyList").css('display', 'none');	
			    $("#search").css('display', 'none');
			    $(".exportDiv").css('display', 'none');		    
		    	categoryList();	    		
		    }
		    else if($(this).attr("name") == "getStr") {
		        $("#pieChartRatingWithStore").css('display','none');
		        $("#adcategory").css('display', 'none');
		        $("#adstore").css('display', 'block');
		    	$("#ddd").removeClass('active');
		    	$("#tblSurvey").show();
		    	$("#charts").css('display', 'none');		    	
		    	$("li#st").css("display", "block");	
		    	$("#helpSection").css('display', 'none');
		    	$("#pricingPlan").css('display', 'none');
		    	$("#contactForm").css('display', 'none');	
		    	$("#srvyList").css('display', 'none');  
		    	$("#search").css('display', 'none');  		    	
				$(".exportDiv").css('display', 'none');	 	
		    	storeList();		    	
		    }	
		    else if($(this).attr("name") == 'helpSection'){
		    	$("#contactForm").css('display', 'none');
		    	$("#adcategory").css('display', 'none');
		        $("#adstore").css('display', 'none');
		        $("#pieChartRatingWithStore").css('display', 'none');
		        $("#helpSection").css('display','block');
				$("#charts").css('display','none');
				$('#tblSurvey').css('display','none');
				$("#pricingPlan").css('display', 'none');
				$('.pageheader-title').text('Help');
		    	helpSection();
		    }
		    else if($(this).attr("name") == 'contact'){
		    	$("#contactForm").css('display', 'block');
		    	$("#adcategory").css('display', 'none');
		        $("#adstore").css('display', 'none');
		        $("#pieChartRatingWithStore").css('display', 'none');
		        $("#charts").css('display', 'none');
		        $("#tblSurvey").css('display', 'none');
		        $("#helpSection").css('display','none');
		        $("#pricingPlan").css('display', 'none');
		        $('.pageheader-title').text('Contact');		    	
		    }
			else if($(this).attr("name") == 'subscription'){
				$(".card-header.bg-primary").html('Free');
				$(".card-header.bg-info").html('Business');
				$("#contactForm").css('display', 'none');
		    	$("#adcategory").css('display', 'none');
		        $("#adstore").css('display', 'none');
		        $("#pieChartRatingWithStore").css('display', 'none');
		        $("#helpSection").css('display','none');
				$("#charts").css('display','none');
				$('#tblSurvey').css('display','none');
				$('.pageheader-title').text('Subscription');
				$("#pricingPlan").css('display', 'block');								
				getOrderData(sessionStorage.getItem('id'));			
			}	    
		    		    
		});	

		$(document.body).ready(function(){	
			setTimeout(function(){
				if(sessionStorage.getItem('subscriptionId')){
					// $(".dashboard-wrapper").css('z-index', 1);
				}
				else{
					if(sessionStorage.getItem('trial_start') > 0){

					}
					else{				
						setTimeout(function(){
							$(".dashboard-wrapper").css('z-index', -1);
						}, 100);
						setTimeout(function(){
							$('#subscriptionModal').modal('show');
						}, 1000);
					}					
				}				
			}, 1000)	
		})			
		
		/****************** ADD CATEGORY *******************/
		$("button.btn.btn-brand").on('click',function(e){	
			// $('input').val('');
			if($(this).attr("id") == "adcategory") {
				getStoreName(id="");
				$("#exampleModalLabel").text('Add Category');
				$(".alert").remove();				
				$('#saveBtnCat').show();
				$("#updateCatBtn").hide();
				$('#category').val('');
		        $('#categoryId').val('');
		        $('#storeIds').val('');	
	    	}
			
	    /*****************  ADD STORE   *******************/	
	    	if($(this).attr("id") == "adstore"){
	    		$(".alert").remove();
	    		$("#saveStore").show();	    		
	    		$("#update").hide();
	    		$("input[type=text]").val('');
	    		$("textarea").val('');
	    		$('input[type="checkbox"]').prop("checked", false);
	    		$(".modal-title#exampleModalLabel").text("Add Store");
			}	        
		});

		$("#update").on('click', function(){
			updateStore();
		});	

		$("#updateCatBtn").on('click',function(e){	 
			updateCategory();
		});	

		$("#saveStore").on('click',function(e){			
			saveStore();				
		});

		$("#saveBtnCat").on('click', function(e){			
			saveCategory();
		})

		//  SUBSCRIPTION BUTTON 
		$(".priceButton").on('mouseover', function(){
			if($(this).text() === 'Get Started'){
				$(this).attr('href', "subscription.html?u="+sessionStorage.getItem('id'));
				$(".priceButton").attr('target', '_blank');	
				$(this).css({'cursor':'pointer'})			
			}
			if($(this).text() === 'Subscribed'){
				$(this).removeAllDataAttributes();
				$(this).css({'cursor':'no-drop', 'background-color': '#ffc750'});
			}
		})
		
		/***************. LOGIN PAGE *****************/
		$("#log").click(function(){				
			event.preventDefault();
			login();
		});

		$("#signup").click(function(){				
			event.preventDefault();
			signUp();
		});

		$("#forgetPass").click(function(){
			forgetPassword();
		});			
	});	
	
	
	$(document.body).on('change', '#pieChartRatingWithStore', function(){
        var snrid = $("#storeIdForPieChart").val();
        getData(snrid);
        getBarChart(snrid);	
        // getDataBarChart(count, snrid);
        surveyList(snrid,$(this).text());
	})
	
	$(".footerCloseIcon").on('click', function(){
		$('.trialTextDiv').css('display', 'none');
	})

	// $(".subscriptionLink").on('click', function(){									
	// 	getOrderData(sessionStorage.getItem('id'));	
	// })
	
	$(document).bind('contextmenu', function(e) {
	    e.stopPropagation();
	    e.preventDefault();
	    e.stopImmediatePropagation();
	    return false;
	});