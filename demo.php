<script>
    
document.cookie = "myJavascriptVar=123";
      <?php
        $phpVar = $_COOKIE['myJavascriptVar'];
        $qry= "select * from customer_details where customer_id='$phpVar'";
        echo "asdas";
?>
</script>