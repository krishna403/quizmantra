
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

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
  
  else if(isset($_REQUEST['logout'])) {
        unset($_SESSION['stdname']);
        header('Location: index.php');
    } 
    
    else if(isset($_REQUEST['dashboard'])) {
            header('Location: stdwelcome.php');
        }
        
        else if(isset($_REQUEST['resume'])){
                if($r=mysql_fetch_array($result=executeQuery("select testname from test where testid=".$_REQUEST['resume'].";"))) {
                    $_SESSION['testname']=htmlspecialchars_decode($r['testname'],ENT_QUOTES);
                    $_SESSION['testid']=$_REQUEST['resume'];
                }
            }
            
            else if(isset($_REQUEST['resumetest'])){
                
                    if(!empty($_REQUEST['tc'])){
                        $result=executeQuery("select testcode as tcode from test where testid=".$_SESSION['testid'].";");

                        if($r=mysql_fetch_array($result)) {
                            
                            if(strcmp(htmlspecialchars_decode($r['tcode'],ENT_QUOTES),htmlspecialchars($_REQUEST['tc'],ENT_QUOTES))!=0) {
                                $display=true;
                                $_GLOBALS['message']="You have entered an Invalid Test Code.Try again.";
                            }
                            
                            else{
                                $result=executeQuery("select totalquestions,duration from test where testid=".$_SESSION['testid'].";");
                                $r=mysql_fetch_array($result);
                               
                                $_SESSION['tqn']=htmlspecialchars_decode($r['totalquestions'],ENT_QUOTES);
                                $_SESSION['duration']=htmlspecialchars_decode($r['duration'],ENT_QUOTES);
                              
                                $result=executeQuery("select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=".$_SESSION['testid']." and stdid=".$_SESSION['stdid'].". and attemptid=".$_SESSION['attempt'].";");
                                $r=mysql_fetch_array($result);
                              
                                $_SESSION['starttime']=$r['startt'];
                                $_SESSION['endtime']=$r['endt'];
                                $_SESSION['qn']=1;
                                header('Location: testconducter.php');
                            }

                        }
                        else {
                            $display=true;
                            $_GLOBALS['message']="You have entered an Invalid Test Code.Try again.";
                        }
                    }
                    else {
                        $display=true;
                        $_GLOBALS['message']="Enter the Test Code First!";
                    }
                }


?>

<html>
    <head>
        <title>Resume Test</title>
        <link rel="stylesheet" type="text/css" href="sc.css"/>
        <script type="text/javascript" src="validate.js" ></script>
    </head>
    
    
    <body>
       
         <div id="container">
                
             <form id="summary" action="resumetest.php" method="post">
                 
                 <div class="menubar" style="margin-left: 60%;">
                      
                     <table id="menu"><tr>
           

             <?php if(isset($_SESSION['stdname'])) {
              ?>
                            <td><input type="submit" value="HOME" name="dashboard" class="subbtn" title="Dash Board" style="color: #36AE79;height: 40px;width: 180px" /></td>
                            <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                             echo $_SESSION['stdname'];
                                 ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px"/></b></td>
                              

                        </tr>
                      </table>

                    </div>
                 
          
      <fieldset><legend><font color='black'  size="4"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">TEST RESUME </b></font></legend>       
           
          <div class="page">
                     
                    <?php
                             if($_GLOBALS['message']) {
                                echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
                             }
                    ?>
              

                    <?php
                    if(isset($_REQUEST['resume'])) {
                        echo "<div class=\"pmsg\" style=\"text-align:center;\">What is the Code of ".$_SESSION['testname']." ? </div>";
                    }
                    else {
                        echo "<div class=\"pmsg\" style=\"text-align:center;\">Tests to be Resumed</div>";
                    }
                    ?>
                        <?php
                           if(isset($_REQUEST['resume'])|| $display==true) {
                               
                           ?>
                            <table cellpadding="30" cellspacing="10">
                                <tr>
                                    <td>Enter Test Code</td>
                                    <td><input type="text" tabindex="1" name="tc" value="" size="16" /></td>
                                    <td><div class="help"><b>Note:</b><br/>Quickly enter Test Code and<br/> press Resume button to utilize<br/> Remaining time.</div></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <input type="submit" tabindex="3" value="Resume Test" name="resumetest" class="subbtn" />
                                    </td>
                                </tr>
                            </table>


               <?php
                        }
       
                    else {

                         $result=executeQuery("select t.testid,t.testname,DATE_FORMAT(st.starttime,'%d %M %Y %H:%i:%s') as startt,sub.subname as sname,TIMEDIFF(st.endtime,CURRENT_TIMESTAMP) as remainingtime from subject as sub,studenttest as st,test as t where sub.subid=t.subid and t.testid=st.testid and st.stdid=".$_SESSION['stdid']." and st.status='inprogress' order by st.starttime desc;");
                         if(mysql_num_rows($result)==0) {
                            echo"<h3 style=\"color:#0000cc;text-align:center;\">There are no incomplete exams, that needs to be resumed! Please Try Again..!</h3>";
                           }
                            
                        else {
                ?>
                        <table cellpadding="30" cellspacing="10" class="datatable">
                            <tr>
                                <th>Date and Time</th>
                                <th>Test</th>
                                <th>Subject</th>
                                <th>Remaining Time</th>
                                <th>Resume</th>
                            </tr>
                            
                               <?php
                              while($r=mysql_fetch_array($result)) {
                                        $i=$i+1;
                                        if($r['remainingtime']<0) {
                         //IF Suppose MySQL Event fails for some reasons to change status this condtion becomes true.

                       //   executeQuery("update studenttest set status='over' where stdid=".$_SESSION['stdid']." and testid=".$r['testid'].";");
                       //      continue ;
                                         }

                                        if($i%2==0){
                                            echo "<tr class=\"alt\">";
                                        }
                                        else{ 
                                           echo "<tr>";
                                        }
                                        
                                            echo "<td>".$r['startt']."</td><td>".htmlspecialchars_decode($r['testname'],ENT_QUOTES)."</td><td>".htmlspecialchars_decode($r['sname'],ENT_QUOTES)."</td><td>".$r['remainingtime']."</td>";
                                            echo"<td class=\"tddata\"><a title=\"Resume\" href=\"resumetest.php?resume=".$r['testid']."\"><img src=\"images/resume.png\" height=\"30\" width=\"60\" alt=\"Resume\" /></a></td></tr>";
                                }

                                ?>
                        </table>
                                <?php
                              }

                      }

                    closedb();
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

