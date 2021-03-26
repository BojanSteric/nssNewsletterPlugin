<?php
?>
<h3>Newsletter Sending Form</h3>

<div class="newsletterForm">

	<form method="POST" action="<?php if(isset($_GET['subaction'])){ echo '?page=newsletter&action=createNewsletters&noheader=true'; }
	else{echo '?page=newsletter&action=updateNewsletters&newsId=' . $newsId.'&noheader=true';}; ?>">
		<label for="title">Select newsletter to send</label>
		<input type="text" id="title" name="title" placeholder="Title.." value="<?= $title ?? ''?>">

		<label for="newStatus">Status</label>
		<select type=select id="newStatus" name="newsStatus" value="<?=$newsStatus ?? ''?>">
			<option value="active">active</option>
			<option value="pending">pending</option>
			<option value="paused">paused</option>
			<option value="complite">complite</option>
		</select>
		<label for="Sceduled">Sceduled at</label>
		<input type="datetime-local" id="Sceduled" name="scheduledAt" value="<?= date("Y-m-d\TH:i:s", strtotime($scheduledAt)) ?? date("Y-m-d\TH:i:s",$scheduledAt )?>">
        <input type=" hidden" id="created" name="createdAt"  value="<?= $createdAt ?? date("Y-m-d H:i:s") ?>" hidden >

		<label for="content">Content</label>
		<textarea id="content" name="content" placeholder="Write something.." style="height:200px"><?= $content ?? ''?></textarea>

<input type="submit" value="Submit">
</form>


</div>