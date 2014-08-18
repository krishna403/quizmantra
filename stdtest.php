
<?php

error_reporting(0);
  session_start();
  include_once 'oesdb.php';
  include('header.php');
  
  
  ?>
<fieldset class="loginwall">


<?php
    if (!isset($_SESSION['stdname'])) {
        $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
    }
    
    else if (isset($_SESSION['starttime'])) {
        header('Location: testconducter.php');
    }

    else if (isset($_REQUEST['logout'])) {
       unset($_SESSION['stdname']);
       header('Location: index.php');
   }

    else if (isset($_REQUEST['dashboard'])) {
        header('Location: stdwelcome.php');
    }

      else if (isset($_REQUEST['starttest'])) {
    
        if (!empty($_REQUEST['tc'])) {
            $result = executeQuery("select testcode as tcode from test where testid=" . $_SESSION['testid'] . ";");

            if($r = mysql_fetch_array($result)) {
                
                if(strcmp(htmlspecialchars_decode($r['tcode'], ENT_QUOTES), htmlspecialchars($_REQUEST['tc'], ENT_QUOTES)) != 0) {
                    $display = true;
                    $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
                 }
            
                else{
                    
                $result=executeQuery("select * from question where testid=" . $_SESSION['testid'] . " order by qnid;");
                
                    if (mysql_num_rows($result) == 0) {
                        $_GLOBALS['message'] = "Tests questions cannot be selected.Please Try after some time!";
                    }
                
                    else {
                        
                        
                        $error = false;
                        
                        
                        $results=executeQuery("select stdid,testid from studenttest");
                           
                           while ($rs=mysql_fetch_array($results)){
                            
                               if($rs['stdid']==$_SESSION['stdid'] && $rs['testid']==$_SESSION['testid']){
                                   $bool=true;
                                   break;
                               }
                             }    
                                
                                
                         if($bool){      
                                
                            $resulta = executeQuery("select attemptid from studenttest where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . ";");
                                while ($ra=mysql_fetch_array($resulta)){

                                     $rem=(int)$ra['attemptid']%10;
                                     $rem++;
                                     $val=(int)$ra['attemptid']/10;
                                     $attempt=((int)$val*10+$rem);

                                } 
                          }
                          
                          else{
                               $attempt=$_SESSION['stdid'].$_SESSION['testid'].'1';
                          }
                             
                          $_SESSION['attempt']=$attempt;   
                     
                          
                        if(!executeQuery("insert into studenttest values(". $_SESSION['stdid'] . "," . $_SESSION['testid'] . ",(select CURRENT_TIMESTAMP),date_add((select CURRENT_TIMESTAMP),INTERVAL (select duration from test where testid=" . $_SESSION['testid'] . ") MINUTE),0,'inprogress',".(int)$attempt.")"))
                               $_GLOBALS['message'] = "error" . mysql_error();

                       
                        
                        else{
                                while($r = mysql_fetch_array($result)){
                                    
                                  //  $query="insert into studentquestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . "," . $r['qnid'] . ",'unanswered',NULL,".$_SESSION['attempt'].")";
                                 //   echo $query;
                                    
                                  if (!executeQuery("insert into studentquestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . "," . $r['qnid'] . ",'unanswered',NULL,".$_SESSION['attempt'].")")) {
                                     
                                     
                                      echo $_SESSION['stdid'] . " " . $_SESSION['testid'] . " " . $r['qnid']." ".$_SESSION['attempt'].',';
                                      $_GLOBALS['message'] = "Failure while preparing questions for you.Try again";
                                      $error = true;
                                    }
                                }
                                
                                if ($error==true){
                             
                                } 

                                else {
                                    
                                   // $query="select totalquestions,duration from test where testid=" . $_SESSION['testid'] . ";";
                                  //  echo $query;
                                   
                                            
                                    $result = executeQuery("select totalquestions,duration from test where testid=" . $_SESSION['testid'] . ";");
                                    $r = mysql_fetch_array($result);
                                    
                                    $_SESSION['tqn'] = htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES);
                                    $_SESSION['duration'] = htmlspecialchars_decode($r['duration'], ENT_QUOTES);
                                    
                                      
                                   // $query2="select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . "and attemptid=" . $_SESSION['attempt'] . ";";
                                  //  echo $query2;
                                    
                                 //  $var= "select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . " and attemptid=" . $_SESSION['attempt'] . ";";
                                 //  echo $var;
                                 //  exit;
                                   
                                   $result = executeQuery("select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . " and attemptid=" . $_SESSION['attempt'] . ";");
                                    $r = mysql_fetch_array($result);
                                    
                                    
                                    $_SESSION['starttime'] = $r['startt'];
                                    $_SESSION['endtime'] = $r['endt'];
                                    $_SESSION['qn'] = 1;
                                    
                                  //  echo $_SESSION['starttime'];
                                  //  echo $_SESSION['endtime'];
                                  //  exit;
                                 //   header('Location: home.php');
                                    header('Location: testconducter.php');
                                }
                        }
                        
                        
                }
            }
        }
        
        
        else {
            $display = true;
            $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
        }
        
    } 
    
    
    else {
            $display = true;
            $_GLOBALS['message'] = "Enter the Test Code First!";
        }

  }


   else if (isset($_REQUEST['testcode'])) {
   
      //  if ($r = mysql_fetch_array($result = executeQuery("select testid from test where testname='" . htmlspecialchars($_REQUEST['testcode'], ENT_QUOTES) . "';"))) {
            $_SESSION['testname'] = $_REQUEST['testcode'];
          //  $_SESSION['testid'] = $r['testid'];
        }
  // }

    else if (isset($_REQUEST['savem'])) {
   
        if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])) {
            $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
        }
    
        else {
            $query = "update student set stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "', stdpassword='" . htmlspecialchars($_REQUEST['password'], ENT_QUOTES) . "',emailid='" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "',contactno='" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "',address='" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "',city='" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "',pincode='" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "' where stdid='" . $_REQUEST['student'] . "';";
            if (!@executeQuery($query))
                $_GLOBALS['message'] = mysql_error();
            else
                $_GLOBALS['message'] = "Your Profile is Successfully Updated.";
         }
      closedb();
   }
  
  
  
 ?>
   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
   <html>
     <head>
        <title>Welcome</title>
        
        <link rel="stylesheet" type="text/css" href="sc.css"/>
        <script type="text/javascript" src="validate.js" ></script>
      </head>
       
       
      <body>
         <div id="container">
       
              <form id="stdtest" action="stdtest.php" method="post">
                
                  
                        <table id="menu"><tr style="float:right;">
                            
                        <?php
                           if (isset($_SESSION['stdname'])) {
                         ?>
                            
                            <td><input type="submit" value="HOME" name="dashboard" class="subbtn" title="Dash Board" style="color: #36AE79;height: 40px;width: 180px" /></td>
                            <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                             echo $_SESSION['stdname'];
                                 ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px"/></b></td>
                              

                        </tr></table>
                
           <fieldset><legend><font color='black'  size="4"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">TEST SESSION </b></font></legend>
                    
                    <div class="page">
                        
                    <?php
                            if ($_GLOBALS['message']) {
                                echo "<div class=\"message\">" . $_GLOBALS['message'] . "</div>";
                            }
                    ?>
                        
                        
                    <?php
                            if(isset($_REQUEST['testcode'])){
                                echo "<br><div class=\"pmsg\" style=\"text-align:center;\">What is the Code of " . $_SESSION['testname'] . " ? </div>";
                            }
                            
                            else{
                                echo "<br><div class=\"pmsg\" style=\"text-align:left;\"></div>";
                            }
                    ?>
                        
                        
                    <?php
                            if (isset($_REQUEST['testcode']) || $display == true) {
                      ?>
                                <table cellpadding="30" cellspacing="10">
                                    <tr>
                                        <td>Enter Test Code</td>
                                        <td><input type="text" tabindex="1" name="tc" value="" size="16" /></td>
                                        <td><div class="help"><b>Note:</b><br/>Once you press start test<br/>button timer will be started</div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <input type="submit" tabindex="3" value="Start Test" name="starttest" class="subbtn" />
                                        </td>
                                    </tr>
                                </table>


                    <?php
                            } 
                            
            else {
                $result = executeQuery("select t.*,s.subname from test as t, subject as s where s.subid=t.subid AND CURRENT_TIMESTAMP<t.testto and t.totalquestions=(select count(*) from question where testid=t.testid) AND t.testid=" . $_SESSION['testid'] . ";");// and NOT EXISTS(select stdid,testid from studenttest where testid=t.testid and stdid=" . $_SESSION['stdid'] . ")
               
                if (mysql_num_rows($result) == 0) {
                    echo $_SESSION['testid'];
                    echo"<h3 style=\"color:#0000cc;text-align:center;\">Sorry...! For this moment, You have not Offered to take any tests.</h3>";
                }

                else {

             ?>
                        
                        
                        <div id="linkdiv">
                
                  <table><tr>
                        <td style="padding-bottom: 0%;padding-left: 2%;padding-right: 40%;"><div style="width:90%; background-image:url(images/tree.jpg) ;height:370px; width:650px; background-size: 650px 450px"><p style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;"> <table cellpadding="15" cellspacing="10"><tr><td colspan="8" style="padding-left:60%;">Science</td></tr><tr><td colspan="3" style="padding-left:100%;">Computers</td><td colspan="2">History</td><td colspan="2">Languages</td></tr><tr><td colspan="2" style="padding-left:100%;">GK</td><td colspan="2">Programming</td><td colspan="2">Environment</td><td colspan="2">Aptitute</td></tr><tr><td colspan="3" style="padding-left:100%;">English</td><td colspan="2">Current GK</td><td colspan="3">Technology</td></tr></table><td>  <div></td>
                        
                           <td style="padding-left:35%;width:70%;" rowspan="2">
                              <div style="width:70%;height:80%;border:5px solid #000;padding-left:5%;border-color: #36AE79">                    
                           
                                
                                           
                                              
                                                
                                  <table cellpadding="8" class="datatable">
                                                      
                                     <tr><td><label style="font-size: 25px;">Overview : <hr></td></tr>
                                                  
                                       <tr><td colspan="2"><p><b>Rules and Regulations : </b>This Question Paper has no negative marking.only one option will be right. <p></td> </tr>
                                      
                        <?php
                                    while ($r = mysql_fetch_array($result)) {
                                        $i = $i + 1;
                                        if ($i % 2 == 0) {
                                            echo "<tr class=\"alt\">";
                                        } 
                                        
                                        else {
                                            echo "<tr>";
                                        }
                                        
                                        echo "<tr><td>". "<b>Test name : </b>". htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "</td></tr><tr><td>"."<b>Test Description : </b>" . htmlspecialchars_decode($r['testdesc'], ENT_QUOTES) . "</td></tr><tr><td>"."<b>Subject Name : </b>" . htmlspecialchars_decode($r['subname'], ENT_QUOTES)
                                        . "</td></tr><tr><td>"."<b>Duration : </b>" . htmlspecialchars_decode($r['duration'], ENT_QUOTES) . "</td></tr><tr><td>"."<b>Total Questions : </b>" . htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES) . "</td></tr>"
                                        . "<tr><td class=\"tddata\"><label><b>Start Test : </b></label><a title=\"Start Test\" href=\"stdtest.php?testcode=" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "\"><img src=\"images/button.gif\" height=\"50\" width=\"100\" alt=\"Start Test\" /></a></td></tr>";
                                    }
                        ?>
                                </table>
                                  
                               </tr>
                                           
                                 </table>
                                            
                                            
                                        
                            </div>       
                          </td>  
                       </tr>
                      <tr>
                          <td style="padding-bottom: 0%;padding-left: 2%;padding-right: 40%;"><div style="width:90%; background-image:url(images/whiteboardhome.jpg) ;height:320px; width:600px; background-size: 600px 320px"><p style="padding-top: 5%;padding-left: 5%;font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;"><em><b>Quiz Mantra</b></em> provides online quizzes <br>and different subject's tests. <em><b>Online quizzes</b></em> are a popular form of entertainment for web surfers. Online quizzes are generally for entertainment and knowledge purposes though some online quiz like us. Websites feature online quizzes on many subjects.<br><br>Mantra Quizzes are set up to actually test knowledge or identify a person's attributes. <br>Some companies use online quizzes as an efficient way of testing a potential hire's knowledge without that candidate needing to travel. Online dating services often use personality quizzes to find a match between similar members.</p></td>
                      </tr>
                 </table>  
           </div>
                        
                                 
                       <?php
                       
                                }
                                closedb();
                            }
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

