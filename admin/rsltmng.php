<?php
error_reporting(0);
session_start();

include('../lib.php');
include('../header.php');


$attemptarr=array();
$colums=array();
?>

<fieldset class='loginwall3'>

<?php

  if(!isset($_SESSION['admname']) && !isset($_SESSION['tcname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
   }
   
   else if(isset($_REQUEST['logout'])) {
        
        
        if(isset($_SESSION['tcname'])){
            unset($_SESSION['tcname']);
            unset($_SESSION['stdname']);
        }
        
       else
         unset($_SESSION['admname']);
       
        header('Location: ../index.php');
    }
    
    else if(isset($_REQUEST['dashboard'])){
            // $_SESSION['bool']=1;
        if(isset($_SESSION['tcname'])){
           header('Location: ../stdwelcome.php?flip=1');
        }
        
        else
            header('Location: ../stdwelcome.php');
      }
        
        else if(isset($_REQUEST['back'])){
                header('Location: rsltmng.php');

            }

  ?>
    <body>
        
       
        
        
      
        <div id="container">
            
            <form name="rsltmng" action="rsltmng.php" method="post">
                <div class="menubar" style="padding-left: 40%;">


                    <table id="menu"><tr>
                        
                        
                          <?php 
                              if(isset($_SESSION['admname']) || isset($_SESSION['tcname']) ) {
                          
                             if(isset($_REQUEST['testid'])) {
                           ?>
                               <td><input type="submit" value="Back" name="back" class="subbtn" title="Manage Results" style="color: #36AE79;height: 40px;width: 180px" /></td>
                        
                          <?php 
                             }
                            else{ 
                                
                                if($_SESSION['tcname']){
                                ?>
                               <td><input type="submit" value="TEACHER HOME" name="dashboard" class="subbtn" title="Dash Board" style="color: #36AE79;height: 40px;width: 180px" /></td>
                                
                                   <?php
                                }
                                
                                 else {?>
                               <td><input type="submit" value="ADMIN HOME" name="dashboard" class="subbtn" title="Dash Board" style="color: #36AE79;height: 40px;width: 180px" /></td>
                               <?php
                                 }
                            } 
                            ?>
                            <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                            if(isset($_SESSION['admname'])){
                                                                                             echo $_SESSION['admname'];
                                                                                            }
                                                                                            
                                                                                            else if($_SESSION['tcname']){
                                                                                               echo $_SESSION['tcname']; 
                                                                                            }
                                       ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px" /></b></td>
                        <?php
                            ?>
                               
                               
                    </tr></table>
                </div>
                
              <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">MANAGE RESULT</b></font> </legend>    
                <div class="page">
                        <?php
                        
                            if($_GLOBALS['message']){
                               echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
                            }
                        
                        
                        if(isset($_REQUEST['testid'])){
                            
                            $result=$db->query("select t.testname,DATE_FORMAT(t.testfrom,'%d %M %Y') as fromdate,DATE_FORMAT(t.testto,'%d %M %Y %H:%i:%S') as todate,sub.subname,IFNULL((select sum(marks) from question where testid=".$_REQUEST['testid']."),0) as maxmarks from test as t, subject as sub where sub.subid=t.subid and t.testid=".$_REQUEST['testid'].";") ;
                            if(mysql_num_rows($result)!=0) {

                                $r=mysql_fetch_array($result);
                                ?>
                        <table cellpadding="20" cellspacing="30" border="0" align="center" style="background:#ffffff url(../images/page.gif);text-align:left;line-height:20px;">
                            <tr>
                                <td colspan="2"><h3 style="color:#0000cc;text-align:center;">Test Summary</h3></td>
                            </tr>
                            <tr>
                                <td colspan="2" ><hr style="color:#ff0000;border-width:4px;"/></td>
                            </tr>
                            <tr>
                                <td>Test Name</td>
                                <td><?php echo htmlspecialchars_decode($r['testname'],ENT_QUOTES); ?></td>
                            </tr>
                            <tr>
                                <td>Subject Name</td>
                                <td><?php echo htmlspecialchars_decode($r['subname'],ENT_QUOTES); ?></td>
                            </tr>
                            <tr>
                                <td>Validity</td>
                                <td><?php echo $r['fromdate']." To ".$r['todate']; ?></td>
                            </tr>
                            <tr>
                                <td>Max. Marks</td>
                                <td><?php echo $r['maxmarks']; ?></td>
                            </tr>
                            <tr><td colspan="2"><hr style="color:#ff0000;border-width:2px;"/></td></tr>
                            <tr>
                                <td colspan="2"><h3 style="color:#0000cc;text-align:center;">Attempts</h3></td>
                            </tr>
                            <tr>
                                <td colspan="2" ><hr style="color:#ff0000;border-width:4px;"/></td>
                            </tr>

                        </table>
                                <?php
                                 $i=0;
                                $stdid=$db->query("SELECT DISTINCT stdid FROM studenttest WHERE testid=".$_REQUEST['testid'].";");
                                
                                 while($std=mysql_fetch_array($stdid)) {
                                     //echo $std['stdid'];
                                  
                                
                               
                                $attempt=$db->query("SELECT DISTINCT attemptid from studentquestion where testid=".$_REQUEST['testid']." and stdid=".$std['stdid'].";");
                                 while($rq=mysql_fetch_array($attempt)) {
                                     echo "att id ".$rq['attemptid'];
                                     $attemptarr[$i]=$rq['attemptid'];
                                     $i++;
                                  }
                                  
                               }
                                 $lengthofatt=count($attemptarr);
                                 ?>
                    
                             <table cellpadding="30" cellspacing="10" class="datatable" align="center">
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Email-ID</th>
                                                <th>Obtained Marks</th>
                                                <th>Result(%)</th>
                                                <th>Attempt</th>

                                 </tr>
                    
                              <?php
                                 
                                 for($i=0;$i<$lengthofatt;$i++){
                                   $atte=$i+1;
                                 $result1=$db->query("select s.stdname,s.emailid,IFNULL((select sum(q.marks) from studentquestion as sq,question as q where q.qnid=sq.qnid and sq.testid=".$_REQUEST['testid']." and sq.stdid=st.stdid and sq.stdanswer=q.correctanswer and sq.attemptid=".$attemptarr[$i]."),0) as om from studenttest as st, student as s where s.stdid=st.stdid and st.testid=".$_REQUEST['testid']." and st.attemptid=".$attemptarr[$i].";" );
                                         
                               
                                   if(mysql_num_rows($result1)==0){
                                        echo "</table><h3 style=\"color:#0000cc;text-align:center;\">No More Students Yet Attempted this Test!</h3>";
                                     }
                                     
                                else{
                                      while($r1=mysql_fetch_array($result1)) {

                                                                ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars_decode($r1['stdname'],ENT_QUOTES); ?></td>
                                                <td><?php echo htmlspecialchars_decode($r1['emailid'],ENT_QUOTES); ?></td>
                                                <td><?php echo $r1['om']; ?></td>
                                                <td><?php echo ($r1['om']/$r['maxmarks']*100)." %"; ?></td>
                                                <td><?php echo $atte; ?></td>

                                            </tr>
                                                            <?php
                                                }
                                      }
                                   }
                                }
                                
                              
                             ?>
                                     </table>
                        <?php
                     }
                  
                   else {
                       
                       if(isset($_SESSION['tcname'])){
                            $result= $db->query("select t.testid,t.testname,DATE_FORMAT(t.testfrom,'%d %M %Y') as fromdate,DATE_FORMAT(t.testto,'%d %M %Y %H:%i:%S') as todate,sub.subname,(select count(stdid) from studenttest where testid=t.testid) as attemptedstudents from test as t, subject as sub where sub.subid=t.subid and t.teacherid=".$_SESSION['tcid'].";");
                       }
                       
                       else
                          $result=$db->query("select t.testid,t.testname,DATE_FORMAT(t.testfrom,'%d %M %Y') as fromdate,DATE_FORMAT(t.testto,'%d %M %Y %H:%i:%S') as todate,sub.subname,(select count(stdid) from studenttest where testid=t.testid) as attemptedstudents from test as t, subject as sub where sub.subid=t.subid;");
                             
                             if(mysql_num_rows($result)==0) {
                                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Tests Yet...!</h3>";
                                }
                                
                                else {
                                                    $i=0;

                                                ?>
                                    <table cellpadding="30" cellspacing="10" class="datatable">
                                        <tr>
                                            <th>Test Name</th>
                                            <th>Validity</th>
                                            <th>Subject Name</th>
                                            <th>Attempts</th>
                                            <th>Details</th>
                                        </tr>
                                                 <?php
                                                    while($r=mysql_fetch_array($result)) {
                                                        $i=$i+1;
                                                        if($i%2==0) {
                                                            echo "<tr class=\"alt\">";
                                                        }
                                                        else { echo "<tr>";}
                                                        echo "<td>".htmlspecialchars_decode($r['testname'],ENT_QUOTES)."</td><td>".$r['fromdate']." To ".$r['todate']." PM </td>"
                                                            ."<td>".htmlspecialchars_decode($r['subname'],ENT_QUOTES)."</td><td>".$r['attemptedstudents']."</td>"
                                                            ."<td class=\"tddata\"><a title=\"Details\" href=\"rsltmng.php?testid=".$r['testid']."\"><img src=\"../images/detail.png\" height=\"30\" width=\"40\" alt=\"Details\" /></a></td></tr>";
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
   include('../loginfooter.html');

