
<?php

error_reporting(0);
session_start();

include('lib.php');
include('header.php');
?>

<fieldset class="loginwall">
    
 <?php  
    
       resumetest();
  
 ?>
    
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
                 
          
      <fieldset><legend><font color='black'  size="4"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">RESUME TEST </b></font></legend>       
           
          <div class="page">
                     
                    <?php
                             if($_GLOBALS['message']) {
                                 printmessage($_GLOBALS['message']);
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

                         $result=$db->query("select t.testid,t.testname,DATE_FORMAT(st.starttime,'%d %M %Y %H:%i:%s') as startt,sub.subname as sname,TIMEDIFF(st.endtime,CURRENT_TIMESTAMP) as remainingtime from subject as sub,studenttest as st,test as t where sub.subid=t.subid and t.testid=st.testid and st.stdid=".$_SESSION['stdid']." and st.status='inprogress' order by st.starttime desc;");
                      
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
                         // if MySQL Event fails then change status this condtion becomes true.

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

                    $db->_destruct();
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

