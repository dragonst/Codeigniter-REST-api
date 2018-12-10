<?php
    $this->load->view('layout/header.php');
?>
<div class="container">
<div class="row">
<div class="col-md-6 col-md-offset-3">
  <h1 style="text-align:center; margin-bottom:20px;">SIGN IN TO API</h1>
   <?php echo $this->session->flashdata('error_msg'); ?>
<form class="form-horizontal" role="form" method="post" action="<?php echo $this->config->base_url() ?>api/authentication/login">
    <div class="form-group">
      <label class="control-label col-sm-2" for="email3">Username:</label>
      <div class="col-sm-10">
        <input type="text" name="username" class="form-control" id="email3" placeholder="Enter username">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd3">Password:</label>
      <div class="col-sm-10">
        <input type="password" name="password" class="form-control" id="pwd3" placeholder="Enter password">
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
</div>
</div>
</div>
<?php
    $this->load->view('layout/footer.php');
?>
