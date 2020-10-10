    var page = 0,
        lastPage = 0,
        pagelimit = pagelimit,
        totalrecord = 0,    
        per_page_record = 20;
    var selected_index = null;

    function categoryList(){            
        page = 1,
        fetchData(page);          
    }

    function fetchData(page){       
        $.ajax({
            url: server+"/categorylist.php" ,
            type: "GET",
            data: {'page': page, 'userId': userId, 'per_page_record': per_page_record},            
            beforeSend: () => {
                $("#cover-spin").css('display', 'block');
            },
            success: function(response){       
                    var categoryArray = response.data;
                        totalrecord = response.totalrecord;
                        pagelimit = response.pagelimit; 
                        lastPage = page;                                           
                
                    var categoryTable = "<table id=\"example\" class=\"table table-striped table-bordered second\" style=\"width:100%\">" +
                                            "<thead>" +
                                                "<tr>" +
                                                    // "<th>#</th>" +
                                                    "<th>Name</th>" +                                            
                                                    "<th>Submitted At</th>" +                                                    
                                                    "<th>Store Name</th>" +
                                                    "<th>Action</th>" +                                          
                                                "</tr>" +
                                            "</thead>" +
                                            "<tbody>" 
                    categoryArray.forEach(function(categories){
                        var d = new Date(categories.createdAt);
                        var n = d.toLocaleDateString();
                        var du = new Date(categories.updatedAt);
                        var up = du.toLocaleDateString();
                        // categoryTable += "<tr><td>#</td>"                                  
                        categoryTable +=    "<td style='text-transform: capitalize'>" + categories.name +"</td>"
                        categoryTable +=    "<td>" + n +"</td>"                      
                        categoryTable +=    "<td style='text-transform: capitalize'>" + categories.storeName +"</td>"
                        categoryTable +=    "<td> <i name=\"catId\" class=\"icon-pencil\" style=\"color:blue;cursor:pointer;\" onclick='getCategory("+categories.id+")'></i> " +
                                            "&nbsp &nbsp &nbsp <i name=\"catId\" class=\"icon-trash\" onclick='deleteCategory("+categories.id+","+categories.storeId+")' style=\"color:red;cursor:pointer;\" value='" + categories.id + ',' + categories.storeId + "'></i></td> </tr>"

                   });
                        categoryTable += "</tbody></tr></tfoot></table>";
                        var pageIndex = "";
                        for (var i = 0; i < pagelimit; i++) {
                        var j = i+1;
                            pageIndex = pageIndex + "<li class=\"page-item active\"><a name='catPageIndex' id=\"cat\" class=\"page-link\" href=\"#\" value='" + j + "'>" + j + "</a></li>" 
                        }
                        (j == 1) ? (pageIndex = "") : pageIndex; 
                        var prev = "<a class=\"page-link\" href=\"#\" aria-label=\"Previous\" id=\"prev\" style=\"\" value=\"\">" + "<span aria-hidden=\"true\">&laquo;</span><span class=\"sr-only\">Previous</span> " +  "</a>";
                            if(lastPage <= 1){
                                prev = "<a class=\"page-link\" href=\"#\" aria-label=\"Previous\" id=\"prev\" style=\"display:none;\" value=\"\">" + "<span aria-hidden=\"true\">&laquo;</span><span class=\"sr-only\">Previous</span> " + "</a>";
                            }

                        var next = "<a class=\"page-link\" href=\"#\" aria-label=\"Next\" id=\"next\" style=\"\"><span aria-hidden=\"true\">&raquo;</span>" +
                                        "<span class=\"sr-only\">Next</span>" +
                                    "</a>" ;
                        if(lastPage >= pagelimit){
                            next = "<a class=\"page-link\" href=\"#\" aria-label=\"Next\" id=\"next\" style='display:none'><span aria-hidden=\"true\">&raquo;</span>" +
                                        "<span class=\"sr-only\">Next</span>" +
                                    "</a>" ;                                                     
                        }
                        var pagignation1 = "<nav aria-label=\"Page navigation example\">" +
                                                "<ul class=\"pagination\">" +
                                                    "<li class=\"page-item\">" + prev +
                                                    "</li>" + pageIndex +
                                                     "<li class=\"page-item\">" + next +
                                                    "</li>" +
                                                "</ul>" +
                                            "</nav>"
                        $("#analytic").hide();
                        $("#charts").hide();
                        $("#surveyTable").html(categoryTable);
                        $("#pagi").html(pagignation1);
                        $(".pageheader-title").html("Category");                    
                        $(".surveyheader").html("Categories");
                        $(".btn-primary").css('display', 'block');
                        $("#adstore").css('display', 'none');
                        $("#st").html("");                                   
            },
            complete: () => {
                $("#cover-spin").css('display', 'none');
            },
            error: function(response) {
                
            }
        });
    }

    $(document.body).on('click', 'a.page-link' ,function() {
        if ($(this).attr("name") == "catPageIndex" && $(this).text() != "»Next" && $(this).text() != "«Previous " ) {
            var page = $(this).text();
            fetchData(page);
        }
        else if ($(this).text() == "«Previous ") {
            if(lastPage > 1){
                lastPage--;
                fetchData(lastPage);               
            }
            //console.log("Prev page: " + lastPage);                   
        }
        else if($(this).text() == "»Next" ){
            if(lastPage * pagelimit < totalrecord){           
                lastPage++;
                fetchData(lastPage);             
            }
            //console.log("Next page: " + lastPage);            
        }
    });

    function saveCategory(){
        $(".alert").remove();          
        var name = $("#category").val();
        var storeId = $("#storeIds").val();        
        if(name == ""){
            $('<div id="alert" class="alert alert-warning" role="alert">Please provide name.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertBefore("#category");
            return false;
        }
        if(storeId == 0){
            $('<div id="alert" class="alert alert-warning" role="alert">Please select store.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertBefore("#category");
            return false;
        }
        $.ajax({               
            url: server+'/savecategory.php',
            type: 'POST', 
            data: {'name': name, 'userId': userId, 'storeId': storeId},             
            beforeSend: () => {
                $("#cover-spin").css('display', 'block');
            },
            success: function(response) {          
                if(response.status == 'fail'){
                    swal({title: "Warning!", text: response.message, icon: "warning", timer: 1500});  
                }
                else{
                    $('#category').val('');
                    $('#categoryId').val('');
                    $('#storeIds').val('');
                    swal({title: "Created!", text:response.message, icon:response.status, timer:1500}); 
                    $('#categoryModal').modal('toggle');
                    categoryList();                                             
                }                    
            },
            complete: () => {
                $("#cover-spin").css('display', 'none');
            },
            error: function(response){
               
            }
        });
    }      

    function getCategory(id){       
        $.ajax({
            url: server+"/getcategory.php",
            type: 'GET',
            data: {'userId': userId, 'categoryId': id},
            beforeSend: () => {
                $("#cover-spin").css('display', 'block');
            },
            success: (response) => {
                if(response.status == 'success'){
                    var data = response.data;                    
                    $("#categoryId").val(data.id);
                    $('#category').val(data.name); 
                    getStoreName(parseInt(data.storeId));                   
                    $("#exampleModalLabel").text('Edit Category');
                    $("#categoryModal").modal('show');
                    $('#saveBtnCat').hide();
                    $('#updateCatBtn').show();                                      
                }                
            },
            complete: () => {
                $("#cover-spin").css('display', 'none');
            }
        })           
    }      

    
    function getStoreName(storeId){
        $(".alert").remove();      
        $.ajax({
            url: server+'/getstorename.php',
            type: 'GET',
            data: { 'userId' : userId },           
            beforeSend: () => {
                $("#cover-spin").css('display', 'block');
            },
            success: function(response){                    
                var storeArray = response.data;
                var dropdown = "<select id='storeIds' class=\"form-control\">"+
                                "<option value=\"0\">Select your store</option>"

                storeArray.forEach(function(stores){
                    dropdown +=  "<option value='" + stores.id + "' " + ((storeId == stores.id) ? " selected='selected'" : "") +  ">" + stores.name + "</option>";
                });
                dropdown += "</select>";
                $('#selectStore').html(dropdown);                                                          
            },
            complete: () => {
                $("#cover-spin").css('display', 'none');
            },
            error: function(response){
               
            }
        });
    }    

    function storeValueChanged() {
        selected_index = $(this).text();
    } 

    function updateCategory(){
        $(".alert").remove();
        var name = $("#category").val();
        var storeId = $("#storeIds").val();
        var categoryId = $("#categoryId").val();        
        $.ajax({
            url: server+"/updatecategory.php",
            type: 'POST',
            data: {'name': name, 'userId': userId, 'storeId': storeId, 'categoryId': categoryId},            
            beforeSend: () => {
                $("#cover-spin").css('display', 'block');
            },
            success: function(response){                
                if(response.status == 'success') {
                    swal({title: "Updated!", text: response.message, icon: response.status, timer:1500});
                    $('#categoryModal').modal('toggle');      
                    $("#categoryId").val('');
                    $('#category').val('');
                    $('#storeIds').val('');  
                    categoryList();   
                }
                else{
                    swal("Warning!", response.message, "warning");  
                }             
            },
            complete: () => {
                $("#cover-spin").css('display', 'none');
            },
            error: function(response){
                
            }
        });
    }

    function deleteCategory(categoryId, storeId){
        swal({
            title: "Are you sure?",
            text: "Are you sure that you want to delete?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {     
                    $.ajax({
                        url: server+"/deletecategory.php",
                        type: 'POST',
                        data: {'userId': userId, 'categoryId': categoryId, 'storeId': storeId},                        
                        beforeSend: () => {
                            $("#cover-spin").css('display', 'block');
                        },
                        success: function(data) {                
                            if(data.status == 'fail'){
                                $('<div class="alert alert-danger" role="alert">Minimum required 4 categories.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').insertBefore(".card");
                            }else {  
                                swal({title: 'Deleted!', text: data.message, icon: data.status, timer: 1500});                         
                                categoryList();                     
                            }                                             
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