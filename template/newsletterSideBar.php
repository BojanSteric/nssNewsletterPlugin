<?php
?>


<?php
$a='';
$b='';
$c='';
if(isset($_GET['action'])){
$status=$_GET['action'];
switch ($status){
    case 'subscribers':
        $a='active';
        break;
    case 'newsletters':
        $b='active';
        break;
    case 'description':
        $c='active';
        break;
}
}else {$a='active';}
?>

<div class="sidenavAdminCategories">

    <a  class="sidenavAdminCategorieslist <?php echo $a;?>"href="<?=admin_url() . '?page=newsletter&action=subscribers'?>"  >Subscribers</a>
    <a  class="sidenavAdminCategorieslist <?php echo $b;?>"href="<?=admin_url() . '?page=newsletter&action=newsletters'?>"  >Newsletters</a>
    <a  class="sidenavAdminCategorieslist <?php echo $c;?>t"href="<?=admin_url() . '?page=newsletter&action=description'?>"  >Description</a>
</div>


