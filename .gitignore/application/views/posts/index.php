<h2><?= $title ?> </h2>
<?php foreach($posts as $post) : ?>

	<h3> <?php  echo $post['title']; ?></h3>

	<div class="row">
		<div class="col-md-3">
			<img src="<?php echo site_url(); ?>assets/images/posts/<?php echo $post['post_image']; ?>" style="width:225px;height:225px;">

		</div>
		<div class="col-md-9">
			<small class="post-date"> Posted On: <strong><?php echo $post['created_at']; ?></strong> in <strong><?php echo $post['name']; ?></strong></small><br>
	<?php echo word_limiter($post['body'], 70);  ?>

	<br><br>
	<p><a class="btn btn-default"  href="<?php echo site_url('/posts/'.$post['slug']); ?>">  Read More </a></p>

		</div>

	</div>

	<?php endforeach; ?>

<div class="pagination-links">
		<?php echo $this->pagination->create_links(); ?>
</div>