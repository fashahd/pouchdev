<?=$this->layout->headerlogin()?>
<!DOCTYPE html>
<html lang="en">
  <body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TG56HNW"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="limiter">
      <div class="container-login100">
        <div class="wrap-login100">
          <div class="login100-pic js-tilt" data-tilt>
            <img src="<?=base_url()?>appsources/mypouch-color.png" alt="">
          </div>

          <form class="login100-form validate-form" id="login">
            <span class="login100-form-title">Dashboard Login</span>
            <span class="regis-error" id="errormsg"></span>
            <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
              <input class="input100" type="text" name="email" placeholder="Email" required>
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>

            <div class="wrap-input100 validate-input" data-validate = "Password is required">
              <input class="input100" type="password" name="password" placeholder="Password" required>
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
              </span>
            </div>

            <div class="container-login100-form-btn" id="btnlogin">
              <button class="login100-form-btn" type="submit">Login</button>
            </div>

            <div class="text-center p-t-12">
              <span class="txt1">Forgot </span><a class="txt2" href="#">Password?</a>
            </div>

            <div class="text-center p-t-136">
              <a class="txt2" href="<?=base_url()?>auth/register">Create your Account<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i></a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?=$this->layout->loadjslogin()?>
  </body>
</html>
