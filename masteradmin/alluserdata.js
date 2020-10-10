var url = window.location.href;
var arr = url.split('/');
var server = arr[0]+"//"+window.location.hostname;
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
                                              "<th class=\"border-0\"></th>" +
                                              "<th class=\"border-0\"></th>" +
                                           "</tr>" +
                                       "</thead>" +
                                   "<tbody>"
                       storeArray.forEach(function(str) {
                           table += "<tr><td>" + str.userId + "</td>"
                           table += "<td>" + str.username + "</td>"
                           table += "<td>" + str.storeIdCount + "</td>"
                           table += "<td>" + str.surveyId + "</td>"
                           table += "<td><embed src=" + str.qrsticker + " height=\"150\" width=\"150\" id=\"pdfcanvas"+str.storeId+"\"></td>"
                           table += "<td><button class=\"btn btn-brand DownloadButton\" onclick=\"qrcodeStickerDownload('pdfcanvas"+str.storeId+"', '"+str.username+"')\">DownloadSticker</button></td>"
                           table += "<td><embed src=" + str.infopdf + " height=\"150\" width=\"150\" id=\"infopdfcanvas"+str.storeId+"\"></td>"
                           table += "<td><button class=\"btn btn-brand DownloadButton\" onclick=\"userInfoPdfDownload('infopdfcanvas"+str.storeId+"', '"+str.username+"')\">DownloadUserInfo</button></td>"
                           
                       });
                       table += "</tr></tbody></table>";
               }
               $(".table").css('display','block');
               $(".table").html(table);
           })
        })

      function qrcodeStickerDownload(element, name){        
        var link = document.createElement('a');
        link.download = name+"-qr-code.pdf";
        link.href = document.getElementById(element).src;
        link.click();
      }

      function userInfoPdfDownload(element, name){        
        var link = document.createElement('a');
        link.download = name+"-login-info.pdf";
        link.href = document.getElementById(element).src;
        link.click();
      }
      