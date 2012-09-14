
 <?php
 include("view/tpl_Header.php");
 ?>	   
  
<h1 class='ErrorHeader' style="color:red;">Fehler <?php echo $this->ErrorHeader; ?>   </h1>

<?php
echo $this->ErrorString;
?>

<br />
<br />
<br />

 <a href="<?php echo $this->LastPage; ?>">:T_ERROR_BACK:</a> 

</body>
</html>