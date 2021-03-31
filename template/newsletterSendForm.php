<?php
?>
<h3>Newsletter Sending Form</h3>

<div class="newsletterForm">

	<form method="POST" action="<?php echo '?page=newsletter&action=createNewsletters&noheader=true'; ?>">
		<label for="title">Title</label>
		<input type="text" id="title" name="title" placeholder="Title.." ">

		<label for="newStatus">Status</label>
		<select type=select id="newStatus" name="newsStatus" ">
			<option value="active">active</option>
			<option value="pending">pending</option>
			<option value="paused">paused</option>
			<option value="complite">complite</option>
		</select>

        <label for="templateName">Template</label>
        <select type=select id="templateName" name="templateName">
            <?php  foreach($fileItem as $file):?>
                <option value="<?= $file ?>"><?= $file ?></option>
            <?php endforeach; ?>
        </select>

		<label for="Sceduled">Sceduled at</label>
		<input type="datetime-local" id="Sceduled" name="scheduledAt" ">

        <label for="productId">Comma-separated  product id for newsletter </label>
        <input type="text" id="productId" name="products" placeholder="id,id,id" ">

		<label for="content">Content</label>
		<textarea id="content" name="content" placeholder="Write something.." style="height:200px"></textarea>

<input type="submit" value="Submit">
</form>


</div>