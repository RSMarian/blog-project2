<!-- View pentru editarea posturilor -->

<h2><?= $title ?></h2>

<!-- functie php pentru afisarea erorilor de validare -->
<?php echo validation_errors(); ?>

<!-- form pentru creare posturi -->
<?php echo form_open('posts/update'); ?>
  <input type="hidden" name="id" value="<?= $post['id']; ?>">
  <div class="form-group">
    <label>Title</label>
    <input type="text" class="form-control" placeholder="Add Title" name="title" value="<?php echo $post['title']; ?>">
  </div>
  <div class="form-group">
    <label>Body</label>
    <textarea id="editor1" class="form-control" name="body" placeholder="Add Body"><?php echo $post['body']; ?></textarea>
  </div>
  <div class="form-group">
    <label>Category</label>
    <!-- dropdown -->
    <select name="category_id" class="form-control">
      <!-- pentru fiecare valoare din $categories(array) pe care le pun in variabila $category -->
      <?php foreach($categories as $category): ?>
        <!-- afisam valoarea field-ului 'name' din variabila $category si o asociem cu field-ul 'id'(id-ul este valoarea trimisa catre db la submiterea formului) -->
        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>