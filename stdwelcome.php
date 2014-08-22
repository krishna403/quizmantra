
 
<?php
error_reporting(0);
session_start();

$flip=0;

 include('lib.php');
 include('header.php');
 
        if(!isset($_SESSION['stdname']) && !isset($_SESSION['tcname']) && !isset($_SESSION['admname']) ){
            $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
        }
    
        if(isset($_REQUEST['logout'])){
                unset($_SESSION['stdname']);
                
                if(isset($_SESSION['tcid'])){
                   unset($_SESSION['tcname']);
                }
                
                if(isset($_SESSION['admname'])){
                   unset($_SESSION['admname']); 
                }
                
            $_GLOBALS['message']="You are Loggged Out Successfully.";
            header('Location: index.php');
        }
        
        if(isset($_REQUEST['fliptoteacher'])){
            $flip=1; 
        }
        
        if(isset($_REQUEST['fliptostudent'])){
            $flip=0; 
        }
        
       
?>

<html>
    <head>
        <title>Welcome</title>
        <link rel="stylesheet" type="text/css" href="sc.css"/>
    </head>
    <body>
       
        
        
       <fieldset class='loginwall'>
        <div id="container">
          
            <div class="menubar" style="padding-left: 60%;">

               
               <form action="stdwelcome.php" method="post">     
             <table >
              <tr>
                      <?php  
                            if(isset($_SESSION['tcname']) && isset($_SESSION['tcid']) && $flip==0 ){
                      ?> 
                         <td id='c1'><input type="submit" name="fliptoteacher" value="TEACHER MODE" style="color: #36AF79;height: 40px;width: 180px;"></td>
                         
                      <?php  
                       } 
                      ?>
                                        
                        <?php 
                               if(isset($_SESSION['tcname']) && isset($_SESSION['tcid']) && $flip==1 ){
                         ?> 
                             <td id='c1'><input type="submit" name="fliptostudent" value="STUDENT MODE" style="color: #36AE79;height: 40px;width: 180px"></td>
                                   
                        <?php  
                       } 
                      ?>
                    
                               <?php if(isset($_SESSION['stdname']) || isset($_SESSION['tcname']) || isset($_SESSION['admname'])){ ?>
                     
                                <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php if(isset($_SESSION['stdname'])){
                                                                                                               echo $_SESSION['stdname'];
                                                                                                            }
                                                                                                            else if(isset($_SESSION['tcname'])){
                                                                                                                echo $_SESSION['tcname'];
                                                                                                            }   
                                                                                                            else if(isset($_SESSION['admname'])){
                                                                                                                 echo $_SESSION['admname'];
                                                                                                            }
                                                                                    
                                               ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px" /></b></td>
                               <?php } ?>
                   
                       
                  </form>
               </tr>
           </table>
         </div>
            
             
       <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">WELCOME <?php if(isset($_SESSION['admname'])){ echo 'ADMIN';} ?>  </b></font> </legend>
          
                  <?php
       
                    if($_GLOBALS['message']) {
                        echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
                    }
                ?>
           
           
           
                
               <div id="linkdiv">
                <table><tr>
                        <td><input type="image" src="images/teacher-cartoon.jpg" height="300" width="600"></td><td style="padding-bottom: 3%;padding-left: 1%; background-image:url(images/chat.png) ;height:200px; width:400px; background-size: 180px 300px"><p style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;"> hiii! Welcome to  QuizMantra. Here You can enjoy the quiz Tests. Multiple categories of subjects and each of have different questions.</p></td>
                        
                           <td style="padding-left:25%;width:60%" rowspan="2">
                               
                              <?php if(isset($_SESSION['stdname']) && $flip==0){ ?>
                               
                              <div style="width:50%;height:80%;border:5px solid #000;padding-left:15%;border-color: #36AE79">                    
                           
                                
                                        <table cellspacing="">
                         
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="viewresult.php"><input type="button" value="RESULT HISTORY" style="color: #36AE79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="testcategory.php"><input type="button" value="START TEST" style="color: #36AE19;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="editprofile.php?edit=edit"><input type="button" value="EDIT PROFILE" style="color: #31AE79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="resumetest.php"><input type="button" value="RESUME TEST" style="color: #36AF79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                               <?php 
                                               
                                                  if(isset($_SESSION['tcname']) && isset($_SESSION['tcid']) && $flip==0 ){
                                                      
                                                 ?> 
                                                <tr>
                                                <form action="stdwelcome.php" method="post">
                                                    <td style="padding-top: 20px" id='c1'><input type="submit" name="fliptoteacher" value="TEACHER MODE" style="color: #800F19;height: 65px;width: 250px;font-size: 23px;"></td>
                                                </form>
                                                </tr>
                                               <?php  } ?>
                            
                                        </table>
                                  </div>   
                              <?php 
                                } 
                                
                             if(isset($_SESSION['tcname']) && $flip==1){
                                  
                              ?> 
                               
                               <div style="width:50%;height:80%;border:5px solid #000;padding-left:15%;border-color: #36AE79">                    
                           
                                
                                        <table cellspacing="">
                         
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="tc/submng.php"><input type="button" value="SUBJECT MANAGE" style="color: #36AE19;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="tc/rsltmng.php"><input type="button" value="RESULT MANAGE" style="color: #31AE79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="tc/testmng.php?forpq=true"><input type="button" value="ADD QUESTIONS" style="color: #36AE70;height: 70px;width: 250px;font-size: 21px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="tc/testmng.php"><input type="button" value="TEST MANAGE" style="color: #36AF79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                   <form action="stdwelcome.php" method="post">
                                                     <td style="padding-top: 20px" id='c1'><input type="submit" name="fliptostudent" value="STUDENT MODE" style="color: #800F19;height: 65px;width: 250px;font-size: 23px;"></td>
                                                  </form>
                                                </tr>
                                            
                            
                                        </table>
                               </div>       
                               
                              <?php  } 
                              
                               if(isset($_SESSION['admname'])){ 
                              
                              ?>
                               <div style="width:50%;height:80%;border:5px solid #000;padding-left:15%;border-color: #36AE79">                    
                           
                                
                                        <table cellspacing="">
                         
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="admin/usermng.php"><input type="button" value="USER MANAGE" style="color: #36AE79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="admin/submng.php"><input type="button" value="SUBJECT MANAGE" style="color: #36AE19;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="admin/rsltmng.php"><input type="button" value="RESULT MANAGE" style="color: #31AE79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="admin/testmng.php?forpq=true"><input type="button" value="ADD QUESTIONS" style="color: #36AE70;height: 70px;width: 250px;font-size: 21px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="admin/testmng.php"><input type="button" value="TEST MANAGE" style="color: #36AF79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                            
                            
                                        </table>
                               </div>       
                               
                               
                               <?php }?>
                           </td>  
                        </tr>
                        <tr>
                             <td style="padding-bottom:3%;padding-left: 1%; background-image:url(images/whiteboardhome.jpg) ;height:250px; width:270px; background-size: 600px 350px"><p style="padding-bottom: 15%;font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;"><em><b>Quiz Mantra</b></em> provides online quizzes <br>and different subject's tests. <em><b>Online quizzes</b></em> are a popular form of entertainment for web surfers. Online quizzes are generally for entertainment and knowledge purposes though some online quiz like us. Websites feature online quizzes on many subjects.<br><br>Mantra Quizzes are set up to actually test knowledge or identify a person's attributes. <br>Some companies use online quizzes as an efficient way of testing a potential hire's knowledge without that candidate needing to travel. Online dating services often use personality quizzes to find a match between similar members.</p></td>
                       </tr>
                 </table>  
              </div>
          </div>
      </body>
  </fieldset>
 </fieldset>

<?php
  include('loginfooter.html');
