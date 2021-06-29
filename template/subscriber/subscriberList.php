<?php
?>

<div class="wrap subsciberDiv">
    <h2>Lista subscribera</h2>
    <table class="subscriberList stripe">
        <thead>
        <tr class="table-header">
            <th class="col col-1">Id</th>
            <th class="col col-3">Email</th>
            <th class="col col-4">Status</th>
            <th class="col col-5">Ime i Prezime</th>
            <th class="col col-6">Opcije</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            jQuery('.subscriberList').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                searchDelay: 1500,
                pageLength: 25,
                lengthMenu: [ 10, 25, 50, 75, 100,250,500, 1000 ],
                dom: 'lfriptrip',
                ajax: {
                    url: 'admin-ajax.php',
                    type: 'POST',
                    data:{
                        action:'getSubscribers'
                    }
                },
                language: {
                    "emptyTable": "Nije pronadjena nijedan pretplatnik sa zadatim filterima"
                },

                columns: [
                    {
                        name:'subscriberId',
                        orderable:false,
                    },
                    {
                        name: "email",
                        orderable:false,
                    },

                    {
                        name: "emailStatus",
                        orderable:true,
                    },
                    {
                        name: "fullName",
                        orderable:false,
                    },
                    {
                        name: "options",
                        orderable:false,
                    }
                ]
            });
        });
    </script>
</div>