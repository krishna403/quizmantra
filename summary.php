
<?php
error_reporting(0);
session_start();

    
    include('lib.php');
    include('header.php');
?>

 <fieldset class="loginwall3">
 

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

        else if(isset($_REQUEST['change'])){
           $_SESSION['qn']=substr($_REQUEST['change'],7);
             header('Location: testconducter.php');
        }

        else if(isset($_REQUEST['finalsubmit'])){
           header('Location: testack.php');
           //  header('Location: testack.php');
        } 

         else if(isset($_REQUEST['fs'])){
          header('Location: testack.php');
        }

?>

    <script type="text/javascript" src="validate.js" ></script>
    <script type="text/javascript" src="cdtimer.js" ></script>
    <script type="text/javascript" >
    <!--
        <?php
                $elapsed=time()-strtotime($_SESSION['starttime']);
                if(((int)$elapsed/60)<(int)$_SESSION['duration'])
                {
                    $result= $db->query("select TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%H') as hour,TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%i') as min,TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%s') as sec from studenttest where stdid=".$_SESSION['stdid']." and testid=".$_SESSION['testid'].". and attemptid=".$_SESSION['attempt'].";");
                    if($rslt=mysql_fetch_array($result))
                    {
                     echo "var hour=".$rslt['hour'].";";
                     echo "var min=".$rslt['min'].";";
                     echo "var sec=".$rslt['sec'].";";
                    }
                    else
                    {
                        $_GLOBALS['message']="Try Again";
                    }
                    $db->_destruct();
                }
                else
                {
                    echo "var sec=01;var min=00;var hour=00;";
                }
        ?>

    -->
    </script>

    
  <body >
      
      <div id="container">
     
        <form id="summary" action="summary.php" method="post">
            <div class="menubar">

         <?php 
             if(isset($_SESSION['stdname'])) {
                          // Navigations
         ?>
           </div>
            
     
     <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">TEST SUMMARY</b></font> </legend>
         
       
      <div class="page">
                 <table border="0" width="100%" class="ntab" align="center">
                  <tr>
                      <th style="width:40%;"><h3><span id="timer" class="timerclass"></span></h3></th>
                      
                  </tr>
                 </table>
          
            <?php
                    if($_GLOBALS['message']) {
                       printmessage($_GLOBALS['message']);
                     }
           ?>
          
          <?php

                        $result= $db->query("select * from studentquestion where testid=".$_SESSION['testid']." and stdid=".$_SESSION['stdid'].". and attemptid=".$_SESSION['attempt']." order by qnid ;");
                        if(mysql_num_rows($result)==0) {
                          echo"<h3 style=\"color:#0000cc;text-align:center;\">Please Try Again.</h3>";
                        }
                        else
                        {
                           //editing components
                 ?>
          <table cellpadding="30" cellspacing="10" class="datatable" align="center">
                        <tr>
                            <th>Question No</th>
                            <th>Status</th>
                            <th>Change Your Answer</th>
                       </tr>
        <?php
                        while($r=mysql_fetch_array($result)) {
                                    $i=$i+1;
                                    if($i%2==0)
                                    {
                                    echo "<tr class=\"alt\">";
                                    }
                                    else{ echo "<tr>";}
                                    echo "<td>".$r['qnid']."</td>";
                                    if(strcmp(htmlspecialchars_decode($r['answered'],ENT_QUOTES),"unanswered")==0 ||strcmp(htmlspecialchars_decode($r['answered'],ENT_QUOTES),"review")==0)
                                    {
                                        echo "<td style=\"color:#ff0000\">".htmlspecialchars_decode($r['answered'],ENT_QUOTES)."</td>";
                                    }
                                    else
                                    {
                                        echo "<td>".htmlspecialchars_decode($r['answered'],ENT_QUOTES)."</td>";
                                    }
                                    echo"<td><input type=\"submit\" value=\"Change ".$r['qnid']."\" name=\"change\" class=\"ssubbtn\"style='color: #36AE79;height: 35px;width: 120px' /></td></tr>";
                                }

                                ?>
              <tr>
                  <td colspan="3" style="text-align:center;"><input type="submit" name="finalsubmit" value="Final Submit" class="subbtn" style="color: #36AE79;height: 40px;width: 180px"/></td>
              </tr>
                    </table>
                            <?php
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

