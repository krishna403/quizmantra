
 
<?php
error_reporting(0);
session_start();

 include('header.php');
 
        if(!isset($_SESSION['stdname'])){
            $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
        }
        else if(isset($_REQUEST['logout'])){
                unset($_SESSION['stdname']);
                unset($_SESSION['tcname']);
            $_GLOBALS['message']="You are Loggged Out Successfully.";
            header('Location: index.php');
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

               
                    
             <table >
              <tr>
                      <?php  if(isset($_SESSION['tcname']) && isset($_SESSION['tcid']) ){?> 
                                        <td id='c1'><a href="tc/tcwelcome.php"><input type="button" value="TEACHER MODE" style="color: #36AE79;height: 40px;width: 180px"></a></td>
                                                
                      <?php  } ?>
                                                
                          <form name="stdwelcome" action="stdwelcome.php" method="post">
                    
                               <?php if(isset($_SESSION['stdname'])){ ?>
                     
                                <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                             echo $_SESSION['stdname'];
                                                                                    
                                               ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px" /></b></td>
                               <?php } ?>
                   
                       </form>
              
               </tr>
           </table>
         </div>
            
             
       <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">WELCOME </b></font> </legend>
          
                  <?php
       
                    if($_GLOBALS['message']) {
                        echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
                    }
                ?>
           
           
            <?php if(isset($_SESSION['stdname'])){ ?>
                
               <div id="linkdiv">
                <table><tr>
                        <td><input type="image" src="images/teacher-cartoon.jpg" height="300" width="600"></td><td style="padding-bottom: 3%;padding-left: 1%; background-image:url(images/chat.png) ;height:200px; width:400px; background-size: 180px 300px"><p style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;"> hiii! Welcome to  QuizMantra. Here You can enjoy the quiz Tests. Multiple categories of subjects and each of have different questions.</p></td>
                        
                           <td style="padding-left:25%;width:60%" rowspan="2">
                              <div style="width:50%;height:80%;border:5px solid #000;padding-left:15%;border-color: #36AE79">                    
                           
                                
                                        <table cellspacing="">
                         
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="viewresult.php"><input type="button" value="VIEW RESULT" style="color: #36AE79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="testcategory.php"><input type="button" value="START TEST" style="color: #36AE19;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="editprofile.php?edit=edit"><input type="button" value="EDIT PROFILE" style="color: #31AE79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="practicetest.php"><input type="button" value="PRACTICE TEST" style="color: #36AE70;height: 70px;width: 250px;font-size: 21px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="resumetest.php"><input type="button" value="RESUME TEST" style="color: #36AF79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                               <?php  if(isset($_SESSION['tcname']) && isset($_SESSION['tcid']) ){?> 
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="tc/tcwelcome.php"><input type="button" value="TEACHER MODE" style="color: #36AF79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                               <?php  } ?>
                            
                                        </table>
                               </div>       
                          </td>  
                       </tr>
                       <tr>
                             <td style="padding-bottom:3%;padding-left: 1%; background-image:url(images/whiteboardhome.jpg) ;height:250px; width:270px; background-size: 600px 350px"><p style="padding-bottom: 15%;font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;"><em><b>Quiz Mantra</b></em> provides online quizzes <br>and different subject's tests. <em><b>Online quizzes</b></em> are a popular form of entertainment for web surfers. Online quizzes are generally for entertainment and knowledge purposes though some online quiz like us. Websites feature online quizzes on many subjects.<br><br>Mantra Quizzes are set up to actually test knowledge or identify a person's attributes. <br>Some companies use online quizzes as an efficient way of testing a potential hire's knowledge without that candidate needing to travel. Online dating services often use personality quizzes to find a match between similar members.</p></td>
                        </tr>
                 </table>  
              </div>
             
                <?php }?>

          </div>
      </body>
  </fieldset>
 </fieldset>

<?php
  include('loginfooter.html');
