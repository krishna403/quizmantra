
<?php

error_reporting(0);
session_start();

  include('lib.php');
  include('header.php');
  ?>

 <fieldset class="loginwall3">
 <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">TEST STARTED</b></font> </legend>

<?php
      
      $final=false;
      testconductor();
 
 ?>

    <?php
    header("Cache-Control: no-cache, must-revalidate");
    ?>
    <script type="text/javascript" src="validate.js" ></script>
    <script type="text/javascript" src="cdtimer.js" ></script>
    <script type="text/javascript" >
    <!--
        <?php
                $elapsed=time()-strtotime($_SESSION['starttime']);
                if(((int)$elapsed/60)<(int)$_SESSION['duration'])
                {
                    $result=$db->query("select TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%H') as hour,TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%i') as min,TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%s') as sec from studenttest where stdid=".$_SESSION['stdid']." and testid=".$_SESSION['testid'].". AND attemptid=".$_SESSION['attempt'].";");
                  
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

    </head>
  <body>
      
       <?php

        if($_GLOBALS['message']) {
            printmessage($_GLOBALS['message']);
           }
        ?>
      <div id="container">
      
         <form id="testconducter" action="testconducter.php" method="post">
            <div class="menubar" style="text-align:center;">
                <h2 style="font-family:helvetica,sans-serif;font-weight:bolder;font-size:120%;color:#f50000;padding-top:0.3em;letter-spacing:1px;">QUIZ MANTRA : TEST EXECUTION</h2>
            </div>
        <div class="page">
           
          <?php
         
          if(isset($_SESSION['stdname']))
          {
                $result=$db->query("select stdanswer,answered from studentquestion where stdid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn'].". AND attemptid=".$_SESSION['attempt'].";");
                $r1=mysql_fetch_array($result);
                
                $result=$db->query("select * from question where testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn'].";");
                $r=mysql_fetch_array($result);
          ?>
          <div class="tc">

              <table border="0" width="100%" class="ntab">
                  <tr>
                      <th style="width:40%;"><h3><span id="timer" class="timerclass"></span></h3></th>
                      <th style="width:40%;"><h4 style="color: #af0a36;">Question No: <?php echo $_SESSION['qn']; ?> </h4></th>
                      <th style="width:20%;"><h4 style="color: #af0a36;"><input type="checkbox" name="markreview" value="mark"> Mark for Review</input></h4></th>
                  </tr>
              </table>
              
             <textarea cols="100" rows="8" name="question" readonly style="width:96.8%;text-align:left;margin-left:2%;margin-top:2px;font-size:120%;font-weight:bold;margin-bottom:0;color:#0000ff;padding:2px 2px 2px 2px;"><?php echo htmlspecialchars_decode($r['question'],ENT_QUOTES); ?></textarea>
             
             <table border="0" width="100%" class="ntab">
                  <tr><td>&nbsp;</td></tr>
                  <tr><td >1. <input type="radio" name="answer" value="optiona" <?php if((strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"review")==0 ||strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"answered")==0)&& strcmp(htmlspecialchars_decode($r1['stdanswer'],ENT_QUOTES),"optiona")==0 ){echo "checked";} ?>> <?php echo htmlspecialchars_decode($r['optiona'],ENT_QUOTES); ?></input></td></tr>
                  <tr><td >2. <input type="radio" name="answer" value="optionb" <?php if((strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"review")==0 ||strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"answered")==0)&& strcmp(htmlspecialchars_decode($r1['stdanswer'],ENT_QUOTES),"optionb")==0 ){echo "checked";} ?>> <?php echo htmlspecialchars_decode($r['optionb'],ENT_QUOTES); ?></input></td></tr>
                  <tr><td >3. <input type="radio" name="answer" value="optionc" <?php if((strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"review")==0 ||strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"answered")==0)&& strcmp(htmlspecialchars_decode($r1['stdanswer'],ENT_QUOTES),"optionc")==0 ){echo "checked";} ?>> <?php echo htmlspecialchars_decode($r['optionc'],ENT_QUOTES); ?></input></td></tr>
                  <tr><td >4. <input type="radio" name="answer" value="optiond" <?php if((strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"review")==0 ||strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"answered")==0)&& strcmp(htmlspecialchars_decode($r1['stdanswer'],ENT_QUOTES),"optiond")==0 ){echo "checked";} ?>> <?php echo htmlspecialchars_decode($r['optiond'],ENT_QUOTES); ?></input></td></tr>
                  <tr><td>&nbsp;</td></tr>
                  
                  <tr><th style="width:12%;text-align:right;"><h4><input type="submit" name="previous" value="Previous" class="subbtn" style="color: #36AE79;height: 40px;width: 180px"/></h4></th>
                      <th style="width:80%;"><h4><input type="submit" name="<?php if($final==true){
                                                                     echo "viewsummary" ;
                                                                 }
                                                                else{
                                                                     echo "next";
                                                                     
                                                                } ?>" value="<?php if($final==true){ 
                                                                                  echo "View Summary" ;
                                                                                  
                                                                                }
                                                                                else{ 
                                                                                    echo "Next";
                                                                                    
                                                                                } ?>" class="subbtn" style="color: #36AE79;height: 40px;width: 180px" /></h4></th>
                      
                      <th style="width:8%;text-align:right;"><h4><input type="submit" name="summary" value="Summary" class="subbtn" style="color: #36AE79;height: 40px;width: 180px" /></h4></th>
                  </tr>
                  
              </table>
              

          </div>
          <?php
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

