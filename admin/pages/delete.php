<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
$page_id=$_GET['page_id'];

if(isset($_POST['delete'])){
	if($_POST['accept']!=1){
		$errors[] = "You have to be sure to delete this article!";
	}

	if(empty($errors)){
		// IT'S EMPTY
		Alert::setAlert('success', array("Your page is now deleted!"));
		$Pages->delete($page_id);
		header("location:/admin/pages/list");
		exit();
	}else{
		// IT'S NOT EMPTY
		Alert::setAlert('danger', $errors);
	}

}
include $_SERVER['DOCUMENT_ROOT'].'/admin/header.php';
$page = $Pages->get(0,$page_id);
?>
<div class="content">
	<div class="header">
		<h1>Delete Page</h1>
		<div class="clear"></div>
	</div>
	<form method="post">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<div class="form-group">
					<label for="form-title">Title</label>
					<input id="form-title" disabled class="form-control" value="<?php echo $page->title;?>" name="title" type="text">
				</div>
				<div class="checkbox">
					<label><input type="checkbox" value="1" name="accept">Are you sure to delete this?</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="form-group">
					<input type="submit" name="delete" class="btn btn-danger" value="Delete">
					<a href="/admin/pages/list" class="btn btn-primary">Cancel</a>
				</div>
			</div>
		</div>
	</form>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/footer.php';
?>
