
  <?php
      error_reporting(0);
      session_start();
      
      include('lib.php');
      include('header.php');
      
   ?>
       <fieldset class='loginwall'>
                  
    <?php
    
      if(isset($_REQUEST['register'])){
         // relocateHeader('register.php');
      }
      
      else if($_REQUEST['stdsubmit']){
          relocateHeader('');
      }

 ?>
           
           <div class="menubar" style="padding-left: 50%;">
                             <table id="menu"><tr>
                                        <?php
                                        
                                        if(isset($_SESSION['stdname'])){
                                            relocateHeader('stdwelcome.php');
                                          }

                                        else{    
                                         ?>
                                               <td><div class="aclass"><a href="home.php" title="Back To Home"><button id="signin" style="color: #36AE79;height: 40px;width: 180px">Home</button></a></div></td>
                                              <td><div class="aclass"><a href="register.php" title="Click here  to Register"><button id="signin" style="color: #36AE79;height: 40px;width: 180px">Register</button></a></div></td>
                                              <td><a href="rating.php" name="logout"><button id="signin" style="color: #36AE79;height: 40px;width: 180px">Rate US</button></a></td> 
                                              <td> <a href="contact.php" name="datahistory"><button id="contactbutt" style="color: #36AE79;height: 40px;width: 180px">Contact US</button></a></td>

                                        <?php
                                              }
                                        ?>
                              </table>
                          </div>
           
     <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">LOGIN </b></font> </legend>

    
      <body id="register">
                <?php

                  if($_GLOBALS['message']){
                      printmessage($_GLOBALS['message']);
                  }
                ?>

                   
              <div id="container">
               <form id="stdloginform" action="index.php" method="post">
                   
                          <div class="page">

                             <table cellpadding="10" cellspacing="10">
                                        
                                 <tr>  
                                     <td rowspan="4" style="padding-right:600px; padding-left: 40px;">
                                        <img src="images/whiteboard.jpg" alt="Molecule Wallpaper" width="600" height="430" />

                                               </td>
                                      </tr>
                                    <tr>
                                        <td>User Name</td>
                                        <td><input type="text" tabindex="1" name="name" value="" size="30" /></td>

                                    </tr>
                                    <tr>
                                        <td>Password</td>
                                        <td><input type="password" tabindex="2" name="password" value="" size="30" /></td>
                                    </tr>

                                    <tr>
                                        <td style="padding-bottom: 200px; padding-right: 8%;" colspan="2">
                                            <input type="submit" tabindex="3" value="Log In" name="stdsubmit" class="subbtn" style="color: #36AE79;height: 40px;width: 180px" /> |
                                            <a href=index.php> Reset</a>
                                        </td><td></td>
                                    </tr>
                                 </table>
                           </div>
                  </form>

               </div>
          </body>
     </fieldset>
  </fieldset>
                              
 <?php
    include("loginfooter.html");
