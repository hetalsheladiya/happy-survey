
    function getStoreNameWithSidemenu(){              
            
            $url = server+"/getstorelist.php";
            $data = {'userId':userId};
                 
            $.get($url, $data, function(response){                               
                var storeArray = response.data;
                // var list = "<li class=\"nav-item\"><a class=\"nav-link\" name=\"allstore\" value='allstore' href=\"#.\">All Stores </a></li>"
                var list = "<li class=\"nav-item\">" 

                storeArray.forEach(function(store){ 
                    const name = store.name;
                    const nameCapitalized = name.charAt(0).toUpperCase() + name.slice(1);
                list += "<a name=\"dash\" class=\"nav-link\" value=\"" + store.id + "\" dataClick=\"performAction\" href=\"#.\">" + nameCapitalized + "</a>" 
                });
                list += "</li>";
                $("#storeNames").html(list);
                $("#analytic").hide();
                // $(".pageheader-title").html("Store");
                // $(".card-header").html("Submitted Surveys"); 
                $("#st").html("Store");                   
            
        });        
    }

    //****************** RATING ****************/   
    // var lastPage1 = 0,
    //         page1 = 0,
    //         pagelimit1 = 0,
    //         totalrecord1 = 0,
    //         id = id,
    //         per_page_record1 = 50;

    //     function allRatingList(id, name, page1){  
    //         page1 = 1;            
    //         surveyRatingList(id, name, page1);
    //     }

    //     function surveyRatingList(id, name, page1) {  
    //         $url =  server+"/ratinglist.php";
    //         $dataToSend = {"page":page1, "storeId":id, "userId":userId, "per_page_record":per_page_record1};
    //         $.post($url, $dataToSend, function(response){               
    //             // success: function(response){                                  
    //             var ratingArray = response.data;
    //                 totalrecord1 = response.totalrecord;
    //                 pagelimit1 = response.pagelimit;
    //                 lastPage1 = page1;                                               

    //                 var table = "<table class=\"table table-striped table-bordered second\">" + 
    //                                 "<thead class=\"bg-light\">" + 
    //                                     "<tr class=\"border-0\">" +
    //                                         "<th class=\"border-0\">id</th>" + 
    //                                         "<th class=\"border-0\">rating</th>" + 
    //                                         "<th class=\"border-0\">comment</th>" + 
    //                                         "<th class=\"border-0\">store</th>" + 
    //                                         "<th class=\"border-0\">createdAt</th>" +                                            
    //                                     "</tr>" + 
    //                                 "</thead>" +
    //                             "<tbody>"
    //                 ratingArray.forEach(function(survey) {                        
    //                     var d = new Date(survey.createdAt);
    //                     var n = d.toLocaleDateString();                       
    //                     table += "<tr><td>" + survey.id + "</td>"
    //                     table += "<td><div class=\"star-ratings-sprite\"><span style='width:"+ parseInt(survey.rating*100/5) + "%' class=\"star-ratings-sprite-rating\"></span></div></td>"                  
    //                     table += "<td>" + survey.comment + "</td>"
    //                     table += "<td>" + survey.storeId + "</td>"
    //                     table += "<td>" + n + "</td>"                      
                        
    //                 });
    //                 table += "</tr></tbody></table>";
    //                 var pageIndex = "";
    //                         for (var i = 0; i < pagelimit1; i++) {
    //                         var j = i+1;
    //                             pageIndex = pageIndex + "<li class=\"page-item active\"><a name=\"surveyPageIndex\" class=\"page-link\" href=\"#\" value='" + j + ',' + id +"'>" + j + "</a></li>" 
    //                         }
    //                         (j == 1) ? (pageIndex = "") : pageIndex; 
    //                         var prev = "<a name=\"surveyPageIndex\" class=\"page-link\" href=\"#\" aria-label=\"Previous\" id=\"prev\" style=\"\" value='" + j + ',' + id +"'>" + "<span aria-hidden=\"true\">&laquo;</span><span class=\"sr-only\">Previous</span> " +  "</a>";
    //                             if(lastPage1 <= 1){
    //                                 prev = "<a class=\"page-link\" href=\"#\" aria-label=\"Previous\" id=\"prev\" style=\"display:none;\" value=\"\">" + "<span aria-hidden=\"true\">&laquo;</span><span class=\"sr-only\">Previous</span> " + "</a>";
    //                             }

    //                         var next = "<a name=\"surveyPageIndex\" class=\"page-link\" href=\"#\" aria-label=\"Next\" id=\"next\" style=\"\" value='" + j + ',' + id +"'><span aria-hidden=\"true\">&raquo;</span>" +
    //                                         "<span class=\"sr-only\">Next</span>" +
    //                                     "</a>" ;
    //                         if(lastPage1 >= pagelimit1){
    //                             next = "<a class=\"page-link\" href=\"#\" aria-label=\"Next\" id=\"next\" style='display:none'><span aria-hidden=\"true\">&raquo;</span>" +
    //                                         "<span class=\"sr-only\">Next</span>" +
    //                                     "</a>";                                                     
    //                         }
    //                         var pagignation = "<nav aria-label=\"Page navigation example\">" +
    //                                                 "<ul class=\"pagination\">" +
    //                                                     "<li class=\"page-item\">" + prev + 
    //                                                     "</li>" + pageIndex +
    //                                                      "<li class=\"page-item\">" + next +
    //                                                     "</li>" +
    //                                                 "</ul>" +
    //                                             "</nav>"

    //                 $("#analytic").hide();
    //                 $("#charts").hide();
    //                 $("#surveyTable").html(table);
    //                 $("#pagi").html(pagignation);
    //                 $(".pageheader-title").html("Store");
    //                 $(".card-header").html("Submitted Surveys"); 
    //                 $("#st").html(name);                    
    //             // }
                
    //         });
    //     }
    //     $(document.body).on('click', 'a.page-link', function(){    

    //         if($(this).attr("name") == 'surveyPageIndex' && $(this).text() != "»Next" && $(this).text() != "«Previous " ){ 
    //             var id = $(this).attr("value"); 
    //             var idArray = id.split(",");
    //             var page1 = idArray[0];    
    //             var storeId = idArray[1]; 
    //             surveyRatingList(storeId, name, page1)

    //         } else if($(this).text() == "«Previous " && $(this).attr("name") == 'surveyPageIndex') {
    //              var id = $(this).attr("value"); 
    //             var idArray = id.split(",");
    //             var page1 = idArray[0];    
    //             var storeId = idArray[1]; 
    //             if(lastPage1 > 1){
    //                 lastPage1--;
    //                 surveyRatingList(storeId, name, lastPage1)                                  
    //             }
    //             //console.log("Prev page: " + lastPage1);                   
    //         }
    //         else if($(this).text() == "»Next" && $(this).attr("name") == 'surveyPageIndex'){
    //              var id = $(this).attr("value"); 
    //             var idArray = id.split(",");
    //             var page1 = idArray[0];    
    //             var storeId = idArray[1]; 
    //             if(lastPage1 < pagelimit1 ){           
    //                 lastPage1++;
    //                 surveyRatingList(storeId, name, lastPage1)          
    //             }
    //             //console.log("Next page: " + lastPage1);            
    //         }
    //     });