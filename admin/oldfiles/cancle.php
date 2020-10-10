<!DOCTYPE html>
<html>
<head>
    <title>Happy Survey - Success </title>
    
    <!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Favicon -->
	<link rel="icon" href="assets/images/logo@3x.png"> 
    
    <style type="text/css">
        body{
            /*background-color:  #f6f4ef;*/
        }
        a{
            color:#FBB102;
        }
        a:hover{
            text-decoration: none;
        }
        p{
            color: grey;
            font-size: 25px;
        }
        span{
            font-size: 20px;
        }
        .main{
            position: fixed;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: none;
           	border-radius: .3125em;
           	/*background-color:  #f6f4ef;*/
           	padding: 30px;
        }
        .text-center{
            position: fixed;
            bottom: 0; 
            margin: 10px;            
        }
        h1{
            margin-top: 30px;
            color: rgb(18, 129, 8);
        }
        h4{
            color: rgb(18, 129, 8);
        }
        @media only screen and (max-width: 568px) {
            .main{
                width: 90%;
            }
            h1{
                font-size: 10px;
            }
            
        }
        
        @media only screen and (min-width: 320px) {
            .main{
                width: 40%;
            }
            h1{
                font-size: 20px;
            }
            .text-center{
                margin: 22px;
            }
        }
        /* Extra small devices (phones, 600px and down) */
        @media only screen and (max-width: 600px) {
            .main{
                width: 90%;
                max-width: 100%;
            }
            h1{
                font-size: 1.5em;
            }
            h4{
                font-size: 1em;
            }
            p{
                font-size: 1em;
            }
            span{
                font-size: 1em;
            }
            .text-center{
                margin: 35px;
            }
        }
        /* Small devices (portrait tablets and large phones, 600px and up) */
        @media only screen and (min-width: 600px) {
            .main{
                width: 60%;
            }
            h1{
                font-size: 25px;
            }
        }
        /* Medium devices (landscape tablets, 768px and up) */
        @media only screen and (min-width: 768px) {
            .main{
                width: 60%;
            }
            h1{
                font-size: 25px;
            }
            .text-center{
                left: 26.5%;
            }
        }
        /* Large devices (laptops/desktops, 992px and up) */
        @media only screen and (min-width: 992) {
            .main{
                width: 60%;
            }
            h1{
                font-size: 30px;
            }
        }
        /* Extra large devices (large laptops and desktops, 1200px and up) */
        @media only screen and (min-width: 1200px) {
            .main{
                width: 35%;
            }
            .text-center{
                left: 41.5%;
            }
        }
    </style>
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" >
               function preventBack(){window.history.forward();}
                setTimeout("preventBack()", 0);
                window.onunload=function(){null};
    </script>
    
    <script type="text/javascript">
    callme();
    function callme(){
        var url1 = window.location.href;
        var arr = url1.split('/');
        var server = arr[0]+"//"+window.location.hostname+"/hpysrvy.com";
        
        var url_string = window.location.href; 
        var url = new URL(url_string);
        var userId = url.searchParams.get("userId");
        var orderID = url.searchParams.get("orderID");
        var amount = url.searchParams.get("amount");
        $url = server+"/pay.php";
        $data = {'userId' : userId, 'orderID' : orderID, 'amount': amount};
        $.post($url, $data, function(response){
            if(response.status == 'success'){
                
            }
        })
    }
</script>
</head>
<body>
    <div class="container-fluid">
         <div class="row">
            <center>
                <div class="main example">
                    <img src="assets/images/success1.png" height="90" width="100">
                    <h1>Thank you for your payment.</h1>
                    <h4>Your transaction has been completed.</h4>
                    <p style="margin: 30px 0 0 0;">Verification code:</p>
                    <p><span>
                        <script>
                            var url_string = window.location.href; 
                            var url = new URL(url_string);
                            document.write(url.searchParams.get("orderID"))
                        </script>
                      </span>
                    </p>                    
                </div>                
            </center>
        </div>
        <div class="row"> 
            <footer class="text-center">
               <!--  <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> -->
                           All rights reserved.  Powered by <a href="https://hpysrvy.com" target="_blank" style="cursor: pointer;">HappySurvey</a>.
                        <!-- </div> -->
                        <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div> -->
                    <!-- </div> -->
                <!-- </div> -->
            </footer>
        </div>
    </div>  
        
    
</body>
</html>

