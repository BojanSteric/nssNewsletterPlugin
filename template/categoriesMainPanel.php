<?php

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body class="bodyAdminCategories">

 <?php include NEWSLETTER_DIR . 'templates/newsletterSideBar.php'; ?>


 <div class="mainAdminCategories">
     <?php /** @var MenuPage\menuPageActions $newsletterPage */
     include NEWSLETTER_DIR . $newsletterPage; ?>
 </div>


</body>


