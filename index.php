<?php include 'inc/header.php'; ?>
<?php include 'inc/slider.php'; ?>

<div class="contentsection contemplete clear">
<div class="maincontent clear">
<!--- Pagination --->
<?php
	$total_pages = 3;
	if(isset($_GET["page"])){
		$page = $_GET["page"];
	} else {
		$page = 1;
	}

	$start_from = ($page-1) * $total_pages;
?>
<!--- Pagination --->

<?php
	$query = "SELECT * FROM tbl_post LIMIT $start_from, $total_pages";
	$post  = $db->select($query);
	if($post){
		while ($result = $post->fetch_assoc()) {
		
?>

<div class="samepost clear">
	<h2><a href="post.php?id=<?php echo $result['id']; ?>"><?php echo $result['title']; ?></a></h2>
	<h4><?php echo $fm->formatDate($result['date']); ?> By <a href="#"><?php echo $result['author']; ?></a></h4>
	<a href="#"><img src="admin/<?php echo $result['image']; ?>" alt="post image"/></a>

	<?php echo $fm->textShorten($result['body']); ?>

	<div class="readmore clear">
		<a href="post.php?id=<?php echo $result['id']; ?>">Read More</a>
	</div>
</div>
<?php } ?> <!--- end while loop --->

<!--- Pagination --->
<?php 
	$query  = "SELECT * FROM tbl_post";
	$result = $db->select($query);
	$total_rows = mysqli_num_rows($result);
	$total_records = ceil($total_rows/$total_pages); 

echo "<span class='pagination'><a href='index.php?page=1'>".'First Page'."</a>";
for ($i = 1; $i <= $total_records; $i++) { ?>
	 <a
	<?php
	if(isset($_GET['page']) && $_GET['page'] == $i){
    			echo 'id="active"';
    } ?>
	 href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
<?php
}
echo "<a href='index.php?page=$total_records'>".'Last Page'."</a></span>"
?>
<!--- Pagination --->

<?php } else {
	header("location:404.php");
} ?>

</div>
<?php include 'inc/sidebar.php'; ?>
<?php include 'inc/footer.php'; ?>
