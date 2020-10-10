<!DOCTYPE html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="./assets/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="./assets/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="./assets/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/simple-line-icons/css/simple-line-icons.css">
    <title>Survey app admin</title>
    <!-- Favicon -->
    <link rel="icon" href="assets/images/surveyapplogo.jpg">
    <script type="text/javascript">
        var sessionId = sessionStorage.getItem("id");        
        if(sessionId == null){
            window.location.href = "index.php";
        }
    </script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"  crossorigin="anonymous"></script>-->
</head>

<body>

    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="dashboard.php"><img src="assets/images/surveyapplogo.jpg" class="user-avatar-lg" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                       
                        <li class="nav-item dropdown nav-user" >
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="./assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name" id="result" style="margin-left: 12px;">
                                    <script type="text/javascript"> 
                                        var sess = sessionStorage.getItem("username");                                       
                                        const userName = sess.charAt(0).toUpperCase() + sess.slice(1);
                                        document.write(userName);                                                                                
                                    </script>
                                    </h5>
                                    <input type="hidden" name="session" id="session" value="" />

                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#example2Modal"><i class="fas fa-user mr-2"></i>Account</a>                                               
                                                
                                <!--<a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>-->
                                <a class="dropdown-item" onclick="logout()" href="#."><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
<script type="text/javascript">
    var sessionId = sessionStorage.getItem("id");
    document.getElementById('session').value =  sessionId;
    if(sessionId == ""){
        window.location.href="http://surveyapp/admin/index.php";
    }     
</script>
        