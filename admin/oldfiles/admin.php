<html>
<head>  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <title>Happy Survey - Master Admin</title>
    <!-- Favicon -->
    <link rel="icon" href="assets/images/logo@3x.png">

    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->
    <script type="text/javascript">
      var sessionId = sessionStorage.getItem("id");             
        if(sessionId == null){
            window.location.href = "login.html";
        }
    </script>

  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {
      height: auto;
    }
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    img{
      margin-top: -15px;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    .pg-normal {
        color: #000000;
        font-size: 15px;
        cursor: pointer;
        background: #D0B389;
        padding: 4px 6px 4px 6px;
        }

        .pg-selected {
        color: #fff;
        font-size: 15px;
        background: #000000;
        padding: 4px 6px 4px 6px;
        }

        table.yui {
        font-family:arial;
        border-collapse:collapse;
        border: solid 3px #7f7f7f;
        font-size:small;
        }

        table.yui td {
        padding: 5px;
        border-right: solid 1px #7f7f7f;
        }

        table.yui .even {
        background-color: #EEE8AC;
        }

        table.yui .odd {
        background-color: #F9FAD0;
        }

        table.yui th {
        border: 1px solid #7f7f7f;
        padding: 5px;
        height: auto;
        background: #D0B389;
        }

        table.yui th a {
        text-decoration: none;
        text-align: center;
        padding-right: 20px;
        font-weight:bold;
        white-space:nowrap;
        }

        table.yui tfoot td {
        border-top: 1px solid #7f7f7f;
        background-color:#E1ECF9;
        }

        table.yui thead td {
        vertical-align:middle;
        background-color:#E1ECF9;
        border:none;
        }

        table.yui thead .tableHeader {
        font-size:larger;
        font-weight:bold;
        }

        table.yui thead .filter {
        text-align:right;
        }

        table.yui tfoot {
        background-color:#E1ECF9;
        text-align:center;
        }

        table.yui .tablesorterPager {
        padding: 10px 0 10px 0;
        }

        table.yui .tablesorterPager span {
        padding: 0 5px 0 5px;
        }

        table.yui .tablesorterPager input.prev {
        width: auto;
        margin-right: 10px;
        }

        table.yui .tablesorterPager input.next {
        width: auto;
        margin-left: 10px;
        }

        table.yui .pagedisplay {
        font-size:10pt; 
        width: 30px;
        border: 0px;
        background-color: #E1ECF9;
        text-align:center;
        vertical-align:top;
        }
      
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>
  <script type="text/javascript">
    function Pager(tableName, itemsPerPage) {

    this.tableName = tableName;

    this.itemsPerPage = itemsPerPage;

    this.currentPage = 1;

    this.pages = 0;

    this.inited = false;

    this.showRecords = function(from, to) {

    var rows = document.getElementById(tableName).rows;

    // i starts from 1 to skip table header row

    for (var i = 1; i < rows.length; i++) {

    if (i < from || i > to)

    rows[i].style.display = 'none';

    else

    rows[i].style.display = '';

    }

    }

    this.showPage = function(pageNumber) {

    if (! this.inited) {

    alert("not inited");

    return;

    }

    var oldPageAnchor = document.getElementById('pg'+this.currentPage);

    oldPageAnchor.className = 'pg-normal';

    this.currentPage = pageNumber;

    var newPageAnchor = document.getElementById('pg'+this.currentPage);

    newPageAnchor.className = 'pg-selected';

    var from = (pageNumber - 1) * itemsPerPage + 1;

    var to = from + itemsPerPage - 1;

    this.showRecords(from, to);

    }

    this.prev = function() {

    if (this.currentPage > 1)

    this.showPage(this.currentPage - 1);

    }

    this.next = function() {

    if (this.currentPage < this.pages) {

    this.showPage(this.currentPage + 1);

    }

    }

    this.init = function() {

    var rows = document.getElementById(tableName).rows;

    var records = (rows.length - 1);

    this.pages = Math.ceil(records / itemsPerPage);

    this.inited = true;

    }

    this.showPageNav = function(pagerName, positionId) {

    if (! this.inited) {

    alert("not inited");

    return;

    }

    var element = document.getElementById(positionId);

    var pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal"> « Prev </span> ';

    for (var page = 1; page <= this.pages; page++)

    pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span> ';

    pagerHtml += '<span onclick="'+pagerName+'.next();" class="pg-normal"> Next »</span>';

    element.innerHTML = pagerHtml;

    }

    }
  </script>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
          <a class="navbar-brand" href="#" >
          <img src="assets/images/logo@3x.png" height="50px" width="50px" >
        </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <!-- <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li> -->
            </ul>
        </div>
    </div>
</nav>
  
<div class="container-fluid text-center">    
    <div class="row content">
        <div class="col-sm-2 sidenav">
            <p><a name="user_link" id="usrstr" href="#">All User</a></p>
        </div>
        <div class="col-sm-10 text-left"> 
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
            
                      <table id="tablepaging" class="yui" align="center" style="overflow-x: scroll; overflow-y: scroll;">
                <thead class="bg-light">
                    <tr class="border-0">
                        <th class="border-0">UserId</th>
                        <th class="border-0">Username</th>
                        <th class="border-0">StoreId</th>
                        <th class="border-0">SurveyId</th>  
                        <th class="border-0">Sticker</th>
                        <th class="border-0">Stickedownload</th>
                        <th class="border-0">Info</th>                        
                        <th class="border-0">Infodownload</th>                                        
                    </tr>
                </thead>
                <tbody>
                <?php               
                  require_once './../dbconfig.php';
                  require_once './../classes/user.php'; 
                  require_once './../config.php';             
                  $user = new User();              
                  $list = $user->getAllUserId();              
                  foreach($list as $categoryValue)
                  {
                    $categoryValue = (array)$categoryValue;
                  ?>                                          
                    <tr>
                        <td><?php echo $categoryValue['userId']?></td>                                                
                        <td><?php echo $categoryValue['username']?></td>
                        <td><?php echo $categoryValue['storeIdCount']?></td>
                        <td><?php echo $categoryValue['surveyId']?></td>
                        <td><embed src="<?php echo $categoryValue['qrsticker']?>" height="150" width="150" id="pdfcanvas<?php echo $categoryValue['storeId']?>"></td>
                        <td><button class="btn btn-brand DownloadButton" onclick="qrcodeStickerDownload('pdfcanvas<?php echo $categoryValue['storeId']?>','<?php echo $categoryValue['username']?>')">DownloadSticker</button>
                        <td><embed src="<?php echo $categoryValue['infopdf']?>" height="150" width="150" id="infopdfcanvas<?php echo $categoryValue['storeId']?>"></td>
                        <td><button class="btn btn-brand DownloadButton" onclick="userInfoPdfDownload('infopdfcanvas<?php echo $categoryValue['storeId']?>','<?php echo $categoryValue['username']?>')">DownloadUserInfo</button></td>
                    </tr> 
                    <?php 
           
                    } ?>                   
                </tbody>
            </table> 
            <div id="pageNavPosition" style="padding-top: 20px; padding-bottom: 20px" align="center">
            </div>           
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
var pager = new Pager('tablepaging', 10);
    pager.init();
    pager.showPageNav('pager', 'pageNavPosition');
    pager.showPage(1);
</script>
    <!-- jquery 3.3.1 -->
    <script src="./assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="./alluserdata.js"></script>
</body>
</html>
