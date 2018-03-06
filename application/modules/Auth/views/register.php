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
        <div class="wrap-login100" style="padding-top:50px">
          <div class="login100-pic js-tilt" data-tilt>
            <img src="<?=base_url()?>appsources/mypouch-color.png" alt="">
          </div>

          <form class="login100-form validate-form" id="regis">
            <span class="regis100-form-title">Feel the different experience</span>
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
            <div class="wrap-input100 validate-input">
              <input class="input100" type="text" name="name" placeholder="Full Name" required>
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-user" aria-hidden="true"></i>
              </span>
            </div>
            <div class="wrap-input100 validate-input">
              <input class="input100" type="text" name="phone" placeholder="Phone Number" required>
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-phone" aria-hidden="true"></i>
              </span>
            </div>
            <div class="wrap-input100 validate-input">
              <input class="input100" type="text" name="business_name" placeholder="Business Name" required>
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-building" aria-hidden="true"></i>
              </span>
            </div>
            <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
              <input class="input100" type="text" name="business_email" placeholder="Business Email" required>
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>

            <div class="container-login100-form-btn">
              <button class="login100-form-btn" type="submit">Create Account</button>
              <p style="margin-top:10px">Already have an account ? <a href="<?=base_url()?>auth/login">Login Here</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?=$this->layout->loadjslogin()?>
  </body>
</html>
