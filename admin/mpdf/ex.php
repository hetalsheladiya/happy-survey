<?php

require_once __DIR__ . '/vendor/autoload.php';


$mpdf = new \Mpdf\Mpdf(['format' => 'A5']);
// $pdffile_name = md5(rand()) . '.pdf';
$html = '<body style="font-family: League Spartan; font-size: 10pt;">
		<style>
		@page {     
			margin: 0%;
		}
		h1{	
			margin-top:7%;
			text-align: center;  							
			font-family:League Spartan;
			font-size:33px;
			font-weight: bold;		
		}
		</style>
			<div class="main">
				<div style="border: 23px solid rgb(255,176,3);border-radius: 30px;">
					<h1>THANKS FOR CHOOSING</h1>
					<div style="text-align: center;margin-top:7%;">
						<img src="https://'."$_SERVER[HTTP_HOST]".'/'.$logo.'" height="100" width="100">
			    	</div>
			    	<h1>TO PROVIDE FEEDBACK SCAN QR CODE</h1>
					<div style="text-align: center;">
						<img src="https://'."$_SERVER[HTTP_HOST]".'/qr-code/'.$file.'" height="380" width="380">
			    	</div>					
				</div>
			</div>
		</body>';
	$html1 = '<body>
				<style>
				@page {     
					margin: 8%;
				}
				p{
					font-size:18px;
				}
				</style>
				<div class="main" style="">
                     <p>Your customer’s feedback can be accessed here:</p>
                     <p>
                     	<img src="http://'."$_SERVER[HTTP_HOST]".'/pdficon/rightpointing.png" height="15" width="15"> <b>Login:</b>
                     	<a href="" style="color:black;"> https://hpysrvy.com/admin/login.html</a>
                     </p>
                     <p style="padding-top: -10px;">  
                     	<img src="http://'."$_SERVER[HTTP_HOST]".'/pdficon/Smiling Face Emoji.png" height="15" width="15"> 
                     	<b>Username:</b> '.$username.'
                     </p>
                     <p style="padding-top: -10px;">
                     	<img src="http://'."$_SERVER[HTTP_HOST]".'/pdficon/key.png" height="15" width="15"> 
                     	<b>Password:</b> 123456
                     </p>
                     <p>Let me know if you have any questions!</p>
                     <p><b>Akash Trivedi</b> <br>
	                       Account Manager | <b>
	                     <span style="color: rgb(255,160,42);">Happy Survey</span>
	                     </b> <br>
	                       64 E Broadway Rd, Suite 200, Tempe, AZ 85282 <br>
	                     (385)325-2744 | <a href="https://hpysrvy.com/"> Hpysrvy.com </a>
                     </p>
                </div>
			 </body>';

$mpdf->WriteHTML($html);
$mpdf->WriteHTML($html1);
$mpdf->Output();
// $out = $mpdf->Output('','S');
// file_put_contents($pdffile_name, $out);
?>

<div class="main" style="">
                     <p>Your customer’s feedback can be accessed here:</p>
                     <p>
                     	<img src="./pdficon/rightpointing.png" height="15" width="15"> <b>Login:</b>
                     	<a href="" style="color:black;"> https://hpysrvy.com/admin/login.html</a>
                     </p>
                     <p style="padding-top: -10px;">  
                     	<img src="./pdficon/Smiling Face Emoji.png" height="15" width="15"> 
                     	<b>Username:</b> mvfd
                     </p>
                     <p style="padding-top: -10px;">
                     	<img src="./pdficon/key.png" height="15" width="15"> 
                     	<b>Password:</b> 123456
                     </p>
                     <p>Let me know if you have any questions!</p>
                     <p><b>Akash Trivedi</b> <br>
	                       Account Manager | <b>
	                     <span style="color: rgb(255,160,42);">Happy Survey</span>
	                     </b> <br>
	                       64 E Broadway Rd, Suite 200, Tempe, AZ 85282 <br>
	                     (385)325-2744 | <a href="hpysrvy.com"> Hpysrvy.com </a>
                     </p>
                </div>
<!-- <body>
                         <div class="main" style="width:70%;margin-left:19%;">
                             <div style="position: fixed;
                                                           top: 50%;
                                                           left: 50%;
                                                           transform: translate(-50%,-50%);
                                                           width: 70%;
                                                           border: 20px solid rgb(255,176,3);
                                                           border-radius: 20px;
                                                           padding: 20px;
                                                           padding
                                                       ">
                                 <h1 style="text-align: center;
                                           content: rgb(74,74,74);
                                           font-family:verdana;
                                           font-size:30px;
                                           font-weight: 200;
                                           ">SCAN QR CODE TO SUBMIT FEEDBACK</h1>
                                 <div style="
                                               text-align: center;
                                               ">
                                     <img src="https://'."$_SERVER[HTTP_HOST]".'/qr-code/'.$file.'" height="380" width="380">
                                 </div>

                                 <div style="text-align: center;
                                               ">
                                     <img src="https://'."$_SERVER[HTTP_HOST]".'/smiley.png" height="120" width="120">
                                 </div>

                             </div>
                         </div>
                     </body> -->