<?php
  $this->load->view('layout/header.php');
?>

<?php echo $this->session->flashdata('alert_msg'); ?>

<div class="row">
    <div class="col-lg-12">
      <div class="dt-card">
          <div class="dt-card__body"> 
        <form id="editForm" method="POST" action="<?php echo site_url('user/change_password/save'); ?>">
          <div class="row">
            <div class="col-md-12"> 
              <div class="form-group">
                <label class="control-label col-lg-12">Current Password</label>
                <div class="col-lg-12">
                  <input type="password" class="form-control" name="currpass" id="currpass" required>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12"> 
              <div class="form-group">
                <label class="control-label col-lg-12">Password</label>
                <div class="col-lg-12">
                  <input type="password" class="form-control" name="newpass" id="newpass" required>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12"> 
              <div class="form-group">
                <label class="control-label col-lg-12">Retype Password</label>
                <div class="col-lg-12">
                  <input type="password" class="form-control" name="renewpass" id="renewpass" required>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12"> 
              <div class="form-group">
                <div class="col-lg-12">
                  <button class="btn btn-block btn-primary" type="submit">Simpan</button>
                </div>
              </div>
            </div>
          </div>
        </form>
          </div>
        </div>
    </div>
</div>
<?php
  $this->load->view('layout/footer.php');
?>


<script type='text/javascript'>
$(function() {
  $('#currpass').focus();
  
  $( "#newpass" ).change(function() {
    if ( ($('#newpass').val()!= '') && ($('#renewpass').val() != '' )){
      if ( $('#newpass').val() != $('#renewpass').val() ){
      alert('Please retype, newpass is missmatch!');
        $('#newpass').val('');
        $('#renewpass').val('');
        $('#newpass').focus();
      }
    }
  });
  $( "#renewpass" ).change(function() {
    if ( ($('#newpass').val()!= '') && ($('#renewpass').val() != '' )){
      if ( $('#newpass').val() != $('#renewpass').val() ){
        alert('Please retype, newpass is missmatch!');
        $('#newpass').val('');
        $('#renewpass').val('');
        $('#newpass').focus();
      }
    }
  });
})
</script>