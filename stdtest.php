
<?php

 error_reporting(0);
 session_start();
 
 
include('lib.php');
include('header.php');
  
  ?>
   <fieldset class="loginwall">

  <?php
     studenttest();   //calling studenttest function from lib.php 
  ?>
       
      <body>
         <div id="container">
              <form id="stdtest" action="stdtest.php" method="post">
                  <table id="menu" style="margin-left: 50%;"><tr style="float:right;">
                            
                        <?php
                           if (isset($_SESSION['stdname'])) {
                         ?>
                            
                            <td><input type="submit" value="HOME" name="dashboard" class="subbtn" title="Dash Board" style="color: #36AE79;height: 40px;width: 180px" /></td>
                            <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                             echo $_SESSION['stdname'];
                                 ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px"/></b></td>
                            
                    </tr>
                  </table>
                  
                
           <fieldset><legend><font color='black'  size="4"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">STUDENT TEST </b></font></legend>
                    
                    <div class="page">
                        
                    <?php
                            if ($_GLOBALS['message']) {
                                printmessage($_GLOBALS['message']);
                            }
                    
                            if(isset($_REQUEST['testcode'])){
                                echo "<br><div class=\"pmsg\" style=\"text-align:center;color:#36AE79;\"><b>What is the Code of " . $_SESSION['testname'] . " ? </b></div>";
                            }
                            
                            else{
                                echo "<br><div class=\"pmsg\" style=\"text-align:left;\"></div>";
                            }
                    
                            if (isset($_REQUEST['testcode']) || $display == true) {
                      ?>
                                <table cellpadding="30" cellspacing="10">
                                    <tr>
                                        <td>Enter Test Code</td>
                                        <td><input type="text" tabindex="1" name="tc" value="" size="25" /></td>
                                    </tr>
                                    <tr>
                                        <td><div class="help"><b>Note : </b></td><td><p style="color:#af0a36;">Once you press start test <br/> button timer will be started</p></div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right">
                                            <input type="submit" tabindex="3" value="Start Test" name="starttest" class="subbtn" style="color: #36AE79;height: 40px;width: 180px" />
                                        </td>
                                    </tr>
                                </table>
                    <?php
                            } 
                            
            else {
                   $result = $db->query("select t.*,s.subname from test as t, subject as s where s.subid=t.subid AND CURRENT_TIMESTAMP<t.testto and t.totalquestions=(select count(*) from question where testid=t.testid) AND t.testid=" . $_SESSION['testid'] . ";");// and NOT EXISTS(select stdid,testid from studenttest where testid=t.testid and stdid=" . $_SESSION['stdid'] . ")
               
                 if (mysql_num_rows($result) == 0) {
                       echo "Test ID : ".$_SESSION['testid'];
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
                               $db->_destruct();
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

