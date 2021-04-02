<?php
?>

<style>

</style>
</head>
<body>

<h3><?php
	if(isset($_GET['action'])){
	$status=$_GET['action'];
	switch ($status) {
		case 'subscribers':
			echo "New Template";
			break;
		case 'newsletters':
			echo "Edit Template";
			break;
	}};
	/** @var MenuPage\menuPageAction.php $subscriber */
    ?></h3>

<div class="newsletterForm">

	<form method="POST" enctype="multipart/form-data" action="<?php if(isset($_GET['subaction'])){ echo '?page=newsletter&action=createTemplates&noheader=true'; }
	else{echo '?page=newsletter&action=updateTemplates&templateName=' .$templateName.'&noheader=true';}; ?>">
		<label for="nameTemplate">Name For Temaplate</label>
		<input type="text" id="nameTemplate" name="nameTemplate" placeholder="Name Temaplate.." value="<?= $templateName ?? ''?>">
        <input type="text" id="currentTemplate" name="currentTemplate"  value="<?= $templateName ?>" hidden>
        <label for="file">Select file:</label>
        <input type="file" id="file" name="file" >

		<input type="submit" value="Submit" style="display: block; margin-top: 20px; ">
	</form>

</div>

</body>
</html>
