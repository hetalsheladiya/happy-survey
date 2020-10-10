
    
    changeProfileImageIcon();
    getprofile();

    /***************. UPDATE PROFILE  ***************/
    $("a#saveProfile").on('click', function(e){             
        saveProfile();
    });
    
    $('a.dropdown-item').on('click', function(event){
        getprofile();
    });    

    /************* Profile image Uploading.  ****************/
    $("#logoimage").change(function(){
        readURL(this);
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
                $('#lgimageicon').hide();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }   
    /*****************  End     ****************************/

    function changeProfileImageIcon(){
    	var userId = sessionStorage.getItem("id");
        $.ajax({
            url: server+"/profile.php?userId= " + userId,
            type: 'GET',
            contentType: 'application/json',
            beforeSend: () => {
                $("#cover-spin").css('display', 'block');
            },
            success: function(response){
                
                var data = response.profile;              
                
                if(data.logo != ''){
                    $("#userImage").attr('src', '../'+data.logo ); 
                    // $("#userImage").attr('src', data.logoPath);
                }               
                               
            },
            complete: () => {
                $("#cover-spin").css('display', 'none');
            },
            error: function(error){                   
            }

        });
    }

    function saveProfile() {             
    	 $(".alert").remove();
    	 var name = sessionStorage.getItem("username");
    	 var userId = sessionStorage.getItem("id");
    	 var file_data = document.getElementById('logoimage').files[0];
    	 // var file_data1 = $("#bgimage").prop("files")[0];
    	 var bsname = $("#bussinessname").val();
    	 var form_data = new FormData();
    	    form_data.append("userId", userId);
    	    form_data.append("firstname", name);
    	    form_data.append("logo", file_data);
    	    // form_data.append("background", file_data1);
    	    form_data.append("businessname", bsname);               
    	 $.ajax({
    	    url: server+'/saveprofile.php',
    	    type: 'POST',
    	    data: form_data, 
    	    dataType: 'script',
    	    cache: false,
    	    contentType: false,
    	    processData: false,
    	    beforeSend:function(){   
            swal({
                title: "Updated!", 
                text: "Profile successfully updated", 
                icon: "success",
                timer: 1000
            });             
    	     
    	    },
    	    success: function(response){  
                // swal("Updated!", response.message, response.status);
                changeProfileImageIcon();                  
    	        $("#logoimage").val('');
    	        $("#bgimage").val('');
    	        $("#blah").val('');
    	        $("#blah1").val(''); 
    	        $("#example2Modal").modal('toggle');
    	    },
    	    error: function(response){                   
    	    }                                       
    	    });
    }

    function getprofile(){
        $(".alert").remove();
        var userId = sessionStorage.getItem("id");
        $.ajax({
            url: server+"/profile.php?userId= " + userId,
            type: 'GET',
            contentType: 'application/json',
            beforeSend: () => {
                $("#cover-spin").css('display', 'block');
            },
            success: function(response){
                //console.log(response);
                var data = response.profile; 
                var bsname = data.businessname;    
                if(data.logo){    
                $("img#blah").attr('src', '../'+data.logo );           
                // var logoimage = "<img id=\"blah\" src='../" + data.logo + "'  "+
                // 					" alt=\"Company logo\"  height=\"100px\" "+
                // 					"style=\"border-radius: 10%;float:left;cursor:pointer;position:relative\" /> "; 
                // 					// +"<i class=\"fas fa-edit\" id=\"lgimageicon\"  style=\";color:green;display:none;\"></i>";
                }
                else{
                    $("img#blah").attr('src', 'assets/images/placeholder-image.png'); 
                }

                // var bgimage = "<img id=\"blah1\" src='../" + data.background + "' onmouseover=\"showPencilIcon()\" onmouseout=\"hidepencilIcon()\" alt=\"your image\" width=\"100px\" height=\"100px\" style=\"border-radius: 10%;float:left;cursor:pointer;position:relative;\" />" +
                //                 "<i id=\"bgimageicon\" class=\"fas fa-edit\" style=\";color:green;display:none;\"></i>";

                // var htmlContent = "<li class=\"navbar-\" style=\"padding: 26px 20px 0 20px;font-size: 16px\" id=\"emailMessage\">"+
                //                     "<a href=\"#\" data-toggle=\"modal\" data-target=\"#example4Modal\" style=\"color: red\">(Please add email for getting your customer's feedback with email notification)</a>"+
                //                   "</li>";
                
                (data.email == null || data.email == '') ?  $(".notification").css('display', 'block') : $(".notification").css('display', 'none'); 
                $("#email").val(data.email); 
                // $("#logoimgtag").html(logoimage);
                // $("#bgimgtag").html(bgimage);                     
                $("#bussinessname").val(bsname);  
                $("#companyName").text(bsname);        
            },
            complete: () => {
                $("#cover-spin").css('display', 'none');
            },
            error: function(error){                   
            }

        });
    }    

    $(document.body).on('click', '#blah' ,function() {   
        ($(this).attr("id") == "blah") ? ($('#logoimage').click()) : '';
    });

    function changLogo(){            
    }

    // function changBackground(){
    // }

    // function showPencilIcon(){
    //     $("#bgimageicon").css({'display':'block','font-size':'20px','position':'absolute','cursor': 'pointer','padding':'40px'});
    // } 
    // function hidepencilIcon(){
    //   //  $("#bgimageicon").hide();
    // } 