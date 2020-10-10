
    var lastPage2 = 0,
        pagelimit2 = pagelimit2,
        totalrecord2 = 0,
        page2 = 0,
        per_page_record2 = 20;
        
    function storeList(){
        page2 = 1
        getStoreWithTable(page2);        
    }

    function getStoreWithTable(page2){
        $.ajax({
            url: server+"/storelist.php",
            type: 'GET',
            data: {"page":page2, "userId":userId, "per_page_record":per_page_record2},
            beforeSend: () => {
                $("#cover-spin").css('display', 'block');
            },
            success: (response) => {
                var qrcodeLink = '';                    
                var storeArray = response.data;
                    totalrecord2 = response.totalrecord;
                    pagelimit2 = response.pagelimit; 
                    lastPage2 = page2;

                var table = "<table class=\"table table-striped table-bordered second storeListTable\">" + 
                                "<thead class=\"bg-light\">" + 
                                    "<tr class=\"border-0\">" +
                                        // "<th class=\"border-0\">#</th>" + 
                                        "<th class=\"border-0\">Name (Click on the store name to preview the survey)</th>" + 
                                        "<th class=\"border-0\">QR Code</th>" +  
                                        "<th class=\"border-0\">Download QR Code</th>" +  
                                        // "<th class=\"border-0\">QR Code Sticker</th>" +  
                                        "<th class=\"border-0\">Download Sticker PDF</th>" + 
                                        "<th class=\"border-0\">Welcome Message</th>" +                                       
                                        "<th class=\"border-0\">Custom Message</th>" + 
                                        "<th class=\"border-0\">Submitted At</th>" +                                             
                                        "<th class=\"border-0\">Actions</th>" + 
                                    "</tr>" + 
                                "</thead>" +
                            "<tbody>"
                           
                storeArray.forEach(function(str) {
                    var d = new Date(str.createdAt);
                    var n = d.toLocaleDateString();     
                    // table += "<tr><td>" + str.id + "</td>"
                    table += "<td><a href=" + str.link + '?u='+str.userId+'&s='+str.id+"  target='_blank' id=\"link"+str.id+"\" style='text-transform: capitalize'>"+str.name+"</a></td>"    
                    table += "<td><img src=" + str.qrCodeImg + " height=\"150\" width=\"150\" id=\"mcanvas"+str.id+"\"></td>"         
                    // table += "<td><div id=\"qr"+str.id+"\" class=\"qrCodeImage\"></div></td>" 
                    table += "<td><button class=\"btn btn-brand QrcodeDownloadButton\" onclick=\"qrcodeDownload('mcanvas"+str.id+"')\">Download</button></td>"        
                    table += "<td><embed src=" + str.stickerpdf + " height=\"auto\" width=\"150\" id=\"pcanvas"+str.id+"\" style='display:none'><button class=\"btn btn-brand QrcodeDownloadButton\" onclick=\"pdfDownload('pcanvas"+str.id+"')\">Download Sticker</button></td>"  
                    table += "<td>"+str.welcomeMsg+"</td>"
                    table += "<td>"+str.customMsg+"</td>"
                    table += "<td>" + n + "</td>"                        
                    table += "<td> <i class=\"icon-pencil\" style=\"color:blue;cursor:pointer;\" onclick='getStore("+str.id+")'></i> " +
                                            "&nbsp &nbsp &nbsp <i class=\"icon-trash\" style=\"color:red;cursor:pointer;\" onclick='deleteStore("+str.id+")'></i>"+
                                            "&nbsp &nbsp &nbsp <button target='_blank' id=\"copylink\" style='cursor: pointer;' onclick=\"copyToClipboard('#link"+str.id+"')\" class=\"btn btn-default\">" +
                                           "Copy To Clipboard</button></td></tr>"
                });
                table += "</tr></tbody></table>";
                var pageIndex = "";
                for (var i = 0; i < pagelimit2; i++) {
                    var j = i+1;
                    pageIndex = pageIndex + "<li class=\"page-item active\"><a name='storeIndex' class=\"page-link\" href=\"#\" value='" + j + "'>" + j + "</a></li>" 
                }
                (j == 1) ? (pageIndex = "") : pageIndex; 
                
                var prev = "<a class=\"page-link\" href=\"#\" aria-label=\"Previous\" id=\"prev\" style=\"\">" +  "<span aria-hidden=\"true\">&laquo;</span><span class=\"sr-only\">Previous</span> " +     
                            "</a>";
                    if(lastPage2 <= 1 ){
                        prev = "<a class=\"page-link\" href=\"#\" aria-label=\"Previous\" id=\"prev\" style=\"display:none\">" +  "<span aria-hidden=\"true\">&laquo;</span><span class=\"sr-only\">Previous</span> " +     
                                "</a>";
                    }
                var next = "<a class=\"page-link\" href=\"#\" aria-label=\"Next\" id=\"next\" style=\"\"><span aria-hidden=\"true\">&raquo;</span><span class=\"sr-only\">Next</span></a>";
                    if(lastPage2 >= pagelimit2){
                        next = "<a class=\"page-link\" href=\"#\" aria-label=\"Previous\" id=\"prev\" style=\"display:none\">" +  "<span aria-hidden=\"true\">&laquo;</span><span class=\"sr-only\">Previous</span> " +     
                                "</a>";
                    }

                var pagignation = "<nav aria-label=\"Page navigation example\">" +
                                                "<ul class=\"pagination\">" +
                                                    "<li class=\"page-item\">" + prev +                                                             
                                                    "</li>" + pageIndex +                                                        
                                                    "<li class=\"page-item\">" + next +
                                                    "</li>" +
                                                "</ul>" +
                                    "</nav>"                    
                $("#analytic").hide();
                $("#charts").hide();
                $("#surveyTable").html(table);
                $("#pagi").html(pagignation);
                $(".pageheader-title").html("Store");                    
                $(".surveyheader").html("Stores"); 
                $("#st").html("");                
            },
            complete: () => {
                $("#cover-spin").css('display', 'none');
            }  
        }) 	 
         
    }

    $(document.body).on('click', 'a.page-link', function(){
        if($(this).attr("name") == "storeIndex"){
            page2 = $(this).text(); 
            getStoreWithTable(page2); 
        } 
        else if($(this).text() == "«Previous ") {
            if(lastPage2 > 1){
                lastPage2--;
                getStoreWithTable(lastPage2);               
            }
            //console.log("Prev page: " + lastPage2);                   
        }
        else if($(this).text() == "»Next" ){
            if(lastPage2 < pagelimit2 ){           
                lastPage2++;
                getStoreWithTable(lastPage2);             
            }
            //console.log("Next page: " + lastPage2);            
        }

    });

    function saveStore(){
        $(".alert").remove();
        var name = $("#storeName").val(); 
        var googleLink = $("#googleLink").val();  
        var welcomeMsg = $("#welcomeMsg").val();
        var message = $("#customMsg").val(); 
        var checkboxVal;
        ($("#yelpUrlCheckbox").prop('checked') == true) ? checkboxVal = 1 : checkboxVal = 0;
        var yelpUrl;
        var customerName;
        var customerPhone;
        var customerEmail;
        var customerComment;        
        ($("input:checkbox[id=customerName]").prop('checked')) ? customerName = 1  : customerName = 0;
        ($("input:checkbox[id=customerPhone]").prop('checked')) ?  customerPhone = 1 : customerPhone = 0;
        ($("input:checkbox[id=customerEmail]").prop('checked')) ?  customerEmail = 1 : customerEmail = 0;
        ($("input:checkbox[id=customerComment]").prop('checked')) ?  customerComment = 1 : customerComment = 0;
        ($("input:checkbox[id=yelpUrlCheckbox]").prop('checked')) ? yelpUrl = $("#yelpUrl").val() : yelpUrl = '';
         
        if(name == ""){
            $('<div id="alert" class="alert alert-warning" role="alert">Please provide name.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertBefore("#storeName");
            return false;
        }                   
                                   
        $.ajax({
            url: server+"/savestore.php",
            type: 'POST',
            data: {'name' : name, 
                   'userId': userId, 
                   'googleLink': googleLink, 
                   'welcomeMsg': welcomeMsg, 
                   'customMsg': message, 
                   'customerName': customerName, 
                   'customerPhone': customerPhone, 
                   'customerEmail': customerEmail, 
                   'customerComment': customerComment,
                   'yelp': checkboxVal,
                   'yelpUrl': yelpUrl
                  },
            beforeSend: () => {
                $("#cover-spin").css('display', 'block');
            },
            success: (response) => {
                if(response.status == "success") {                                        
                    swal({
                         title: "Created!",
                         text: response.message,
                         icon: response.status,
                         timer: 1250,
                    })           
                    $('#storeModal').modal('toggle');
                    $("input[type=text]").val('');
                    $('textarea').val('');
                    $('input[type="checkbox"]').prop("checked", false);
                    storeList();
                } 
                else {
                    swal({title:'Warning', text:response.message, icon:'warning', timer:1000});
                }                     
            },
            complete: () => {
                $("#cover-spin").css('display', 'none');
            }
        }) 
    }   
  
    function getStore(id){
        $("input:checkbox[id=yelpUrlCheckbox]").prop("checked", false);
        $("#yelpUrl").css('display', 'none');
        $("#yelpUrl").val('')      
        $.ajax({
            url: server+"/getstore.php",
            type: 'GET',
            data: {'userId': userId, 'storeId': id},
            beforeSend: () => {
                $("#cover-spin").css('display', 'block');
            },
            success: (response) => {
                if(response.status == 'success'){
                    var data = response.data;                    
                    (data.glink != null) ? data.glink : ""; 
                    (data.message != null) ? data.message : "";
                    $("#storeId").val(data.storeId);
                    $('#storeName').val(data.name); 
                    $("#googleLink").val(data.glink);
                    $("#welcomeMsg").val(data.welcomeMsg);
                    $("#customMsg").val(data.message); 
                    (data.namefield == 1) ? $("input:checkbox[id=customerName]").prop("checked", true) : $("input:checkbox[id=customerName]").prop("checked", false); 
                    (data.phonefield == 1) ? $("input:checkbox[id=customerPhone]").prop("checked", true) : $("input:checkbox[id=customerPhone]").prop("checked", false); 
                    (data.emailfield == 1) ? $("input:checkbox[id=customerEmail]").prop("checked", true) : $("input:checkbox[id=customerEmail]").prop("checked", false); 
                    (data.commentfield == 1) ? $("input:checkbox[id=customerComment]").prop("checked", true) : $("input:checkbox[id=customerComment]").prop("checked", false);  
                    if(data.yelpUrl != '') {
                        $("input:checkbox[id=yelpUrlCheckbox]").prop("checked", true);
                        $("#yelpUrl").css('display', 'inline-block');
                        $("#yelpUrl").val(data.yelpUrl);
                    }     
                    $("#storeModal").modal('show');
                    $("#saveStore").hide();
                    $('#update').show();                    
                }
                $(".modal-title#exampleModalLabel").text("Edit Store");
            },
            complete: () => {
                $("#cover-spin").css('display', 'none');
            }
        })           
    }    

    function updateStore(){
        $(".alert").remove();
        var name = $("#storeName").val();
        var storeId = $("#storeId").val(); 
        var glink = $("#googleLink").val(); 
        var welcomeMsg = $("#welcomeMsg").val();  
        var message = $("#customMsg").val();
        ($("#yelpUrlCheckbox").prop('checked') == true) ? checkboxVal = 1 : checkboxVal = 0;
        var customerName;
        var customerPhone;
        var customerEmail;
        var customerComment;        
        ($("input:checkbox[id=customerName]").prop('checked')) ? customerName = 1  : customerName = 0;
        ($("input:checkbox[id=customerPhone]").prop('checked')) ?  customerPhone = 1 : customerPhone = 0;
        ($("input:checkbox[id=customerEmail]").prop('checked')) ?  customerEmail = 1 : customerEmail = 0;
        ($("input:checkbox[id=customerComment]").prop('checked')) ?  customerComment = 1 : customerComment = 0;  
        ($("input:checkbox[id=yelpUrlCheckbox]").prop('checked')) ? yelpUrl = $("#yelpUrl").val() : yelpUrl = '';          
        $.ajax({
            url: server+"/updatestore.php",
            type: 'POST',
            data: {'name':name, 
                   'userId':userId, 
                   'storeId':storeId, 
                   'googleLink':glink, 
                   'welcomeMsg': welcomeMsg, 
                   'customMsg': message, 
                   'customerName': customerName, 
                   'customerPhone': customerPhone, 
                   'customerEmail': customerEmail, 
                   'customerComment': customerComment,
                   'yelp': checkboxVal,
                   'yelpUrl': yelpUrl
                  },
            beforeSend: () => {
                $("#cover-spin").css('display', 'block');
            },
            success: (response) => {
                if(response.status == 'success') {
                    swal({
                         title: "Updated!",
                         text: response.message,
                         icon: response.status,
                         timer: 1200,
                    })                    
                    $('#storeModal').modal('toggle');    
                    $("input[type=text]").val('');
                    $('textarea').val('');   
                    $('input[type="checkbox"]').prop("checked", false);
                    storeList(); 
                } 
                else {
                    swal('Warning', response.message, 'warning');
                }                   
            },
            complete: () => {
                $("#cover-spin").css('display', 'none');
            }
        })            
    }

      
    function deleteStore(storeId){
        swal({
            title: "Are you sure?",
            text: "Are you sure that you want to delete?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {                    
                
                    var dataTosend = {'userId':userId,'storeId':storeId};        
           
                    $.ajax({
                        url: server+"/deletestore.php",
                        type: 'GET',
                        data: dataTosend,
                        contentType: 'application/json',
                        dataType: 'json',
                        async: true,
                        beforeSend: () => {
                            $("#cover-spin").css('display', 'block');
                        },
                        success: function(data) {                
                            (data.status == 'success') ?                                  
                                swal({
                                    title : 'Deleted!',
                                    text : data.message,
                                    icon : data.status,
                                    timer :1000
                                })                
                            : swal('error', data.message, 'error');            
                            storeList();                  
                        },
                        complete: () => {
                            $("#cover-spin").css('display', 'none');
                        },
                        error: function(data){
                            
                        }
                    });

                } 
        });
    } 
 
    function qrcodeDownload(element){  
      var link = document.createElement('a');
      link.download = "hpysrvy-image.png";
      link.href = document.getElementById(element).src;
      link.click();
    }

    function pdfDownload(element){
      var link = document.createElement('a');
      link.download = "hpysrvy-sticker.pdf";
      link.href = document.getElementById(element).src;
      link.click();

    }  
    function storeWiseRating(){
        $url = server+"/allstorelist.php";            
        $dataTosend = {'userId': userId} ;
        $.get($url, $dataTosend, function(response){
            if(response.status == 'success'){
                var storeNameArray = response.data;
                
                var table = "<select class=\"custom-select\" id=\"storeIdForPieChart\">"
                    table += "<option value=\"\">All Stores</option>"
                    var i = 0;
                storeNameArray.forEach(function(element){                
                    const name = element.name;
                    const nameCapitalized = name.charAt(0).toUpperCase() + name.slice(1);
                    if (++i == 1) {
                        table += "<option value="+element.id+" selected>"+nameCapitalized+"</option>"
                    }
                    else {
                        table += "<option value="+element.id+">"+nameCapitalized+"</option>"
                    }
                    
                })
                table += "</select>"
            } 
            $("#pieChartRatingWithStore").html(table);
        })    
    }

    $(document.body).on('change', '#storeIdForPieChart', function(){
        var storeId = $(this).val();
        sessionStorage.setItem("storeId", storeId);  
    })

    $("#yelpUrlCheckbox").on('change', function(){
        if(this.checked) {
           $("#yelpUrl").css('display', 'inline-block');
        }
        else{
            $("#yelpUrl").css('display', 'none');
        }
    })

    function storeWiseRating1(){
        $url = server+"/allstorelist.php";            
        $dataTosend = {'userId': userId} ;
        $.get($url, $dataTosend, function(response){
            if(response.status == 'success'){
                var storeNameArray = response.data;
                var table = "<select class=\"custom-select\" id=\"storeIdForPieChart1\">"
                    table += "<option value=\"\">All Stores</option>"
                storeNameArray.forEach(function(element){
                    table += "<option value="+element.id+">"+element.name+"</option>"
                })
                table += "</select>"
            }        
            $("#pieChartRatingWithStore1").html(table);
        })    
    }

    function copyToClipboard(element) {
       var $temp = $("<input>");
         $("body").append($temp);
         $temp.val($(element).attr("href")).select();
         document.execCommand("copy");
         $temp.remove();
    }
