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
	case 'templates':
	case 'editTemplate':
        $e='active';
        break;
	case 'editSubscribers':
	case 'sendNewsForm':
		$d='active';
		break;
}
}else {$a='active';}
?>

<div class="sidenavAdminCategories">
    <a  class="sidenavAdminCategorieslist <?php echo $b;?>"href="<?=admin_url() . '?page=newsletter&action=newsletters'?>"  >Newsletters</a>
    <a  class="sidenavAdminCategorieslist <?php echo $a;?>"href="<?=admin_url() . '?page=newsletter&action=subscribers'?>"  >Subscribers</a>
    <a  class="sidenavAdminCategorieslist <?php echo $e;?>"href="<?=admin_url() . '?page=newsletter&action=templates'?>"  >Templates</a>
    <a  class="sidenavAdminCategorieslist <?php echo $d;?>"href="<?=admin_url() . '?page=newsletter&action=sendNewsForm'?>"  >Send</a>
</div>

<!--<a  class="sidenavAdminCategorieslist <?php /*echo $d;*/?>"href="<?/*=admin_url() . '?page=newsletter&action=editSubscribers&subaction=create'*/?>"  >Create Subscriber</a>-->
