<span class="contentLabel">Content</span>
<span class="grayLine"></span>
<div>
    <input value="<?=$templateTitle ?? ''?>" class="templateNameForm" name="templateTitle" type="text" placeholder="Unesite naslov">
    <input value="<?=$templateTitleUrl ?? ''?>" class="templateNameForm" name="templateTitleUrl" type="url" placeholder="Unesite putanju naslova">
</div>
<span class="grayLine"></span>
<div>
    <?php $inputCounter = $this->getTemplateInput('680x300', $inputCounter, $images)?>
</div>
<span class="grayLine"></span>