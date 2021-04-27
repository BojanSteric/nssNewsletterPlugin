<div class="wrap">
<select name="templateSelect" id="templateSelect">
    <option>Izaberite šablon</option>
<?php foreach ($directoryIterator as $templateFile){
    if (is_file($templateFile->getPathname())){
        if ($templateFile->getExtension() === 'html') {
            echo sprintf('<option value="%s">%s</option>',$templateFile->getPathname(), $templateFile->getBasename('.html'));
        }
    }
}
?>
</select>
    <div id="templateWrapper">

    </div>
</div>