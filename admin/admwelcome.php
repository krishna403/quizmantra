<?php


session_start();
        if(!isset($_SESSION['admname'])){
            $_GLOBALS['message']="Session Timeout.Click here to <a href=\"../index.php\">Re-LogIn</a>";
        }
        else if(isset($_REQUEST['logout'])){
           unset($_SESSION['admname']);
            $_GLOBALS['message']="You are Loggged Out Successfully.";
            header('Location: ../index.php');
        }
        
     include('../header.php')   
?>

 <fieldset class='loginwall'>

<html>
    <head>
        <title>Admin Home</title>
        <link rel="stylesheet" type="text/css" href="sc.css"/>
    </head>
    <body>
        
        <div id="container">
            
            <div class="menubar" style="padding-left: 50%">

                
                
            <table>
              <tr>
                  <td><a href="rating.php" name="logout"><button id="signin" style="color: #36AE79;height: 40px;width: 180px">Rate US</button></a></td> 
                    <td> <a href="contact.php" name="datahistory"><button id="contactbutt" style="color: #36AE79;height: 40px;width: 180px">Contact US</button></a></td>
               
         
                         <form name="admwelcome" action="admwelcome.php" method="post">
                    
                               <?php if(isset($_SESSION['admname'])){ ?>
                     
                                <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                             echo $_SESSION['admname'];
                                                                                    
                
                                               ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px" /></b></td>
                               <?php } ?>
                   
                       </form>
              
               </tr>
           </table>
          </div>
                
           <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">WELCOME ADMIN</b></font> </legend>   
                
           
            <div class="admpage">
                  <?php
                      if(isset($_GLOBALS['message'])) {
                          echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
                       }
                  ?>
            
                
                <?php if(isset($_SESSION['admname'])){ ?>

                    <table><tr>
                        <td><input type="image" src="images/teacher-cartoon.jpg" height="300" width="600"></td><td style="padding-bottom: 3%;padding-left: 1%; background-image:url(images/chat.png) ;height:200px; width:400px; background-size: 180px 300px"><p style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;"> hiii! Welcome to  QuizMantra. Here You can enjoy the quiz Tests. Multiple categories of subjects and each of have different questions.</p></td>
                        
                           <td style="padding-left:25%;width:60%" rowspan="2">
                              <div style="width:50%;height:80%;border:5px solid #000;padding-left:15%;border-color: #36AE79">                    
                           
                                
                                        <table cellspacing="">
                         
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="usermng.php"><input type="button" value="USER MANAGE" style="color: #36AE79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="submng.php"><input type="button" value="SUBJECT MANAGE" style="color: #36AE19;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="rsltmng.php"><input type="button" value="RESULT MANAGE" style="color: #31AE79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="testmng.php?forpq=true"><input type="button" value="ADD QUESTIONS" style="color: #36AE70;height: 70px;width: 250px;font-size: 21px;"></a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="padding-top: 20px" id='c1'><a href="testmng.php"><input type="button" value="TEST MANAGE" style="color: #36AF79;height: 70px;width: 250px;font-size: 23px;"></a></td>
                                                </tr>
                                            
                            
                                        </table>
                               </div>       
                          </td>  
                       </tr>
                       <tr>
                             <td style="padding-bottom:3%;padding-left: 1%; background-image:url(images/whiteboardhome.jpg) ;height:250px; width:270px; background-size: 600px 350px"><p style="padding-bottom: 15%;font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;"><em><b>Quiz Mantra</b></em> provides online quizzes <br>and different subject's tests. <em><b>Online quizzes</b></em> are a popular form of entertainment for web surfers. Online quizzes are generally for entertainment and knowledge purposes though some online quiz like us. Websites feature online quizzes on many subjects.<br><br>Mantra Quizzes are set up to actually test knowledge or identify a person's attributes. <br>Some companies use online quizzes as an efficient way of testing a potential hire's knowledge without that candidate needing to travel. Online dating services often use personality quizzes to find a match between similar members.</p></td>
                        </tr>
                 </table> 
                   
                <?php }?>

            </div>

      </div>
    </body>
  </fieldset>
 </fieldset>
  
  
<?php
  include('../loginfooter.html');
