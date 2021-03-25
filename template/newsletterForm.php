<?php
?>

<style>
	.newsletterForm {font-family: Arial, Helvetica, sans-serif;}
	input[type=text], select, textarea {
		width: 100%;
		padding: 6px;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
		margin-top: 6px;
		margin-bottom: 16px;
		resize: vertical;
	}
	.newsletterForm select {
		display: block;
		width: 300px;
		padding: 6px;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
		margin-top: 6px;
		margin-bottom: 16px;
		resize: vertical;
	}
	.newsletterForm label {
		font-size: 14px;
	}
	.newsletterForm input[type=datetime-local]{
		display: block;
		width: 300px;
		padding: 6px;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
		margin-top: 6px;
		margin-bottom: 16px;
		resize: vertical;
	}
	input[type=submit] {
		background-color: #4CAF50;
		color: white;
		padding: 12px 20px;
		border: none;
		border-radius: 4px;
		cursor: pointer;
	}

	input[type=submit]:hover {
		background-color: #45a049;
	}

	.newsletterForm {
		border-radius: 5px;
		background-color: #f2f2f2;
		padding: 20px;
	}
</style>
</head>
<body>

<h3>Newsletter</h3>

<div class="newsletterForm">

	<form method="POST" action="<?= '?page=newsletter&action=updateNewsletters&newsId=' . $newsId ?>">
		<label for="title">Title</label>
		<input type="text" id="title" name="title" placeholder="Title.." value="<?= $title ?? ''?>">

		<label for="newStatus">Status</label>
		<select type=select id="newStatus" name="newsStatus" value="<?=$newsStatus ?? ''?>">
			<option value="active">active</option>
			<option value="pending">pending</option>
			<option value="paused">paused</option>
			<option value="complite">complite</option>
		</select>
		<label for="Sceduled">Sceduled at</label>
		<input type="datetime-local" id="Sceduled" name="scheduledAt" value="<?= date("Y-m-d\TH:i:s", strtotime($scheduledAt))?>">
        <input type=" hidden" id="created" name="createdAt"  value="<?= $createdAt ?? ''?>" hidden >

		<label for="content">Content</label>
		<textarea id="content" name="content" placeholder="Write something.." style="height:200px"><?= $content ?? ''?></textarea>

		<input type="submit" value="Submit">
	</form>


</div>

</body>
</html>
