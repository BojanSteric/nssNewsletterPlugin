<?php

?>

<div class="wrap">
    <h2>Lista subscribera</h2>
    <table id="discountList">
        <thead>
        <tr>
            <th</th>
            <th>Br</th>
            <th>Označi</th>
            <th>Email</th>
            <th>Status</th>
            <th>Ime Prezime</th>
            <th>Opcije</th>
        </tr>
        </thead>
        <tbody>
		<?php
		/** @var Newsletter\Model\Newsletter $subscriber */
                $i=1;
		foreach ($subscriber as $sub):?>
            <tr>
                <td><?= $i?></td>
                <td>
                    <input type="checkbox" id="<?= 'sub' . $sub->getId()?>" name="<?= 'sub' . $sub->getId()?>" >
                    <label for="<?= 'sub' . $sub->getId()?>" > <?=$sub->getFirstName()?></label>
                </td>
                <td><?=$sub->getEmail()?></td>
                <td><?=$sub->getEmailStatus()?></td>
                <td><?=$sub->getFirstName()?><?=$sub->getLastName()?></td>
                <td><a href="<?=admin_url() . '?page=newsletter&action=update&userId=' . $sub->getId()?>" class='btn btn-sm btn-info updateUser'  >Update</a>-
                    <a href="<?=admin_url() . '?page=newsletter&action=delete&userId=' . $sub->getId()?>" class='btn btn-sm btn-danger deleteUser' >Delete</a> </td>
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
            jQuery('#discountList').DataTable();
        });
    </script>
</div>