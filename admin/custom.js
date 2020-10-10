
    var url = window.location.href;
    var arr = url.split('/');
    var server = arr[0]+"//"+window.location.hostname+"/hpysrvy.com";

        function login(){            
            $(".alert").remove();
            var username = document.getElementById('username').value;    
            var password = document.getElementById('password').value;
            var dataTosend = "username=" + username + "&password=" + password; 
            if(username == "" && password == ""){
                $('<div class="alert alert-info" style="text-align:center" role="alert">Please provide userdata.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
                return false; 
            }
            if(username == ""){
                $('<div class="alert alert-warning" style="text-align:center" role="alert">Please provide username.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
                return false;
            }
            if(password == ""){
                $('<div class="alert alert-warning" style="text-align:center" role="alert">Please provide password.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
                return false;
            }            
            $.ajax({
                url: server+"/login.php",
                type:"POST",
                data: dataTosend,
                    
                success: function(response){    
                    if(response.status == 'success') {                        
                        var userdata = response.user;
                        var userId = userdata.id; 
                        var username = userdata.username;
                        
                        sessionStorage.setItem("id", userId);  
                        sessionStorage.setItem("username", username);                     
                        window.location.href = 'dashboard.html';                                              
                    }
                    else {
                        $('<div class="alert alert-danger" style="text-align:center" role="alert">'+response.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
                        return false;
                    }                                 
                },
                error: function(response){                    
                }
            });
        }

        function signUp(){
            $(".alert").remove();
            var server = "http://"+window.location.hostname+"/hpysrvy.com"; 
            var companyname = $("#companyname").val();
            var username = $("#username").val();
            var email = $("#email").val();
            var password = $("#pass1").val();
            var logo = document.getElementById('logoimage').files[0];
            var form_data = new FormData();
            form_data.append("companyname", companyname);
            form_data.append("username", username);
            form_data.append("email", email);
            form_data.append("password", password);  
            form_data.append("logo", logo);
               
            // var captcha = grecaptcha.getResponse();
           // if(username == "" && password == ""){
           //      $('<div class="alert alert-info" style="text-align:center" role="alert">Please provide userdata.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
           //      return false; 
           //  }
           //  if(username == ""){
           //      $('<div class="alert alert-warning" style="text-align:center" role="alert">Please provide Email.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
           //      return false;
           //  }
           //  if(password == ""){
           //      $('<div class="alert alert-warning" style="text-align:center" role="alert">Please provide password.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
           //      return false;
           //  }
           $.ajax({
                url: server+'/signup.php',
                type: 'POST',
                data: form_data, 
                // dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".buttonload").css('display', 'block');
                    $("#signupForMainPage").css('display', 'none');
               },               
                success: function(response){  
                // var URL = server+"/signup.php";
                // var data = {'companyname':  companyname, 'username': username, 'email': email, 'password':password/*, 'g-recaptcha-response': captcha*/};
                // $.post(URL, data, function(response){
                    if(response.status == 'success'){ 
                        var userdata = response.user;
                        var userId = userdata.id; 
                        var username = userdata.username;
                            
                        sessionStorage.setItem("id", userId);  
                        sessionStorage.setItem("username", username);                     
                        window.location.href = 'dashboard.html';
                        $('<div class="alert alert-success" style="text-align:center" role="alert">'+response.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
                        $('input').val('');
                            
                    }else  {
                        $('<div class="alert alert-danger" style="text-align:center" role="alert">'+response.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
                        return false;
                    }
                },
                complete: function(){
                       $(".buttonload").css('display', 'none');
                       $("#signupForMainPage").css('display', 'block');
                },
                error: function(response){  
                    console.log(response);                 
                }  
           });        
        }

        function forgetPassword(){
            var username = $("#email").val();
            if(username == ""){
                $('<div class="alert alert-warning" style="text-align:center;font-size:18px;" role="alert">Please provide email.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
                return false;
            }
            $url = server+"/forgotpassword.php";
            $data = {'email': username};
            $.post($url, $data, function(response){
                if(response.status == "success"){
                    $('<div class="alert alert-info" style="text-align:center" role="alert">We sent you instrunction for password reset on your registred email address. Please check that.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
                    $("#email").val('');
                }
                else{
                    if(response.result == ""){
                        $('<div class="alert alert-danger" style="text-align:center" role="alert">Username not exist.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
                        return false;
                    }else{
                        $('<div class="alert alert-danger" style="text-align:center" role="alert">Username or password incorrect.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
                        return false;
                    }
                }
            });
        } 

        var userId = sessionStorage.getItem("id", userId);     

        $(document.body).ready(function(){
            $url = server+"/allstorelist.php";            
            $dataTosend = {'userId': userId} ;
            $.get($url, $dataTosend, function(response){
                if(response.status == 'success'){
                    var storeNameArray = response.data;
                    var a = storeNameArray[0];  
                    var storeId = Object.values(a)[0];
                    sessionStorage.setItem('storeId', storeId);
                    getData(storeId);
                    getBarChart(storeId);
                    // getDataBarChart(count, storeId);
                    surveyList(storeId,$(this).text());      
                }        
                
            })    
        })        

        function logout(){
            sessionStorage.removeItem("id");
            sessionStorage.clear();
            window.location.href = 'login.html';
        }
        
        function saveEmail(){
            var url = server+"/emailsave.php";         
            var email = $("#email").val();
            var data = {'email': email, 'userId': userId};
            $.post(url, data, function(response){
                if(response.status == 'success'){
                    swal({
                        title: "Saved!",
                         text: response.message,
                         icon: "success",
                         timer: 1250,
                     });
                    $("#emailModal").modal('toggle');
                    $("#email").val("");
                    $(".notification").css('display', 'none')
                    getprofile();
                }
                else{
                    swal('Warning', response.message, 'warning');
                }                
            })
        }
        
        $(".emoji-sad").on('click', function() {
            $(this).css({'border':'red solid 1.5px','padding': '2.5px 2.5px 3px', 'border-radius':'40px', 'height':'55px', 'width': '55px'});    
            $(".emoji-neautral").css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
            $(".emoji-happy").css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
        })
        
        $(".emoji-neautral").on('click', function(){
                $(this).css({'border':'rgb(255, 151, 3) solid 1.5px','padding': '2.5px 2.5px 3px', 'border-radius':'40px', 'height':'55px', 'width': '55px'});
                $(".emoji-sad").css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
                $('.emoji-happy').css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
        })  

        $(".emoji-happy").on('click', function(){
            $(this).css({'border':'rgb(134, 209, 2) solid 1.5px','padding': '2.5px 2.5px 3px', 'border-radius':'40px', 'height':'55px', 'width': '55px'});
            $(".emoji-sad").css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
            $(".emoji-neautral").css({'border':'','padding': '', 'border-radius':'', 'height':'', 'width': ''});
        })
        
        function passwordChange(){
            $(".alert").remove();
            var oldpass = $("#oldPass").val(); 
            var newpass = $("#newPass").val();  
            var confpass = $("#confirmPass").val();     
                       
            $url = server+"/changepassword.php";            
            $data = {'oldpassword' : oldpass, 'newpassword': newpass, 'confirmpassword': confpass, 'userId': userId} ;                          
            
            $.post($url, $data, function(response) {                    
                if(response.status == true) {                                        
                    swal({
                         title: "Updated!",
                         text: response.message,
                         icon: "success",
                         timer: 1250,
                    })           
                    $('#example3Modal').modal('toggle'); 
                } 
                else {
                    swal('Warning', response.message, 'warning');
                }                            
                $("#oldpass").val("");
                $("#newpass").val("");   
                $("#confirmPass").val("");           
            })  
        }

        function saveContact(){
            var userId = sessionStorage.getItem('id');
            var username = $("#username").val();
            var email = $("#useremail").val();
            var message = $("#usermessage").val();
            $URL = server+"/contactinfo.php";
            $data = {'name': username, 'email': email, 'message': message, 'userId': userId};
            $.post($URL, $data, function(response){
                if(response.status == 'success'){
                    swal('Submitted!', response.message, response.status);  
                }
                else{
                    swal('Error!', response.message, 'warning');
                }
            })
        }
        
        function resetPassword(){
            $(".alert").remove();
            var url_string = window.location.href; 
            var url = url_string.split('?');
            var userObj = url[1];
            var n = userObj.split('=');
            var userId = n[1];
            var newpwd = $('#newpass').val();            
            var confirmpwd = $('#confirmpass').val();
                newpwd = newpwd.trim();
                confirmpwd = confirmpwd.trim();
            var data = {'newpassword': newpwd, 'confirmpassword':confirmpwd, 'userId': userId};     
            var URL = server+"/resetpassword.php";
            $.post(URL, data, function(response){
                if(response.status == true){                        
                    var userdata = response.data;
                    var uId = userdata.id; 
                    var username = userdata.username;                
                        sessionStorage.setItem("id", uId);  
                        sessionStorage.setItem("username", username);                                
                        window.location.href = 'dashboard.html';
                }
                else{
                    $('<div class="alert alert-info" style="text-align:center;font-size:16px;" role="alert">'+response.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertAfter(".card-header");
                }
            })
        }

