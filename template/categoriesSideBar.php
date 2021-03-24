<?php
?>


<?php
$a='';
$b='';
$c='';
if(isset($_GET['action'])){
$status=$_GET['action'];
switch ($status){
    case 'view':
        $a='active';
        break;
    case 'styling':
        $b='active';
        break;
    case 'description':
        $c='active';
        break;
}
}else {$a='active';}

?>

<div class="sidenavAdminCategories">

    <a  class="sidenavAdminCategorieslist <?php echo $a;?>"href="<?=admin_url() . '?page=categories-manager&action=view'?>"  >Menu Construct</a>
    <a <?php echo $b;?> class="sidenavAdminCategorieslist" href="<?=admin_url() . '?page=categories-manager&action=styling'?>"  >Menu Styling</a>
    <a <?php echo $c;?> class="sidenavAdminCategorieslist" href="<?=admin_url() . '?page=categories-manager&action=description'?>"  >Description</a>
</div>


