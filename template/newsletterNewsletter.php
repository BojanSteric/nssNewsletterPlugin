<?php
?>
<div class="wrap subsciberDiv">
    <h2>Lista newslettera</h2>
    <div id='div_search'><input type='text' id='search' placeholder="Enter search text" /></div>
    <table class="subscriberList" id="empTable">
        <thead>
        <tr class="table-header">
            <th class="col col-1">Br</th>
            <th class="col col-3">Status</th>
            <th class="col col-4">Naslov</th>
            <th class="col col-5">Datum kreiranja</th>
            <th class="col col-6">Datum slanja</th>
            <th class="col col-7">Opcije</th>
        </tr>
        </thead>
        <tbody>

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