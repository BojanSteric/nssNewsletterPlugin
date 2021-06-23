<div class="newsletterForm">
    <?php if (!$newsletterId): $action = '?page=newsletter&action=createNewsletter';?>
    <h3>Kreirajte newsletter</h3>
    <?php else: $action = '?page=newsletter&action=updateNewsletter&newsId='.$newsletterId?>
        <h3>Izmenite newsletter</h3>
    <?php endif;?>
	<form id="newsletterForm" data-newsletterid="<?=$newsletterId ?? null?>" method="POST" action="<?=$action?>">
        <div>
		<label for="title">Title</label>
		<input value="<?=$title?>" type="text" id="title" name="title" placeholder="Title.." required">

		<label for="newStatus">Status</label>
		<select type=select id="newStatus" name="newsStatus" ">
			<option value="active">active</option>
			<option value="pending">pending</option>
			<option value="paused">paused</option>
			<option value="complite">complete</option>
		</select>

        <label for="templateName">Template</label>
        <select type=select id="templateName" name="templateName">
            <option value="-1">Izaberite šablon</option>
            <?php
            foreach ($directoryIterator as $templateFile) {
                $selected = '';
                if (is_file($templateFile->getPathname())) {
                    if ($templateFile->getExtension() === 'php') {
                        if ($templateFile->getBasename('.php') === $templateName){
                            $selected = 'selected="selected"';
                        }
                        echo sprintf(
                            '<option %s value="%s">%s</option>',
                            $selected,
                            $templateFile->getPathname(),
                            $templateFile->getBasename('.php')
                        );
                    }
                }
            }
            ?>
        </select>

		<label for="scheduled">Scheduled at</label>
		<input min="<?=date("Y-m-d\TH:i")?>" value="<?=$scheduledDate ?? ''?>" type="datetime-local" id="scheduled" name="scheduledAt" required">

        </div>
        <div id="contentWrapper">
            <span class="contentLabel"></span>
        </div>
        <div class="submitWrapper">
            <input type="submit" value="Sačuvaj">
        </div>
</form>


</div>