<?php
echo "account: ". $_POST["username"]."<br/><br/>";
 ?>


<!-- <span id="time"></span> -->
<!-- <script type="text/javascript" src="info.js">
  // document.getElementById("id");
  // document.getElementById("time").innerHTML = getNOW();
  var id = window.localStorage.getItem("id")
  document.writeIn(id());

  var test = "test";
  document.writeIn(test());
  // getNOW();
</script> -->


<table border=0>
 <tr>
   <form action = "petadb_main.php" method = "post">
   <td>year</td>
   <td>
   <select name="year">
       <option value="2017" selected></option>
       <option value="2018">2018</option>
       <option value="2019">2019</option>
   </select></td>
 </tr><br/>

 <tr>
   <td>month</td>
   <td>
   <select name="month">
       <option value="1" selected>1</option>
       <option value="2">2</option>
       <option value="3">3</option>
   </select></td>
 </tr><br/>

 <tr>
   <td>date</td>
   <td>
   <select name="date">
     <?php for($i=1; $i<31; $i++){ ?>
       <option value=""><?php echo $i; ?></option>
     <?php } ?>
    </select></td>
 </tr><br/>

 <tr>
   <td>time</td>
   <td>
   <select name="str_hour">
     <?php for($i=0; $i<25; $i++){ ?>
       <option value=""><?php echo $i; ?></option>
     <?php } ?>
   </select>:

   <select name="str_minite">
     <?php for($i=00; $i<6; $i++){ ?>
       <option value=""><?php echo $i*10; ?></option>
     <?php } ?>
   </select>~

   <select name="str_hour">
     <?php for($i=0; $i<25; $i++){ ?>
       <option value=""><?php echo $i; ?></option>
     <?php } ?>
   </select>:

   <select name="end_minite">
     <?php for($i=00; $i<6; $i++){ ?>
       <option value=""><?php echo $i*10; ?></option>
     <?php } ?>
   </select></td>
 </tr><br/>

 <tr>
   <td>code</td>
   <td>
   <select name="code">
     <option value="">J004 事務</option>
     <option value="">J005 学習</option>
    </select></td>
 </tr><br/>

 <tr>
   <td>work</td>
   <td>
     <input type="text" name="work" value="">
   </td>
 </tr><br/>

 <tr><td>
 <input type="button" name="" value="go">
</td></tr>
</form>
</table>

<?php
  echo $_POST["month"];
 ?>
