 <?php
 
       include("header.php"); 
   ?>    
    <body>
        
        
        <?php
        
        $display=TRUE;
        $name1='';
        $email1='';
        $comment1='';
        
        $count=0;
          
              
        if($_SERVER['REQUEST_METHOD']== 'POST'){ 
               
               function spam_scrubber($value){
                   
                   $very_bad=  array('to:','cc:','bcc:','content-type:','mime-version:','multipart-mixed:','content-transfer-encoding:');
                   
                   foreach ($very_bad as $v) {
                       if(stripos($value, $v)!==FALSE)
                               return '';
                   }
                   
                   $value=  str_replace(array( "\r","\n", "%0a", "%0d"),' ', $value);
                   
                   return trim($value);
                   
               }
               
               $scrubbed= array_map('spam_scrubber', $_POST);

              if(!empty($scrubbed['name']) && !empty($scrubbed['email']) && !empty($scrubbed['comments'])){
                  
                   $display=FALSE;
                    
                  $body="Name: {$scrubbed['name']}\n\nComments :{$scrubbed['comments']} ";
                  $body= wordwrap($body,70);
                  
                  $to='krishna@vidyamantra.com';
                  $sub='Regarding Form Submission';
                  
                  
                  mail($to,$sub,$body,"From: {$scrubbed['email']}");
                          echo '<button onclick="history.go(-1);" id="backbutt" style="height: 40px; width: 200px;">Back </button>';
                          echo	'<br><hr><br><font color="#000707">Thank You for Contact Us <br><br></font>we will reply you at : <font color="#74D8FF"><b><i>'.$_POST['email'].'<br><br><hr><br><br><br>';
                          $count++;
                          $_POST=array();
                  
              }
              
              else{
                   $count++;
                   $display=TRUE;
              }
                 
              
           }  
               
           
        
        
     if($display==TRUE){   
        
        ?>
        
        
         <table align="center" bgcolor='cream'><tr> <td> <button onclick="history.go(-1);" id="backbutt" style="height: 40px; width: 200px;">Back </button></td>
          </table>
        
      <div id="contactbody">  
      <br>
      <form action="contact.php" method="post">
       <fieldset>
           <legend><Strong>Contact Detail:</strong></legend>
           
                 <table  cellpadding="15">
                  <tr>
			<td><label for="f1">Name :</label></td>
			<td><input type="text" class="f1" name="name" size="21" maxlength="30" value="<?php
                                                                                                            if(!empty($scrubbed['name'])){
                                                                                                           echo $scrubbed['name'];
                                                                                                     }?>" />
                            
                                                                                  
                        </td>
                        <td> <?php 
                                                                                        if(!empty($scrubbed['name']) && $count>0){
                                                                                          echo '<p class="error"><b>Warning : <font color="#74D8FF">you forget to enter your <em>Name!!</em></p></b></font>';
                                                                                         // echo $array[2];
                                                                                        }
                                                                                        
                                                                                      ?></td>
               </tr>     
               
                
                <tr>
			<td><label>Email ID : </label></td>
			<td><input type="email" class="f2" name="email" size="21" maxlength="30" value="<?php   
                                                                                                            
                                                                                                            if(!empty($scrubbed['email'])){
                                                                                                               
                                                                                                             echo $scrubbed['email'];}
                                                                                                         ?>" />
			                                            </td>
                                                                    <td><?php if(!empty($scrubbed['email']) && $count>0){
                                                                            echo '<p class="error"><b>Warning : <font color="#74D8FF">you forget to enter your <em>Email!!</em></p></b></font>'; 
                                                                     }
                                                                     
                                                                     ?></td>
                
                </tr>
                
                 <tr>
			<td><label>Comment :</label></td>
			<td><textarea class="f3" name="comments" cols="25" rows="4"><?php     
                                                                                    if(!empty($scrubbed['comments'])){
                                                                                     echo $scrubbed['comments'];
                                                                                     } ?></textarea>
                            
                                                </td>
                                                <td> <?php if(!empty($scrubbed['comments']) && $count>0){
                                                     echo '<p class="error"><b>Warning : <font color="#74D8FF">you forget to enter your <em>Comment!!</em></p></b></font>';
                                                    }?></td>
                          
                </tr>     
           
        </table>
       </fieldset>
          
                      <p align="center">  <input type="submit" name="submit" value="Send!"></p>
      </form>
      </div>
        
     <?php
     
       }     
     ?>
        
    </body>
    
    <?php
       include("loginfooter.html"); 
     ?>

