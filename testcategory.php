<?php

error_reporting(0);
  session_start();
  
  include('lib.php');
  include('header.php');
  
  
  ?>
<fieldset class="loginwall">

<?php
   
  testcategory();
 ?>    
        
    <body>
         <div id="container">
       
              <form id="stdtest" action="testcategory.php" method="post">
                  <div style="margin-left: 60%;">
                 <table id="menu"><tr style="float:right;">
                            
                    <?php
                       if (isset($_SESSION['stdname'])){
                     ?>
                            
                            <td><input type="submit" value="HOME" name="dashboard" class="subbtn" title="Dash Board" style="color: #36AE79;height: 40px;width: 180px" /></td>
                            <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                             echo $_SESSION['stdname'];
                                 ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px"/></b></td>
                              

                        </tr></table>
                   </div>
                    
                </form>
                
            <fieldset><legend><font color='black'  size="4"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">TEST CATEGORY</b></font></legend> 
         
                   
                    <div class="page">

                                    <?php
                                        if ($_GLOBALS['message']){
                                            printmessage($_GLOBALS['message']);
                                        }
                                     ?>


                                     <script language=JavaScript>
                                             function reload(form) {
                                             var val=form.cat.options[form.cat.options.selectedIndex].value;
                                             self.location='testcategory.php?cat=' + val ;
                                             }
                                     </script>

                                  <table cellpadding="10" cellspacing="10">

                                      <tr>  
                                            <td rowspan="4" style="padding-right:600px; padding-left: 40px;">
                                               <img src="images/whiteboard.jpg" alt="Molecule Wallpaper" width="600" height="430" />

                                                    </td>
                                             </tr>


                                             <?Php

                                                            $cat=$_GET['cat']; 

                                                                    $quer2= $db->query("SELECT subname,subid FROM subject");

                                                                    if(isset($cat)){
                                                                         $quer=$db->query("SELECT testname,testid FROM test WHERE subid='$cat' ");
                                                                      }

                                                                  //  else{
                                                                  //     $quer=$db->query("SELECT testname FROM test WHERE subid='$cat' ");
                                                                  //  } 

                                                           echo "<form method=post name=f1 action=''>";
                                                         ?> 
                                                <tr><td><?php

                                                               echo "<select style='height:40px;width:200px;' name='cat' onchange=\"reload(this.form)\"><option value=''><b> Category/Subject </b></option>";

                                                                    while($row2 = mysql_fetch_array($quer2)){
                                                                           $subid=$row2['subid'];
                                                                           $subname=$row2['subname'];

                                                                        if($row2['subid']==@$cat){
                                                                            echo "<option selected value=$subid>$subname</option>"."<BR>";
                                                                         }

                                                                        else{
                                                                            echo  "<option value=$subid>$subname</option>";
                                                                         }
                                                                     }
                                                               echo "</select>";   

                                                               ?>
                                                </td><td><div style="border-left:2px solid #36AE79;height:100px"></div></td><td><?php

                                                               echo "<select style='height:40px;width:200px;' name='subcat'><option value=''><b> Choose Test </b></option>";

                                                                     while($row=mysql_fetch_array($quer)){
                                                                         $testname=$row['testname'];
                                                                         $testid=$row['testid'];

                                                                        echo  "<option value=$testid>$testname</option>";
                                                                    }

                                                               echo "</select></td></tr>";

                                                      echo "<td colspan=3 align=right><input type=submit value=Submit name='submit' style='color: #36AE79;height:40px;width:200px;'> | <a href=testcategory.php>Reset</a></td></tr>";

                                                      echo "</form>";
                                                  ?>

                                  </table>
                        </div>
               </div>
            </body>
       <?php  } ?>   
   </fieldset>
 </fieldset>
<?php
  include('loginfooter.html');


 