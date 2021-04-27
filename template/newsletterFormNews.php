<?php
?>
<h3>Newsletter Sending Form</h3>

<div class="newsletterForm">

	<form method="POST" action="<?php echo '?page=newsletter&action=createNewsletters&noheader=true'; ?>">
        <div>
		<label for="title">Title</label>
		<input type="text" id="title" name="title" placeholder="Title.." required">

		<label for="newStatus">Status</label>
		<select type=select id="newStatus" name="newsStatus" ">
			<option value="active">active</option>
			<option value="pending">pending</option>
			<option value="paused">paused</option>
			<option value="complite">complite</option>
		</select>

        <label for="templateName">Template</label>
        <select type=select id="templateName" name="templateName">
            <option value="-1">Izaberite šablon</option>
            <?php
            foreach ($directoryIterator as $templateFile) {
                if (is_file($templateFile->getPathname())) {
                    if ($templateFile->getExtension() === 'html') {
                        echo sprintf(
                            '<option value="%s">%s</option>',
                            $templateFile->getPathname(),
                            $templateFile->getBasename('.html')
                        );
                    }
                }
            }
            ?>
        </select>

		<label for="scheduled">Scheduled at</label>
		<input type="datetime-local" id="scheduled" name="scheduledAt" required">

        </div>
        <div id="contentWrapper">
            <span class="contentLabel">Content</span>
        </div>
        <div class="submitWrapper">
            <input type="submit" value="Sačuvaj">
        </div>
</form>


</div>