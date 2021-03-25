<?php
?>
<div class="wrap subsciberDiv">
    <h2>Lista newslettera</h2>
    <table class="subscriberList">
        <thead>
        <tr class="table-header">
            <th class="col col-1">Br</th>
            <th class="col col-2">Označi</th>
            <th class="col col-3">Status</th>
            <th class="col col-4">Naslov</th>
            <th class="col col-5">Datum kreiranja</th>
            <th class="col col-6">Datum slanja</th>
            <th class="col col-7">Opcije</th>
        </tr>
        </thead>
        <tbody>
		<?php
		/** @var Newsletter\Model\Newsletter $newsletter */
		$i = 1;
		foreach ($newsletter as $news):?>

            <tr class="table-row">
                <td class="col col-1"><?= $i?></td>
                <td class="col col-2 checksubscriber">
                    <input type="checkbox" class="" id="<?= 'news' . $news->getId()?>" name="<?= 'news' . $news->getId()?>" >
                   <!-- <label for="<?/*= 'sub' . $sub->getId()*/?>" > <?/*=$sub->getFirstName()*/?></label>-->
                </td>   
                <td class="col col-3"><?=$news->getStatus()?></td>
                <td class="col col-4"><?=$news->getTitle()?></td>
                <td class="col col-5"><?=$news->getDateCreated()?> </td>
                <td class="col col-6"><?=$news->getDateScheduled()?></td>
                <td class="col col-7"><a href="<?=admin_url() . '?page=newsletter&action=editNewsletters&newsId=' . $news->getId()?>" class='btn btn-sm btn-info updateUser subscriberUpdate'  >Update</a>-
                    <a href="<?=admin_url() . '?page=newsletter&action=deleteNewsletters&newsId=' . $news->getId()?>" class='btn btn-sm btn-danger deleteUser subscriberDelete' >Delete</a> </td>
            </tr>
		<?php
			$i++;
		endforeach; ?>
        </tbody>
    </table>
    <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            jQuery('#subscriberList').DataTable();
        });
    </script>
</div>