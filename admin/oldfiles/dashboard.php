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
    <title>Happy Survey - Admin</title>
    <!-- Favicon -->
    <link rel="icon" href="assets/images/logo@3x.png">
    <script type="text/javascript">
        var sessionId = sessionStorage.getItem("id");        
        if(sessionId == null){
            window.location.href = "index.html";
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
                <a class="navbar-brand" href="dashboard.html"><img src="assets/images/logo@3x.png" class="user-avatar-lg" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon" style="background:url(assets/images/avatar-1.jpg);border-radius: 25px"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item dropdown nav-user nav-user-img" style="padding: 24px 20px 0 20px;font-size: 18px;text-transform: capitalize;" id="companyName">
                            
                        </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="assets/images/business-default-icon.png" alt="" class="user-avatar-medium rounded-circle" id="userImage">
                            </a>
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


        <!-- ============================================================== -->
            <!-- left sidebar -->
            <!-- ============================================================== -->
            <div class="nav-left-sidebar sidebar-dark">
                <div class="menu-list">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="d-xl-none d-lg-none" href="#">Analytics</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav flex-column">
                                <li class="nav-divider">
                                    Dashboard
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="#" class="nav-link" name="dashboard" id="ddd" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i ></i>Analytics </a>                                    
                                    <div id="submenu-1" class="collapse submenu" style="">
                                        <ul class="nav flex-column">  
                                            <li class="nav-item">
                                                <a class="nav-link" name="store" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1-2" 
                                                    aria-controls="submenu-1-2" style="cursor: pointer;">
                                                    <i ></i>Survey</a>
                                                <div id="submenu-1-2" class="collapse submenu" style="">
                                                    <ul id="storeNames" class="nav flex-column">                               
                                                    </ul>
                                                </div>
                                            </li>                           
                                        </ul>
                                    </div>
                                </li> -->

                                <li class="nav-item">
                                    <a href="#" class="nav-link" name="dashboard" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1" style="cursor: pointer;"><i ></i>Analytics </a>
                                    <div id="submenu-1" class="collapse submenu" style="">
                                        <ul id="storeNames" class="nav flex-column">                               
                                        </ul>
                                    </div>
                                </li>

                                <!-- <li class="nav-item">
                                    <a class="nav-link" name="store" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1" style="cursor: pointer;">
                                        <i ></i>Survey</a>
                                    <div id="submenu-1" class="collapse submenu" style="">
                                        <ul id="storeNames" class="nav flex-column">                               
                                        </ul>
                                    </div>
                                </li> -->                                
                                <li class="nav-item">
                                    <a class="nav-link" name="getCat" href="#."><i ></i>Categories</a>                             
                                </li> 
                                <li class="nav-item">
                                    <a class="nav-link" name="getStr" href="#."><i ></i>My Stores</a>                            
                                </li> 
                                                                              
                                <!-- <li class="nav-item">
                                    <a class="nav-link" name="apActiveCal" href="#."><i ></i>LiveDevices</a>                            
                                </li> -->
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end left sidebar -->
            <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper" style="background: #f6f4ef">
            <div class="dashboard-ecommerce" >
                <div class="container-fluid dashboard-content" id="dashboardContent">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title" style="float: left; margin-right:10px;">Analytics </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Analytics</a></li>
                                            <li class="breadcrumb-item active" aria-current="page" id="st" style="display: none;"></li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                                                              
                        <button id="adcategory" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" 
                                style="display: none; border-radius: 50%;margin-bottom: 10px;"> + </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add category</h5>
                                                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </a>
                                                </div>
                                                <div class="modal-body">                                                                
                                                    <label for="email"><b>Category</b></label>
                                                    <input type="hidden" id="categoryId" value="">
                                                    <input type="text" class="form-control form-control-lg" placeholder="Enter category" id="category" required> 

                                                    <label for="email"><b>Store</b></label>
                                                    <div id="selectStore">
                                                        <select class="form-control" id="selectStore" onchange="storeValueChanged()"> 
                                                        <option></option>                                                                
                                                        </select> 
                                                    </div>       
                                                </div>

                                                <div class="modal-footer">
                                                    <a href="#" data-dismiss="modal">Close</a>
                                                    <a href="#" class="btn btn-brand" name="categorySaveButton" id="saveBtnCat">Save </a>
                                                    <a href="#" class="btn btn-brand" id="updateCatBtn"> Update </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  

                                    <button id="adstore" class="btn btn-primary" data-toggle="modal" data-target="#example1Modal" style="display: none; border-radius: 50%; margin-bottom: 10px;"> + </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="example1Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add store</h5>
                                                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </a>
                                                </div>
                                                <div class="modal-body">                                                                
                                                    <label for="email"><b>Store</b></label>
                                                    <input type="hidden" id="storeId" value="">
                                                    <input type="text" class="form-control form-control-lg" placeholder="Enter store" id="storeName">                             
                                                </div>
                                                <div class="modal-body">                                                                
                                                    <label for="email"><b>Google Rating Url</b></label>                                                    
                                                    <input type="text" class="form-control form-control-lg" placeholder="Enter link" id="googleLink">                             
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="#" data-dismiss="modal">Close</a>
                                                    <a href="#" class="btn btn-brand" name="storeSaveButton" id="saveStore">Save </a>
                                                    <a href="#" class="btn btn-brand" id="update">Update </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  

                                     <!-- Account Modal -->

                                    <div class="modal fade" id="example2Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add profile</h5>
                                                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>                                                                    
                                                    </a>
                                                </div>
                                                <div class="modal-body"> 
                                                        <div class="form-control">                                                                        
                                                            <label for="text"><b>Bussiness Name:</b></label>                                                               
                                                            <input type="text" name="bussinessname" id="bussinessname" placeholder="Enter Bussiness name">
                                                        </div>
                                                        <div class="form-control">                                                                        
                                                            <label for="file"><b>logo:</b></label>                                                               
                                                            <input type="file" name="logoimage" id="logoimage" style="display: none;" onclick="changLogo()">
                                                            <div class="parent_div_3" id="logoimgtag">                                                                       
                                                                <img id="blah" src="#" alt="your image" width="100px" height="100px" style="border-radius: 10%;" />    
                                                            </div>                         
                                                        </div>

                                                        <div class="form-control">                                                                            
                                                            <label for="file"><b>background:</b></label>                                                               
                                                            <input type="file" name="bgimage" id="bgimage" style="display: none;" onclick="changBackground()"> 
                                                            <div class="parent_div_3" id="bgimgtag">                                                                
                                                                <img id="blah1" src="#" alt="your image" width="100px" height="100px" style="border-radius: 10%;" />
                                                            </div>
                                                        </div> 
                                                                                                                                                                                       
                                                    </div> 
                                                    <div class="modal-footer">
                                                        <a href="#" data-dismiss="modal">Close</a>
                                                        <a href="#" class="btn btn-brand" id="saveProfile">Save profile</a>
                                                    </div>
                                               
                                            </div>
                                        </div>
                                    </div>

                                
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="ecommerce-widget">

                        <!--<div class="row" id="analytic">
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Today</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1"></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <span><i class="fa fa-fw fa-arrow-up"></i></span><span>5.86%</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Last Week</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1"></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <span><i class="fa fa-fw fa-arrow-up"></i></span><span>5.86%</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue2"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted"> Last 30 Days</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1"></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-primary font-weight-bold">
                                            <span>N/A</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue3"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Last 365 Days</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1"></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-secondary font-weight-bold">
                                            <span>-2.00%</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue4"></div>
                                </div>
                            </div>
                        </div>-->
                        
                        <!--<div class="row">
                            <!-- ============================================================== -->
                                                    <!-- product category  -->
                            <!-- ============================================================== -->
                            <!--<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header"> Customer Happiness</h5>
                                    <div class="card-body">
                                        <div class="ct-chart-category ct-golden-section" style="height: 315px;"></div>
                                        <div class="text-center m-t-40">
                                            <span class="legend-item mr-3">
                                                    <span class="fa-xs text-primary mr-1 legend-tile"><i class="fa fa-fw fa-square-full "></i></span><span class="legend-text">Sad</span>
                                            </span>
                                            <span class="legend-item mr-3">
                                                <span class="fa-xs text-secondary mr-1 legend-tile"><i class="fa fa-fw fa-square-full"></i></span>
                                            <span class="legend-text">Neutral</span>
                                            </span>
                                            <span class="legend-item mr-3">
                                                <span class="fa-xs text-info mr-1 legend-tile"><i class="fa fa-fw fa-square-full"></i></span>
                                            <span class="legend-text">Happy</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end product category  -->
                                   <!-- product sales  -->
                            <!-- ============================================================== -->
                            <!--<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <!-- <div class="float-right">
                                                <select class="custom-select">
                                                    <option selected>Today</option>
                                                    <option value="1">Weekly</option>
                                                    <option value="2">Monthly</option>
                                                    <option value="3">Yearly</option>
                                                </select>
                                            </div> -->
                                        <!--<h5 class="mb-0"> Likes/Dislikes</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="ct-chart-product ct-golden-section"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end product sales  -->
                            <!-- ============================================================== -->
                           
                        <!--</div>-->

                        <div class="row" id="tblSurvey">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Submitted Surveys</h5>
                                    <div class="card-body p-0">
                                        <div id="surveyTable" class="table table-border" style="overflow-x:scroll;overflow-y: scroll;">
                                            <table class="table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">id</th>
                                                        <th class="border-0">CreatedAt</th>
                                                        <th class="border-0">Email</th>
                                                        <th class="border-0">categories</th>
                                                        <th class="border-0">Comment</th>                                                
                                                    </tr>
                                                </thead>
                                                <tbody>                                          
                                                    <tr>
                                                        <td></td>                                                
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>                                                
                                                        <td></td>
                                                    </tr>
                                                    <tr>                                                
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>

                                        </div>
                                        <div class="card-body border-top" id="pagi">
                                        </div>
                                    </div>  
                                </div>
                            </div>                   
                        </div>

                        
                        <div class="row" id="charts">
                            <!-- ============================================================== -->
                            <!-- total revenue  -->
                            <!-- ============================================================== -->
  
                            
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- category revenue  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-header" id="pieChart">
                                        <h5 style="float: left;">Revenue by Rating</h5>
                                        <div class="float-right" id="pieChartRatingWithStore" onchange="selectStoreId()">
                                            <!-- <select class="custom-select" >
                                                <option>All Store</option>                                                
                                            </select> -->
                                        </div> 
                                        <div id="pieChartRatingWithStore1" onchange="selectStoreId1()">
                                            <!-- <select class="custom-select" >
                                                <option>All Store</option>                                                
                                            </select> -->
                                        </div> 
                                    </div>
                                    <div class="card-body">
                                        <div id="c3chart_category" style="height: 420px;font-size: -webkit-xxx-large;text-align: -webkit-center;"></div>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Revenue by Category</h5>
                                    <div class="card-body">
                                        <div id="c3chart_pie"></div>
                                    </div>
                                </div>
                            </div>-->

                            <!-- ============================================================== -->
                            <!-- end category revenue  -->
                            <!-- ============================================================== -->

                            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-header" id="barChart">
                                        <div class="float-right">
                                            <!-- <select class="custom-select">
                                                <option selected>Today</option>
                                                <option value="1">Weekly</option>
                                                <option value="2">Monthly</option>
                                                <option value="3">Yearly</option>
                                            </select> -->
                                        </div>                                         
                                        <div class="text-center">
                                            <img src="assets/images/sad@3x.png" class="user-avatar-medium emoji-sad" onclick="getDataBarChart(0);"> 
                                            <img src="assets/images/neutral@3x.png" class="user-avatar-medium emoji-neautral " onclick="getDataBarChart(1)">
                                            <img src="assets/images/happy@3x.png" class="user-avatar-medium emoji-happy"  onclick="getDataBarChart(2)">                      
                                        </div>                                          
                                    </div>
                                    <div class="card-body">
                                        <div class="ct-chart-product ct-golden-section"></div>
                                    </div>
                                </div>
                            </div>

                        
                       <!--<div class="row">-->                            
                            <!-- ============================================================== -->
                            <!-- end sales traffice source  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- sales traffic country source  -->
                            <!-- ============================================================== -->
                            
                            <!-- ============================================================== -->
                            <!-- end sales traffice country source  -->
                            <!-- ============================================================== -->
                        <!--</div>-->
                    </div>
                </div>
            </div>
     <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            Copyright © 
                            <script>var d = new Date();
                                    var n = d.getFullYear();
                                    document.write(n);                                 
                            </script> Logileap. All rights reserved. Dashboard by <a href="https://logileap.com" target="_blank">Logileap</a>.
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
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.1/sweetalert.min.js"></script>
    <!-- jquery 3.3.1 -->
    <script src="./assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="./assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="./assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="./assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
   <!--  <script src="./assets/vendor/charts/sparkline/jquery.sparkline.js"></script> -->
    <!-- morris js -->
   <!--  <script src="./assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="./assets/vendor/charts/morris-bundle/morris.js"></script> -->
    <!-- chart c3 js -->
    <script src="./assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="./assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="./assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="./assets/libs/js/dashboard-ecommerce.js"></script> 
    <!-- custom.js-->
    <script type="text/javascript" src="anotherjsfile.js"></script>
    <script type="text/javascript" src="allfunction.js" /></script>
    <script src="./assets/libs/js/qrcode.js" type="text/javascript" ></script>
    <script src="assets/libs/js/qrcode.min.js" type="text/javascript" charset="utf-8"></script>
    <!-- <script src="./assets/libs/js/qrious.js" type="text/javascript" ></script> -->
    <!--<script type="text/javascript" src="./../obfuscator.js"></script> -->

    <script type="text/javascript" src="custom.js"></script>
    <script type="text/javascript" src="survey.js"></script>
    <script type="text/javascript" src="profile.js"></script>
    <script type="text/javascript" src="storenamesidemenu.js"></script>
    <script type="text/javascript" src="category.js"></script>
    <script type="text/javascript" src="store.js"></script>    
    <script>
    //$('#form').parsley();
    </script>
    <script>      
    
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            
            selectStoreId();
            storeWiseRating();
            
            getDataBarChart(count);
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
</body>
 
</html>