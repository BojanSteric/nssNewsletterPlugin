<?php

$a='';
$b='';
$c='';
$d='';
if(isset($_GET['action'])){
    $status=$_GET['action'];
    switch ($status){
        case 'subscribers':
            $a='active';
            break;
        case 'newsletters':
            $b='active';
            break;
        case 'editNewsletters':
            $c='active';
            break;
        case 'editSubscribers':
            $d='active';
            break;
    }
}else {$a='active';}
?>

<div class="sidenavAdminCategories">
    <a  class="sidenavAdminCategorieslist <?php echo $a;?>"href="<?=admin_url() . '?page=newsletter&action=subscribers'?>"  >Subscribers</a>
    <a  class="sidenavAdminCategorieslist <?php echo $b;?>"href="<?=admin_url() . '?page=newsletter&action=newsletters'?>"  >Newsletters</a>
    <a  class="sidenavAdminCategorieslist <?php echo $c;?>"href="<?=admin_url() . '?page=newsletter&action=editNewsletters&subaction=create'?>"  >Create Newsletter</a>
    <a  class="sidenavAdminCategorieslist <?php echo $d;?>"href="<?=admin_url() . '?page=newsletter&action=editSubscribers&subaction=create'?>"  >Create Subscriber</a>
</div>


