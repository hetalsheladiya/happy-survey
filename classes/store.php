<?php

    
    
class Store
{
	public $id = 0;

	public function getList($userId) {
		global $mysqli;
		global $BASE_URL;
		$statement = $mysqli->prepare("SELECT id, name, createdAt, updatedAt FROM store WHERE userId=? AND isdeleted=0");
		$statement->bind_param('i',$userId);		
		if($statement)
		{
			$statement->execute();
			$statement->bind_result($id, $name, $createdAt, $updatedAt);
			$array = array();
			while($statement->fetch())	{
				
				$o = new Store();
				$o->id = $id;
				$o->name = $name;
				$o->createdAt = $createdAt;
				$o->updatedAt = $updatedAt;
				$o->userId = $userId;
				$array[] = $o;
			}
			return $array;
			$statement->close();
		}
		else {
			echo $mysqli->error();
			exit();
		}
	}

	public function getCountAll($uId) {
        global $mysqli;
        $statement = $mysqli->prepare("SELECT COUNT(id) FROM store WHERE userId=? AND isdeleted=0");
        $statement->bind_param('i', $uId);
        $statement->execute();
        $statement->bind_result($count);
        $statement->fetch();
        $statement->close();
        if (!$count) {
            $count = 0;
        }
        return $count;
    }
    public function getForId($id, $uId) {
        global $mysqli;        
        $statement = $mysqli->prepare("SELECT id, name, createdAt, updatedAt, userId, glink, welcomeMsg, message, namefield, phonefield, emailfield, commentfield, yelpUrl FROM store WHERE userId = ? AND id LIKE ? AND isdeleted=0");
        if($statement) {
            $statement->bind_param('ii', $uId, $id);
            $statement->execute();
            $statement->bind_result($id, $name, $createdAt, $updatedAt, $userId, $googleLink, $welcomeMsg, $message, $namefield, $phonefield, $emailfield, $commentfield, $yelpUrl);
            $array = array(); 
            if ($statement->fetch()) {
                $o = new Store();
                $o->storeId = $id;
                $o->name = $name;                               
                $o->createdAt = $createdAt;
                $o->updatedAt = $updatedAt;
                $o->userId = $userId; 
                $o->glink = $googleLink;
                $o->welcomeMsg = $welcomeMsg;
                $o->message = $message;
                $o->namefield = $namefield;
                $o->phonefield = $phonefield;
                $o->emailfield = $emailfield;
                $o->commentfield = $commentfield;
                $o->yelpUrl = $yelpUrl;
                return $o;
                $statement->close();
            }
            else {
                return NULL;
            }
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }	
	public function getListWithPage($uId, $start_from, $limit) {
		global $mysqli;
		global $BASE_URL;
		$statement = $mysqli->prepare("SELECT id, name, createdAt, updatedAt, link, glink, welcomeMsg, qrcodeimage, message, stickerpdf, infopdf FROM store WHERE userId=? AND isdeleted=0 ORDER BY id DESC LIMIT ?,?");
		$statement->bind_param('iii', $uId, $start_from, $limit);		
		if($statement)
		{
			$statement->execute();
			$statement->bind_result($id, $name, $createdAt, $updatedAt, $link, $glink, $welcomeMsg, $qrcodeimage, $message, $stickerpdf, $infopdf);
			$array = array();
			while($statement->fetch())	{				
				$o = new Store();
				$o->id = $id;
				$o->name = $name;				
				$o->createdAt = $createdAt;
				$o->updatedAt = $updatedAt;
				$o->link = $link;
				$o->glink = $glink;
        $o->welcomeMsg = ($welcomeMsg == NULL) ? '' : $welcomeMsg;
        $o->customMsg = ($message == NULL) ? '' : $message;
				$o->qrCodeImg = $BASE_URL.$qrcodeimage;
				$o->stickerpdf = $BASE_URL.$stickerpdf;
        $o->infopdf = $BASE_URL.$infopdf;
				$o->userId = $uId;
				$array[] = $o;
			}
      $statement->close();
			return $array;			
		}
		else {
			return $mysqli->error;
			exit();
		}
	}

	public function getCountStoreName($name, $userId){
		global $mysqli;
		global $BASE_URL;
		$statement = $mysqli->prepare("SELECT COUNT(name) FROM store WHERE name = ? AND userId = ? AND isdeleted = 0");
		$statement->bind_param('si', $name, $userId);
		$statement->execute();
		$statement->bind_result($count);
		$statement->fetch();
		if(!$count){
			$count = 0;
		}
		$statement->close();
		return $count;
	}

    public function getCountStoreNameWithId($name, $userId, $storeId){
        global $mysqli;
        global $BASE_URL;
        $statement = $mysqli->prepare("SELECT COUNT(name) FROM store WHERE name = ? AND userId = ? AND id <> ? AND isdeleted = 0");
        $statement->bind_param('sii', $name, $userId, $storeId);
        $statement->execute();
        $statement->bind_result($count);
        $statement->fetch();
        if(!$count){
            $count = 0;
        }
        $statement->close();
        return $count;
    }

	public function save($name, $createdAt, $updatedAt, $userId, $email, $verify, $username)
	{
		global $mysqli;
		global $BASE_URL;

		require_once './classes/profile.php';
        $profile = new Profile();
		$existingUserLogo = $profile->getForUserId($userId);        
   
		$link = "http://"."$_SERVER[HTTP_HOST]/hpysrvy.com/"."/admin/review.php";
		$statement = $mysqli->prepare("INSERT INTO store( name, createdAt, updatedAt, userId, link) VALUES (?,?,?,?,?)");		
		$statement->bind_param('sddis', $name, $createdAt, $updatedAt, $userId, $link);
		$r = $statement->execute();		
		$statement->close();		
		if($r) {
			$this->id = $mysqli->insert_id;			
			$qrcodeLink = $link ."?u=".$userId."&s=".$this->id;			

			require_once ('./phpqrcode/qrlib.php');

			$folder = "./qr-code/";
			$file = "qr{$createdAt}.png";
			$file_name = $folder.$file;
			QRcode::png($qrcodeLink, $file_name, 10, 10);		    	   

			require_once './classes/utility.php';
		    $path_parts = pathinfo($BASE_URL.'qr-code/'.$file);
			
            $newFileName =  $path_parts['basename'];

            /*******************QRCODE PDF ***************/

             require_once  './classes/vendor/autoload.php';
             require_once './classes/random_compat-master/lib/random.php';

             require_once  './classes/colorextract/colors.inc.php';             
             $ex = new GetMostCommonColors();
             $num_results = 20;
             $reduce_brightness = 1;
             $reduce_gradients = 1;
             $delta = 24;
             $index = '#000';
             if($existingUserLogo->logo){
                $colors = $ex->Get_Color( $existingUserLogo->logo, $num_results, $reduce_brightness, $reduce_gradients, $delta);
                $colorarray = array_values($colors);
                $index = array_search($colorarray[1], $colors);
              }            
           
             $mpdf = new \Mpdf\Mpdf(['format' => 'A5']);
             $pdfFolder = "qrcode-pdf/";
             
             $p = "qr-code{$createdAt}.pdf";
             $pdfFile_name = $pdfFolder.$p;

             $path_parts1 = pathinfo($BASE_URL.'qrcode-pdf/'.$p);
             $newPdfName =  $path_parts1['basename'];

             if($existingUserLogo->logo){
               $html = '<body style="font-family: League Spartan; font-size: 10pt;">
                         <style>
                         @page {
                             margin: 0%;
                         }
                         h1{
                             margin-top:7.5%;
                             text-align: center;
                             font-family:League Spartan;
                             font-size:33px;
                             font-weight: bold;
                         }
                         </style>
                             <div class="main">
                                 <div style="border: 23px solid #'.$index.';border-radius: 30px;">
                                     <h1>THANKS FOR CHOOSING</h1>
                                     <div style="text-align: center;margin-top:7%;">
                                         <img src="http://'."$_SERVER[HTTP_HOST]/hpysrvy.com/".$existingUserLogo->logo.'" height="100" max-width="100%">
                                     </div>
                                     <h1>TO PROVIDE FEEDBACK SCAN QR CODE</h1>
                                     <div style="text-align: center;">
                                         <img src="http://'."$_SERVER[HTTP_HOST]/hpysrvy.com/qr-code/".$file.'" height="385" width="385">
                                     </div>
                                 </div>
                             </div>
                         </body>';
              }
              else{
                $html = '<body style="font-family: League Spartan; font-size: 10pt;">
                         <style>
                         @page {
                             margin: 0%;
                         }
                         h1{
                             margin-top:7.5%;
                             text-align: center;
                             font-family:League Spartan;
                             font-size:33px;
                             font-weight: bold;
                         }
                         </style>
                             <div class="main">
                                 <div style="border: 23px solid #'.$index.';border-radius: 30px;">
                                     <h1>THANKS FOR CHOOSING</h1>
                                     <div style="text-align: center;margin-top:7%;">
                                         <img src="http://'."$_SERVER[HTTP_HOST]".'/hpysrvy.com/admin/assets/images/placeholder-image.png" height="100" max-width="100%">
                                     </div>
                                     <h1>TO PROVIDE FEEDBACK SCAN QR CODE</h1>
                                     <div style="text-align: center;">
                                         <img src="http://'."$_SERVER[HTTP_HOST]/hpysrvy.com/qr-code/".$file.'" height="385" width="385">
                                     </div>
                                 </div>
                             </div>
                         </body>';
              }

                  $mpdf->WriteHTML($html);
                  file_put_contents($pdfFile_name, $mpdf->Output($p, 'S'));

                  $mpdf = new \Mpdf\Mpdf(['format' => 'A5']);
                   // $pdfFolder = "qrcode-pdf/";
                   
                   $info = "login-info{$createdAt}.pdf";
                   $pdfFile_name = $pdfFolder.$info;

                   $path_parts12 = pathinfo($BASE_URL.'qrcode-pdf/'.$info);
                   // $newPdfName =  $path_parts1['basename'];

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
                                        <img src="http://'."$_SERVER[HTTP_HOST]/hpysrvy.com".'/pdficon/rightpointing.png" height="15" width="15"> <b>Login:</b>
                                        <a href="" style="color:black;"> https://hpysrvy.com/admin/login.html</a>
                                    </p>
                                    <p style="padding-top: -10px;">
                                        <img src="http://'."$_SERVER[HTTP_HOST]/hpysrvy.com".'/pdficon/Smiling Face Emoji.png" height="15" width="15">
                                        <b>Username:</b> '.$username.'
                                    </p>
                                    <p style="padding-top: -10px;">
                                        <img src="http://'."$_SERVER[HTTP_HOST]/hpysrvy.com".'/pdficon/key.png" height="15" width="15">
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
            
            $mpdf->WriteHTML($html1);
            
            file_put_contents($pdfFile_name, $mpdf->Output($info, 'S'));

			/**************End PDF***********/
					   
			$utility = new Utility();
            $subject = "Happy Survey - Your custom QR code survey is ready";
            $confirmationLink = "https://hpysrvy.com/admin/confirmation.html?ud={$userId}&cm={$verify}";
            $body =   '<html><body><h3 style=\"color: #2ab27b;\">Hi '.$name.',</h3>
                        You have now successfully registered with HappySurvey!
                        <br/>We have generated a QR code for '.$name.'. <br/>
                            It will retrieve feedback from your customers.<br/>
                            We recommend posting it in places where the most customers will be able to see and scan it for feedback.<br/>
                            Confirm your email address to start using Happy Survey <br/><br/>
                            
                            <a href="'.$confirmationLink.'" style="min-width: 196px;border-top: 13px solid;border-bottom: 13px solid;border-right: 24px solid;border-left: 24px solid;border-color: #2ea664;border-radius: 4px;background-color: #2ea664;color: #ffffff;font-size: 18px;line-height: 18px;word-break: break-word;text-shadow: 0 1px 1px #2e9a5f;display: inline-block;text-align: center;font-weight: 900;text-decoration: none !important;">Confirm Email Address</a><br/><br/>

                            If you want to submit survey to your store then click on this 
                            <a href="'.$qrcodeLink.'" style="color: #2e2f39;background-color: #ffc750;border-color: #ffc750;
    								padding: 9px 27px;border-radius: 5px;text-decoration: none !important;font-weight:400;">Survey page</a> <br/><br/>
                        
                        Thanks,<br/>HappySurvey Team<br/><br/>	
                        If you have any questions feel free to email us at hi@logileap.com
                        </body></html>';
			// $result = $utility->sendEmailforQrcode($email, $subject, $body, "norply@logileap.net", getcwd()."/qr-code/" . $newFileName, $newFileName, $newPdfName, getcwd()."/qrcode-pdf/".$newPdfName);

			      $this->updateQrcodeImg('qr-code/'.$file, "qrcode-pdf/".$p, "qrcode-pdf/".$info, $this->id, $userId);
            
            require_once './classes/category.php';
            $categoriesName = array("Staff", "Ambience", "Price", "Service");
            foreach ($categoriesName as $categoryName) {
                $category = new Category();
                $category->name = $categoryName;
                $category->userId = $userId;
                $category->createdAt = $createdAt;
                $category->updatedAt = $updatedAt;
                $category->storeId = $this->id;
                $category->saveCategory();
            }
		}
		else {
			return false;
		}		
	}	

	public function __save($glink, $welcomeMsg, $customMsg, $timestamp) {
		global $mysqli;	   
        global $BASE_URL;
		$userId = $this->userId;
		$name = $this->name;
		
	    $link = "http://"."$_SERVER[HTTP_HOST]"."/hpysrvy.com/admin/review.php";
		$statement = $mysqli->prepare("INSERT INTO store( name, createdAt, updatedAt, userId, link, glink, welcomeMsg, message, namefield, phonefield, emailfield, commentfield, yelpUrl) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		// $newName = (($name == "" || $name == NULL) ? "Store" : $name);
		$statement->bind_param('sddissssiiiis', $name, $this->createdAt, $this->updatedAt, $this->userId, $link, $glink, $welcomeMsg, $customMsg, $this->customerName, $this->customerPhone, $this->customerEmail, $this->customerComment, $this->yelpUrl);
		$r = $statement->execute();
		$statement->close();	
		$this->id = $mysqli->insert_id;		
		if($r)
		{
			$this->id = $mysqli->insert_id;			
			$qrcodeLink = $link ."?u=".$userId."&s=".$this->id;  

        require_once './classes/profile.php';
        $profile = new Profile();
        $existingUserLogo = $profile->getForUserId($userId);          

		require_once ('./phpqrcode/qrlib.php');

		$folder = "./qr-code/";
		$file = "qr{$timestamp}.png";
		$file_name = $folder.$file;
		QRcode::png($qrcodeLink, $file_name, 10, 10);

		/*******************QRCODE PDF ***************/

        require_once './classes/utility.php';
        $path_parts = pathinfo($BASE_URL.'qr-code/'.$file);
  
        $newFileName =  $path_parts['basename'];

        /*******************QRCODE PDF ***************/

        
         require_once './classes/random_compat-master/lib/random.php';

         require_once  './classes/colorextract/colors.inc.php';             
         $ex = new GetMostCommonColors();
         $num_results = 20;
         $reduce_brightness = 1;
         $reduce_gradients = 1;
         $delta = 24;
         $colors = $ex->Get_Color( $existingUserLogo->logo, $num_results, $reduce_brightness, $reduce_gradients, $delta);
         $colorarray = array_values($colors);
         $index = array_search($colorarray[1], $colors);            
       
          require_once  './classes/vendor/autoload.php';
         $mpdf = new \Mpdf\Mpdf(['format' => 'A5']);
         $pdfFolder = "qrcode-pdf/";
         
         $p = "qr-code{$timestamp}.pdf";
         $pdfFile_name = $pdfFolder.$p;

         $path_parts1 = pathinfo($BASE_URL.'qrcode-pdf/'.$p);
         $newPdfName =  $path_parts1['basename'];

         $html = '<body style="font-family: League Spartan; font-size: 10pt;">
                   <style>
                   @page {
                           margin: 0%;
                       }
                       h1{
                           margin-top:7.5%;
                           text-align: center;
                           font-family:League Spartan;
                           font-size:33px;
                           font-weight: bold;
                       }
                       </style>
                       <div class="main">
                           <div style="border: 23px solid #'.$index.';border-radius: 30px;">
                               <h1>THANKS FOR CHOOSING</h1>
                               <div style="text-align: center;margin-top:7%;">
                                   <img src="http://'."$_SERVER[HTTP_HOST]/hpysrvy.com".'/'.$existingUserLogo->logo.'" height="100" max-width="100%">
                               </div>
                               <h1>TO PROVIDE FEEDBACK SCAN QR CODE</h1>
                               <div style="text-align: center;">
                                   <img src="http://'."$_SERVER[HTTP_HOST]/hpysrvy.com".'/qr-code/'.$file.'" height="385" width="385">
                               </div>
                           </div>
                       </div>
                    </body>';

          $mpdf->WriteHTML($html);
          file_put_contents($pdfFile_name, $mpdf->Output($p, 'S'));      

            $this->updateQrcodeImg('qr-code/'.$file, "qrcode-pdf/".$p, "", $this->id, $userId);


    			return $this->id;
    		}
    		else{		
    			return $mysqli->error;
                exit();					
    		}	
	}

	public function update($name, $storeId, $userId, $updatedAt, $glink, $welcomeMsg, $message) {
		global $mysqli;
		$statement = $mysqli->prepare("UPDATE store SET name=?, updatedAt=?, glink = ?, welcomeMsg = ?, message = ?, namefield = ?, phonefield = ?, emailfield = ?, commentfield = ?, yelpUrl = ? WHERE isdeleted = 0 AND id = ? AND userId = ?");		
		$statement->bind_param('sdsssiiiisii',$name, $updatedAt, $glink, $welcomeMsg, $message, $this->customerName, $this->customerPhone, $this->customerEmail, $this->customerComment, $this->yelpUrl, $storeId, $userId);
		$r = $statement->execute();
		$statement->close();
		if($r){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	public function delete($storeId,$userId) {
		global $mysqli;
		$statement = $mysqli->prepare("UPDATE store SET isdeleted = 1 WHERE userId = ? AND id LIKE ?");
		$statement->bind_param('ii', $userId, $storeId);
		$r = $statement->execute();
		$statement->close();				
		if($r){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function updateQrcodeImg($qrCodeImg, $qrcodePdf, $infoPdf, $Id, $uId){
		global $mysqli;
		$statement = $mysqli->prepare("UPDATE store SET qrcodeimage = ?, stickerpdf = ?, infopdf = ? WHERE id LIKE ?");		
		$statement->bind_param('sssi', $qrCodeImg, $qrcodePdf, $infoPdf, $Id);
		$r = $statement->execute();
		$statement->close();
		if($r){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}	

  public function getCustomFieldValue($uId, $storeId){
    global $mysqli;
    $statement = $mysqli->prepare("SELECT namefield, phonefield, emailfield, commentfield FROM store WHERE userId LIKE ? AND id LIKE ? AND isdeleted != 1");
    $statement->bind_param('ii', $uId, $storeId);
    if($statement){
      $statement->execute();
      $statement->bind_result($namefield, $phonefield, $emailfield, $commentfield);
      if($statement->fetch()){
        $o = new Store();
        $o->namefield = $namefield;
        $o->phonefield = $phonefield;
        $o->emailfield = $emailfield;
        $o->commentfield = $commentfield;
        return $o;
        $statement->close();
      }
      else{
        return NULL;
      }
    }
    else{
      return $mysqli->error;
      exit();
    }
  }

  // public function updateStore($storeId, $userId, $username){
  //   global $mysqli;

  //   require_once './classes/profile.php';
  //   $profile = new Profile();
  //   $existingUserLogo = $profile->getForUserId($userId);
    
  //   // $mainImage = explode('/', $existingUserLogo->logo);

  //   require_once  './classes/vendor/autoload.php';
  //   require_once './classes/random_compat-master/lib/random.php';

  //    require_once  './classes/colorextract/colors.inc.php';             
  //    $ex = new GetMostCommonColors();
  //    $num_results = 20;
  //    $reduce_brightness = 1;
  //    $reduce_gradients = 1;
  //    $delta = 24;
  //    $colors = $ex->Get_Color( $existingUserLogo->logo, $num_results, $reduce_brightness, $reduce_gradients, $delta);
  //    $colorarray = array_values($colors);
  //    $index = array_search($colorarray[1], $colors);            
   
  //    $mpdf = new \Mpdf\Mpdf(['format' => 'A5']);
  //    $pdfFolder = "qrcode-pdf/";
     
  //    $p = "qr-code1568877729637.pdf";
  //    $pdfFile_name = $pdfFolder.$p;

  //    $path_parts1 = pathinfo($BASE_URL.'qrcode-pdf/'.$p);
  //    $newPdfName =  $path_parts1['basename'];

  //    $html = '<body style="font-family: League Spartan; font-size: 10pt;">
  //              <style>
  //              @page {
  //                  margin: 0%;
  //              }
  //              h1{
  //                  margin-top:7.5%;
  //                  text-align: center;
  //                  font-family:League Spartan;
  //                  font-size:33px;
  //                  font-weight: bold;
  //              }
  //              </style>
  //                  <div class="main">
  //                      <div style="border: 23px solid #'.$index.';border-radius: 30px;">
  //                          <h1>THANKS FOR CHOOSING</h1>
  //                          <div style="text-align: center;margin-top:7%;">
  //                               <img src="https://'."$_SERVER[HTTP_HOST]".'/'.$existingUserLogo->logo.'" height="100" max-width="100%">
  //                          </div>
  //                          <h1>TO PROVIDE FEEDBACK SCAN QR CODE</h1>
  //                          <div style="text-align: center;">
  //                              <img src="https://'."$_SERVER[HTTP_HOST]".'/qr-code/'.$file.'" height="385" width="385">
  //                          </div>
  //                      </div>
  //                  </div>
  //              </body>';

  //         $mpdf->WriteHTML($html);
  //         file_put_contents($pdfFile_name, $mpdf->Output($p, 'S'));

  //         $mpdf = new \Mpdf\Mpdf(['format' => 'A5']);
                   
                   
  //                  $info = "login-info1568877729637.pdf";
  //                  $pdfFile_name1 = $pdfFolder.$info;

  //                  $path_parts12 = pathinfo($BASE_URL.'qrcode-pdf/'.$info);
  //                  // $newPdfName =  $path_parts1['basename'];

  //                  $html1 = '<body>
  //                              <style>
  //                              @page {
  //                                  margin: 8%;
  //                              }
  //                              p{
  //                                  font-size:18px;
  //                              }
  //                              </style>
  //                              <div class="main" style="">
  //                                   <p>Your customer’s feedback can be accessed here:</p>
  //                                   <p>
  //                                       <img src="https://'."$_SERVER[HTTP_HOST]".'/pdficon/rightpointing.png" height="15" width="15"> <b>Login:</b>
  //                                       <a href="" style="color:black;"> https://hpysrvy.com/admin/login.html</a>
  //                                   </p>
  //                                   <p style="padding-top: -10px;">
  //                                       <img src="https://'."$_SERVER[HTTP_HOST]".'/pdficon/Smiling Face Emoji.png" height="15" width="15">
  //                                       <b>Username:</b> '.$username.'
  //                                   </p>
  //                                   <p style="padding-top: -10px;">
  //                                       <img src="https://'."$_SERVER[HTTP_HOST]".'/pdficon/key.png" height="15" width="15">
  //                                       <b>Password:</b> 123456
  //                                   </p>
  //                                   <p>Let me know if you have any questions!</p>
  //                                   <p><b>Akash Trivedi</b> <br>
  //                                         Account Manager | <b>
  //                                       <span style="color: rgb(255,160,42);">Happy Survey</span>
  //                                       </b> <br>
  //                                         64 E Broadway Rd, Suite 200, Tempe, AZ 85282 <br>
  //                                       (385)325-2744 | <a href="https://hpysrvy.com/"> Hpysrvy.com </a>
  //                                   </p>
  //                              </div>
  //         </body>';
            
  //           $mpdf->WriteHTML($html1);
            
  //           file_put_contents($pdfFile_name1, $mpdf->Output($info, 'S'));

  //         $pppp = "qrcode-pdf/".$p;
  //         $iiii = "qrcode-pdf/".$info;
  //         $statement = $mysqli->prepare("UPDATE store SET stickerpdf = ?, infopdf = ? WHERE id LIKE ?");   
  //         $statement->bind_param('ssi', $pppp , $iiii, $storeId);
  //         $r = $statement->execute();
  //         $statement->close();
  //         if($r){
  //           return TRUE;
  //         }
  //         else{
  //           return FALSE;
  //         }
  // }
  public function getUserName($userId){
    global $mysqli;
    $statement = $mysqli->prepare("SELECT username FROM user WHERE id LIKE ?");
    $statement->bind_param('i', $userId);
    $statement->execute();
    $statement->bind_result($username);
    $statement->fetch();
    return $username;    
  }

  public function getStoreQrcode($userId) {
    global $mysqli;
    $statement = $mysqli->prepare("SELECT id, qrcodeimage, stickerpdf from store WHERE userId LIKE ?");
    $statement->bind_param('i', $userId);
    if($statement){
      $statement->execute();
      $statement->bind_result($id, $qrcodeimage, $stickerpdf);
      $array = array();
      while ($statement->fetch()) {
        $o = array();
        $o["storeId"] = $id;
        $o["qrcodeimage"] = $qrcodeimage;
        $o["sticker"] = $stickerpdf;
        $array[] = $o; 
      }
      $statement->close();      
      return $array;
    }
    else{
      return $mysqli->error;
      exit();
    }
  }
}

?>
