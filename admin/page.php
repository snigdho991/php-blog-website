<?php include 'inc/header.php'; ?>
<?php include 'inc/adminsidebar.php'; ?>

<?php
    if(!isset($_GET['pageid']) || $_GET['pageid'] == NULL){
        echo "<script>window.location = 'index.php';</script>";
        //header("Location:catlist.php");<!--error-->
    } else {
        $pageid = $_GET['pageid'];
    }
?>

<style type="text/css">
    .actiondel {
        margin-left: 10px; 
    }
    .actiondel a {
        border: 1px solid #ddd;
        color: #444;
        cursor: pointer;
        font-size: 20px;
        padding: 2px 14px;
        background: #F0F0EE;
        font-weight: normal;
    }
    .actiondel a:hover{background: red; color:#fff; transition: all linear .2s;}
</style>

<div class="grid_10">		
    <div class="box round first grid">
        <h2>Update Page</h2>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = mysqli_real_escape_string($db->link, $_POST['name']);
        $body = mysqli_real_escape_string($db->link, $_POST['body']);

    if ($name == "" || $body == ""){
        echo "<span class='errad'>Fields Must Not Be Empty !</span>";
    } else {
            
        $query = "UPDATE tbl_page
                  SET 
                  name = '$name',
                  body = '$body'
                  WHERE id = '$pageid'";

        $updated_row = $db->update($query);
        if ($updated_row) {
         echo "<span class='sucad'> Page Updated Successfully ! </span>";
        } else {
         echo "<span class='errad'> Page Isn't Updated. Try Again ! </span>";
        }
    }
}
?>
        <div class="block">  
<?php
    $pagequery = "SELECT * FROM tbl_page WHERE id = '$pageid'";
    $pagedetails = $db->select($pagequery);
    if($pagedetails){
        while ($result = $pagedetails->fetch_assoc()) {                  
?>             
         <form action="" method="POST">
            <table class="form">
               
                <tr>
                    <td>
                        <label>Title</label>
                    </td>
                    <td>
                        <input type="text" name="name" value="<?php echo $result['name']; ?>" class="medium" />
                    </td>
                </tr>
           
                <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Content</label>
                    </td>
                    <td>
                        <textarea class="tinymce" name="body">
                            <?php echo $result['body']; ?>
                        </textarea>
                    </td>
                </tr>

				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                    <?php
                        if (Session::get('userRole') == '0'){
                    ?>
                        <span class="actiondel"><a onclick="return confirm('Are You Sure To Delete ?'); " href="delpage.php?delpage=<?php echo $result['id']; ?>">Delete</a></span>
                    <?php } ?>
                    </td>
                </tr>
            </table>
            </form>
<?php } } ?>
        </div>
    </div>
</div>

<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    setupTinyMCE();
    setDatePicker('date-picker');
    $('input[type="checkbox"]').fancybutton();
    $('input[type="radio"]').fancybutton();
});
</script>
<!-- Load TinyMCE -->

<?php include 'inc/footer.php'; ?>
