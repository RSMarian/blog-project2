<!-- View pentru crearea categoriilor -->
<h2><?= $title; ?></h2>

<!-- Validare erori -->
<?php echo validation_errors(); ?>

<!-- form pentru crearea categoriilor -->
<?php echo form_open_multipart('categories/create'); ?>
    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="name" placeholder="Enter name">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>