var url = window.location.href;
var arr = url.split('/');
var server = arr[0]+"//"+window.location.hostname+"/hpysrvy.com";
var lastPage1 = 0,
            page1 = 0,
            pagelimit1 = 0,
            totalrecord1 = 0,
            id = id,
            lastId = 0;            

        function surveyList(id, name, page1){  
            page1 = 1;            
            survey(id, name, page1);
        }

        function survey(id, name, page1) {
            if(page1 == 1){
                lastId = '';
            }
            else{
              lastId = (page1-1)*20;
            }
            var time = $('#srvyList').val();
           	$.ajax({
                type: "POST",
                url: server+"/surveylist.php?" + "time="+time+"&storeId="+id+"&userId="+userId+"&lastId="+lastId,
                contentType: 'application/json; charset=utf-8',
                beforeSend: () => {
                  $("#cover-spin").css('display', 'block');
                },
                success: function(response){  
                    var totalrecord = response.totalrecord;  
                    var count = response.fetched;                              
                    var surveyArray = response.data;
                        totalrecord1 = response.totalrecord;
                        pagelimit1 = response.pagelimit;
                        lastPage1 = page1;  
                    var isHappy1;                                             

                    var table = "<table class=\"table table-striped table-bordered second surveyListTable\">" + 
                                    "<thead class=\"bg-light\">" + 
                                        "<tr class=\"border-0\">" +
                                            // "<th class=\"border-0\">id</th>" + 
                                            "<th class=\"border-0\">Happiness</th>" +                                          
                                            "<th class=\"border-0\">Categories</th>" + 
                                            "<th class=\"border-0\">Comment</th>" + 
                                            "<th class=\"border-0\">Mobile</th>" + 
                                            "<th class=\"border-0\">Name</th>" +   
                                            "<th class=\"border-0\">Email</th>" +                                                                                     
                                            "<th class=\"border-0\">Submitted At</th>" +
                                        "</tr>" + 
                                    "</thead>" +
                                "<tbody id=\"tblSurvey1\">"

                    var table1 = "<table class=\"table table-striped table-bordered second surveyListTable\">" + 
                                    "<thead class=\"bg-light\">" + 
                                        "<tr class=\"border-0\">" +
                                            // "<th class=\"border-0\">Id</th>" + 
                                            "<th class=\"border-0\">Happiness</th>"
                                          for (var i = 0; i < response.categoryList.length; i++) {
                        table1 +=           "<th class=\"border-0\">"+response.categoryList[i].name+"</th>"            
                                          }                                        
                                            
                        table1 +=           "<th class=\"border-0\">Comment</th>" + 
                                            "<th class=\"border-0\">Mobile</th>" + 
                                            "<th class=\"border-0\">Name</th>" +   
                                            "<th class=\"border-0\">Email</th>" +                                                                                     
                                            "<th class=\"border-0\">Submitted At</th>" +
                                        "</tr>" + 
                                    "</thead>" +
                                "<tbody id=\"tblSurvey1\">"

                    surveyArray.forEach(function(survey) {
                        if(survey.isHappy == 0) {
                            isHappy1 = 'sad';
                            survey.isHappy = '<div><img src="assets/images/sad@1x.png" class="user-avatar-medium" alt="sad"></div>';
                        }
                        if(survey.isHappy == 1){
                          isHappy1 = 'neutral';
                          survey.isHappy = '<div><img src="assets/images/neutral@1x.png" class="user-avatar-medium" alt="neutral"></div>';
                        }
                        if(survey.isHappy == 2) {
                          isHappy1 = 'happy';
                          survey.isHappy = '<div><img src="assets/images/happy@1x.png" class="user-avatar-medium " alt="happy"></div>';
                        } 
                        var d = new Date(survey.createdAt);
                        var n = d.toLocaleDateString();
                        var catArr = survey.categories;
                        
                        table += "<tr><td>" + survey.isHappy + "</td>"                                               
                        table += "<td>" 
                        catArr.forEach(function(category){
                        if(category.rating > 0){
                        table +=    "<div>"+category.name+"</div>"                        
                        table += "<div class=\"star-ratings-sprite text-center\" style=\"margin-bottom:5px\">"+
                                    "<span style='width:"+ parseInt(category.rating*100/5) + "%' class=\"star-ratings-sprite-rating\"></span>"+
                                "</div>"
                        }
                        });
                        table += "</td>"
                        table += "<td>" + ((survey.comment == null) ? "" : survey.comment) + "</td>"
                        table += "<td>" + ((survey.mobile == null) ? "" : survey.mobile) + "</td>"
                        table += "<td>" + ((survey.name == null) ? "" : survey.name) + "</td>"
                        table += "<td>" + ((survey.email == null) ? "" : survey.email) + "</td>" 
                        table += "<td id=\"fildate\">" + n + "</td>"; 

                        // var categoriesRating = JSON.stringify(survey.categoriesRating); 
                        // var result = categoriesRating.substring(1, categoriesRating.length-1);  
                        // var res = result.replace(/,/g , '; ');    
                       
                        table1 += "<tr><td>" + isHappy1 + "</td>"  
                        if(catArr.length == 0){
                            for (var i = 0; i < response.categoryList.length; i++) {
                                table1 +=   "<td> </td>"            
                            } 
                        }
                        else{
                          catArr.forEach(function(category){
                            table1 +=    "<td>"+category.rating+"</td>"   
                          }) 
                          if(catArr.length < response.categoryList.length) {
								for (var ii = catArr.length; ii < response.categoryList.length; ii++) {
									table1 +=    "<td>0</td>"
								}
							}  
                        }                                         
                        // table1 += "<td>" + res.replace(/"/g , '') + "</td>"                     
                        table1 += "<td>" + ((survey.comment == null) ? "" : survey.comment.replace(/[^a-zA-Z ]/g, " ")) + "</td>"
                        table1 += "<td>" + ((survey.mobile == null) ? "" : survey.mobile) + "</td>"
                        table1 += "<td>" + ((survey.name == null) ? "" : survey.name) + "</td>"
                        table1 += "<td>" + ((survey.email == null) ? "" : survey.email) + "</td>" 
                        table1 += "<td id=\"fildate\">" + n + "</td>";                                    
                        
                    });
                    table += "</tr></tbody></table>";        

                    table1 += "</tr></tbody></table>";      


                    var pageIndex = "";
                            for (var i = 0; i < pagelimit1; i++) {
                            var j = i+1;
                                pageIndex = pageIndex + "<li class=\"page-item active\"><a name=\"surveyPageIndex\" style=\"background-color: #ffc750;color: #71748D;\" class=\"page-link\" href=\"#\" value='" + j + ',' + id +"'>" + j + "</a></li>" 
                            }
                            (j == 1) ? (pageIndex = "") : pageIndex; 
                            var prev = "<a name=\"surveyPageIndex\" class=\"page-link\" href=\"#\" aria-label=\"Previous\" id=\"prev\" style=\"\" value='" + j + ',' + id +"'>" + "<span aria-hidden=\"true\">&laquo;</span><span class=\"sr-only\">Previous</span> " +  "</a>";
                                if(lastPage1 <= 1){
                                    prev = "<a class=\"page-link\" href=\"#\" aria-label=\"Previous\" id=\"prev\" style=\"display:none;\" value=\"\">" + "<span aria-hidden=\"true\">&laquo;</span><span class=\"sr-only\">Previous</span> " + "</a>";
                                }

                            var next = "<a name=\"surveyPageIndex\" class=\"page-link\" href=\"#\" aria-label=\"Next\" id=\"next\" style=\"\" value='" + j + ',' + id +"'><span aria-hidden=\"true\">&raquo;</span>" +
                                            "<span class=\"sr-only\">Next</span>" +
                                        "</a>" ;
                            if(lastPage1 >= pagelimit1){
                                next = "<a class=\"page-link\" href=\"#\" aria-label=\"Next\" id=\"next\" style='display:none'><span aria-hidden=\"true\">&raquo;</span>" +
                                            "<span class=\"sr-only\">Next</span>" +
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
                    // $("#charts").hide();
                    $("#surveyTable").html(table);
                    $("#surveyTableForCsv").html(table1);
                    (totalrecord >= 20) ? $("#pagi").html(pagignation) : $("#pagi").html('');
                    $(".pageheader-title").html("Analytics");
                    $(".surveyheader").html("Submitted Surveys ("+totalrecord+")"); 
                    $("#st").html('');                    
                },
                complete: () => {
                  $("#cover-spin").css('display', 'none');
                },
                error: function(response) {
                    //console.log('error');
                }
            });
        }
        
        $(document.body).on('click', 'a.page-link', function(){    

            if($(this).attr("name") == 'surveyPageIndex' && $(this).text() != "»Next" && $(this).text() != "«Previous " ){ 
                var id = $(this).attr("value"); 
                var idArray = id.split(",");
                var page1 = idArray[0];    
                var storeId = idArray[1]; 
                survey(storeId, name, page1)

            } else if($(this).text() == "«Previous " && $(this).attr("name") == 'surveyPageIndex') {
                 var id = $(this).attr("value"); 
                var idArray = id.split(",");
                var page1 = idArray[0];    
                var storeId = idArray[1]; 
                if(lastPage1 > 1){
                    lastPage1--;
                    survey(storeId, name, lastPage1)                                  
                }
                //console.log("Prev page: " + lastPage1);                   
            }
            else if($(this).text() == "»Next" && $(this).attr("name") == 'surveyPageIndex'){
                 var id = $(this).attr("value"); 
                var idArray = id.split(",");
                var page1 = idArray[0];    
                var storeId = idArray[1]; 
                if(lastPage1 < pagelimit1 ){           
                    lastPage1++;
                    survey(storeId, name, lastPage1)          
                }
                //console.log("Next page: " + lastPage1);            
            }
        });

        $(document).ready(function(){  
            $("#search").on("keyup change clear",function(){            
               var Search = $(this).val().toLowerCase();
               $("#tblSurvey1 tr").filter(function(){
                   $(this).toggle($(this).text().toLowerCase().indexOf(Search) > -1)
               });
           });
       });

        $(document).on('click','#usrstr',function(){
           $url = server+"/storecount.php";
           $.get($url, function(response){
               if(response.status == 'success'){
                       var storeArray = response.data;
                       var table = "<table class=\"table table-striped table-bordered second\">" +
                                       "<thead class=\"bg-light\">" +
                                           "<tr class=\"border-0\">" +
                                               "<th class=\"border-0\">UserId</th>" +
                                               "<th class=\"border-0\">UserName</th>" +
                                               "<th class=\"border-0\">Store</th>" +
                                               "<th class=\"border-0\">Survey</th>" +
                                           "</tr>" +
                                       "</thead>" +
                                   "<tbody>"
                       storeArray.forEach(function(str) {
                           table += "<tr><td>" + str.userId + "</td>"
                           table += "<td>" + str.username + "</td>"
                           table += "<td>" + str.storeId + "</td>"
                           table += "<td>" + str.surveyId + "</td></tr>"
                       });
                       table += "</tr></tbody></table>";
               }
               $(".table").css('display','block');
               $(".table").html(table);
           })
        })

        $(document.body).on('change','#srvyList',function(){
           var time = $(this).val();
           var storeId = sessionStorage.getItem("storeId");
           survey(storeId, name, 1);           
       });

      function downloadCSV(csv, filename) {
          var csvFile;
          var downloadLink;

          // CSV file
          csvFile = new Blob([csv], {type: "text/csv"});

          // Download link
          downloadLink = document.createElement("a");

          // File name
          downloadLink.download = filename;

          // Create a link to the file
          downloadLink.href = window.URL.createObjectURL(csvFile);

          // Hide download link
          downloadLink.style.display = "none";

          // Add the link to DOM
          document.body.appendChild(downloadLink);

          // Click download link
          downloadLink.click();
      }

      function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("#surveyTableForCsv table tr");
        
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");
            
            for (var j = 0; j < cols.length; j++) 
                row.push(cols[j].innerText);
            
            csv.push(row.join(","));        
        }

        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
      }