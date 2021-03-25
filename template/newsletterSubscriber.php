<?php

?>

<div class="wrap subsciberDiv">
    <h2>Lista subscribera</h2>
<<<<<<< Updated upstream
    <table id="subscriberList">
=======
    <table class="subscriberList">
>>>>>>> Stashed changes
        <thead>
        <tr class="table-header">
            <th class="col col-1">Br</th>
            <th class="col col-2">Označi</th>
            <th class="col col-3">Email</th>
            <th class="col col-4">Status</th>
            <th class="col col-5">Ime Prezime</th>
            <th class="col col-6">Opcije</th>
        </tr>
        </thead>
        <tbody>
		<?php
		/** @var Newsletter\Model\Newsletter $subscriber */
        $ordinalNumber = 1;
		foreach ($subscriber as $sub):?>
<<<<<<< Updated upstream
            <tr>
                <td><?= $ordinalNumber++; ?></td>
                <td>
                    <input type="checkbox" id="<?= 'sub' . $sub->getId()?>" name="<?= 'sub' . $sub->getId()?>" >
                    <label for="<?= 'sub' . $sub->getId()?>" > <?=$sub->getFirstName()?></label>
                </td>
                <td><?=$sub->getEmail()?></td>
                <td><?=$sub->getEmailStatus()?></td>
                <td><?= sprintf("%s %s",$sub->getFirstName(), $sub->getLastName())?></td>
                <td><a href="<?=admin_url() . '?page=newsletter&action=update&userId=' . $sub->getId()?>" class='btn btn-sm btn-info updateUser'  >Update</a>-
                    <a href="<?=admin_url() . '?page=newsletter&action=delete&userId=' . $sub->getId()?>" class='btn btn-sm btn-danger deleteUser' >Delete</a> </td>
=======
            <tr class="table-row">
                <td class="col col-1"><?= $i?></td>
                <td class="col col-2 checksubscriber">
                    <input type="checkbox" class="" id="<?= 'sub' . $sub->getId()?>" name="<?= 'sub' . $sub->getId()?>" >
                   <!-- <label for="<?/*= 'sub' . $sub->getId()*/?>" > <?/*=$sub->getFirstName()*/?></label>-->
                </td>
                <td class="col col-3"><?=$sub->getEmail()?></td>
                <td class="col col-4"><?=$sub->getEmailStatus()?></td>
                <td class="col col-5"><?=$sub->getFirstName()?> <?=$sub->getLastName()?></td>
                <td class="col col-6"><a href="<?=admin_url() . '?page=newsletter&action=update&userId=' . $sub->getId()?>" class='btn btn-sm btn-info updateUser subscriberUpdate'  >Update</a>-
                    <a href="<?=admin_url() . '?page=newsletter&action=delete&userId=' . $sub->getId()?>" class='btn btn-sm btn-danger deleteUser subscriberDelete' >Delete</a> </td>
>>>>>>> Stashed changes
            </tr>
		<?php
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