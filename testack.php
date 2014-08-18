<?php

error_reporting(0);
session_start();
include_once 'oesdb.php';
include('header.php');

?>
   <fieldset class="loginwall">
    
 <?php

    if(!isset($_SESSION['stdname'])) {
        $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
    }
    else if(isset($_REQUEST['logout'])){
        unset($_SESSION['stdname']);
        header('Location: index.php');
    }
    else if(isset($_REQUEST['dashboard'])){
         header('Location: stdwelcome.php');
    }

    if(isset($_SESSION['starttime'])){
        unset($_SESSION['starttime']);
        unset($_SESSION['endtime']);
        unset($_SESSION['tqn']);
        unset($_SESSION['qn']);
        unset($_SESSION['duration']);

        executeQuery("update studenttest set status='over' where testid=".$_SESSION['testid']." and stdid=".$_SESSION['stdid'].". and attemptid=".$_SESSION['attempt'].";");
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>Test Acknowledgment</title>
    <link rel="stylesheet" type="text/css" href="sc.css"/>
    <script type="text/javascript" src="validate.js" ></script>
    </head>
  <body >
       
      <div id="container">
      
           <form id="editprofile" action="editprofile.php" method="post">
               
          <div class="menubar">
               <div class="menubar">
                      
                     <table id="menu" style="padding-left: 60%;"><tr>
           

             <?php if(isset($_SESSION['stdname'])) {
              ?>
                            <td><input type="submit" value="HOME" name="dashboard" class="subbtn" title="Dash Board" style="color: #36AE79;height: 40px;width: 180px" /></td>
                            <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                             echo $_SESSION['stdname'];
                                 ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px"/></b></td>
                              

                        </tr></table>


                    </div>
          </div>
               
          <fieldset><legend><font color='black'  size="4"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">TEST SESSION </b></font></legend>   
            <div class="page">
                <?php
                             if($_GLOBALS['message']) {
                                echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
                             }
                    ?>
                
                <h3 style="color:#0000cc;text-align:center;">Your answers are Successfully Submitted. To view the Results <b><a href="viewresult.php">Click Here</a></b> </h3>
                <?php
                              }
                ?>
            </div>

           </form>
    
      </div>
  </body>
</fieldset>
</fieldset>
<?php
  include('loginfooter.html');

