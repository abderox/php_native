<?php $titre = 'Step 1'; ?>

<?php $style = ''; ?>

<?php $step = 'Step 1'; ?>

<?php ob_start(); ?>
<?php
if (!empty($validation_err)) {
    echo '<div class="alert alert-danger">' . $validation_err . '</div>';
}
?>
    <div class="form-group ">
        <label for="">Website Name</label>
        <input
                type="text"
                name="web_name"
                class="form-control <?php echo (!empty($web_err)) ? 'is-invalid' : ''; ?>"
                placeholder="website name">
        <span class="invalid-feedback"><?php echo $web_err; ?></span>
    </div>
    <div class="form-group">
        <label for="">Database Name</label>
        <input
                type="text"
                name="db_name"
                class="form-control <?php echo (!empty($db_err)) ? 'is-invalid' : ''; ?>"
                placeholder="Database name">
        <span class="invalid-feedback"><?php echo $db_err; ?></span>
    </div>
    <div class="form-group ">
        <label for="">Website Description</label>
        <textarea
                rows="3"
                name="web_desc"
                class="form-control <?php echo (!empty($desc_err)) ? 'is-invalid' : ''; ?>"
                placeholder="About website"></textarea>
        <span class="invalid-feedback"><?php echo $desc_err; ?></span>
    </div>
    <div class="form-group">
        <label for="">N° de pages </label>
        <input
                type="number"
                name="num_page"
                class="form-control <?php echo (!empty($page_err)) ? 'is-invalid' : ''; ?>"
                placeholder="#">
        <span class="invalid-feedback"><?php echo $page_err; ?></span>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Background Image</span>
        </div>
        <div class="custom-file">
            <input type="file" name="bg_image" class="custom-file-input" id="bg_image">
            <label class="custom-file-label" for="bg_image">Choose file</label>
        </div>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Icon</span>
        </div>
        <div class="custom-file">
            <input type="file" name="icon_" class="custom-file-input" id="inputGroupFile01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
        </div>
    </div>
    <div class="custom-control custom-radio">
        <input type="radio" id="customRadio1" name="menu_Radio" class="custom-control-input" value="true"
               checked>
        <label class="custom-control-label" for="customRadio1">Vertical Menu</label>
    </div>
    <div class="custom-control custom-radio mb-3">
        <input type="radio" id="customRadio2" name="menu_Radio" class="custom-control-input" value="false">
        <label class="custom-control-label" for="customRadio2">Horizontal Menu</label>
    </div>
<?php $content = ob_get_clean(); ?>

<?php $script = ''; ?>
