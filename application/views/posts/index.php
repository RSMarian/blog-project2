<h2><?= $title ?></h2>

<!-- pentru fiecare $post(item din array) din variabila $posts(care contine datele din tabelul posts sub forma de array) -->
<?php foreach ($posts as $post) : ?>
    <h3><?php echo $post['title']; ?></h3>
    <div class="row">
        <div class="col-md-3">
            <img class="post-thumb" src="<?php echo site_url();?>assets/images/posts/<?php echo $post['post_image']?>">
        </div>
        <div class="col-md-9">
            <small class="post-date">Posted on: <?php echo $post['created_at']; ?> in <strong><?php echo $post['name']; ?></strong></small><br>
            <!-- metoda codeigniter (text helper) pentru limitarea nr. de cuvinte(pt read more) -->
            <?php echo word_limiter($post['body'], 60); ?>
            <br><br>
            <p><a class="btn btn-default btn-lg" href="<?php echo site_url('/posts/'.$post['slug']); ?>">Read More</a></p>
        </div>
    </div>
    <?php endforeach; ?>
    <?php echo $this->pagination->create_links(); ?>
    

