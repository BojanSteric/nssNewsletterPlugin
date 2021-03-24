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

		foreach ($subscriber as $sub):?>
            <tr>
                <td></td>
                <td><?=$item->getQuantityStep()?></td>
                <td><?=$item->getDiscountPercentage()?></td>
                <td><?=$item->getDiscountValue()?></td>
                <td><?=$item->getMinEndPrice()?></td>
                <td><?=$item->getQuantitySold()?></td>
                <td><a href="<?=admin_url() . '?page=tournament-manager&action=createForm&turnirId=' . $item->getTurnirId()?>" class='btn btn-sm btn-info updateUser'  >Update</a>-
                    <a href="<?=admin_url() . '?page=tournament-manager&action=delete&turnirId=' . $item->getTurnirId()?>" class='btn btn-sm btn-danger deleteUser' >Delete</a> aloo</td>
            </tr>
		<?php
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