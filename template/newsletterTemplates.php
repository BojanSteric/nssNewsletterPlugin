<?php
?>
<div class="wrap subsciberDiv">
    <h2>Templates</h2>
	<h2><a  class="addNewTemplatesNewsletter"<!--href="<?/*=admin_url() . '?page=newsletter&action=editTemplates&subaction=create'*/?>" --> disabled >Add New</a></h2>
    <table class="subscriberList">
        <thead>
        <tr class="table-header">
            <th class="col col-1">No</th>
            <th class="col col-4">Template</th>
            <th class="col col-5">Last update</th>
            <th class="col col-7">Option</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        $x=0;
        foreach($fileItem as  $file):
	        ?>
            <tr class="table-row">
                <td class="col col-1"><?= $i?></td>
                <td class="col col-4"><?= $fileItem[$x] ?></td>
                <td class="col col-5"><?= $fileDate[$x] ?> </td>
                <td class="col col-7"><a href="" class='btn btn-sm btn-info updateUser subscriberUpdate'  >Update</a>-
                    <a href="<?=admin_url() . '?page=newsletter&action=deleteTemplates&templateName=' . $fileItem[$x]?>" class='btn btn-sm btn-danger deleteUser subscriberDelete'  disabled>Delete</a> </td>
            </tr>
		<?php
			$i++;
			$x++;
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