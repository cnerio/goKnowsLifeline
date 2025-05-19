<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<section>
  <div class="container">
    <div class="row">
      <div class="col pt-3">
            <h1><?php echo $data['title']; ?></h1>
  <p><?php echo $data['description']; ?></p>
  <p>Version: <strong><?php echo APPVERSION; ?></strong></p>
      </div>
    </div>
  </div>
</section>
<?php require APPROOT . '/views/inc/footer.php'; ?>