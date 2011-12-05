      <div id="left-column-wrapper">
        <!-- START: Login Box -->
        <div id="login-wrapper" class="box box-fill box-border rounded-box">
        <?php if(!$this->session->userdata('logged_in')) {?>
          <span class="small-text">Welcome, guest!</span>
          <div id="login-content">
           <?php if(isset($login_error)) { ?>
            <div id="error" class="error-msg"><?=$login_error?></div>
            <?php } ?>
            <form name="frmLogin" method="post" action="/home/login">
              <p style="margin:5px 0;"><label for="login_id" class="small-text" style="display:block;">Login ID: </label><input type="text" name="login_id" id="login_id" size="20" maxlength="20" value="<?=$this->validate->get_field_value('login_id')?>" /></p>
              <p><label for="login_pw" class="small-text" style="display:block;">Password: </label><input type="password" name="login_pw" id="login_pw" size="20" maxlength="20" /></p>
              <p><input type="submit" name="loginSubmit" id="loginSubmit" class="button cursor" value="Login" /></p>
            </form>
          </div>
        <?php } else { ?>
          <span class="small-text">Welcome back, member!</span>
          <div id="login-content">
            <form name="frmLogin" method="post" action="/home/logout">
              <input type="submit" name="logoutSubmit" id="logoutSubmit" class="button cursor" value="Logout" />
            </form>
          </div>
        <?php } ?>
        </div>
        <!-- END: Login Box -->
      </div>