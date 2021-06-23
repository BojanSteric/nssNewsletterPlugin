<div class="subsciberDiv">
    <h2>Lista newslettera</h2>
    <table class="subscriberList striped" id="empTable">
        <thead>
        <tr class="table-header">
            <th class="col col-1">#</th>
            <th class="col col-3">Status</th>
            <th class="col col-4">Title</th>
            <th class="col col-4">Template</th>
            <th class="col col-5">Date created</th>
            <th class="col col-6">Date scheduled</th>
            <th class="col col-7">Statistics</th>
            <th class="col col-8">Options</th>
        </tr>
        </thead>
        <tbody>
        <?php
        /** @var \Newsletter\Model\Newsletter $newsletter */
        foreach ($newsletters as $key => $newsletter):?>
        <tr class="table-row">
            <td class="col col-1"><?=$newsletter->getId()?></td>
            <td class="col col-3"><?=$newsletter->getStatus()?></td>
            <td class="col col-4"><?=$newsletter->getTitle()?></td>
            <td class="col col-4"><?=$newsletter->getTemplateName()?></td>
            <td class="col col-5"><?=$newsletter->getDateCreated()?></td>
            <td class="col col-6"><?=$newsletter->getDateScheduled()?></td>
            <td class="col col-6"><?=$newsletter->getStats()?></td>
            <td class="col col-8">
                <button class='btn btn-sm btn-info updateNewsletter' data-id="<?=$newsletter->getId()?>">Edit</button>
                <button class='btn btn-sm btn-info sendNewsletter' data-id="<?=$newsletter->getId()?>">Send now</button>
<!--                <button class='btn btn-sm btn-info pauseNewsletter' data-id="<?=$newsletter->getId()?>">Pause</button> -->
                <button class='btn btn-sm btn-danger deleteNewsletter' data-id="<?=$newsletter->getId()?>">Delete</button>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            jQuery('#empTable').DataTable({
                order: [[ 4, "desc" ]]
            });
        });
    </script>
</div>