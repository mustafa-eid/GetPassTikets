<?php

include_once __DIR__."\app/database/config.php";
include_once __DIR__."\app/database/operations.php";
include_once __DIR__."\app/models/user.php";
include_once __DIR__."\app/middleware/auth.php";

    if ($_POST) {
        $errors = [];

        // Validate password
        if (empty($_POST['password'])) {
        $errors['password'] = "Password is required";
        } elseif (strlen($_POST['password']) < 8) {
            $errors['password'] = "Password must be at least 8 characters long";
        } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!])(?=.{8,})/", $_POST['password'])) {
            $errors['password'] = "Password must include at least one uppercase letter,
            one lowercase letter, one number, and one special character (@#$%^&+=!)";
        }
        
            // Validate confirm_password
        if (empty($_POST['confirm_password'])) {
            $errors['confirm_password'] = '<div class="alert alert-danger" role="alert">
            Please confirm your password
            </div>';
        } elseif (strcmp($_POST['password'], $_POST['confirm_password']) !== 0) {
            $errors['confirm_password'] = '<div class="alert alert-danger" role="alert">
            Passwords do not match
            </div>';
        }

    if (empty($errors)) {

    $user_object = new User();

    $user_object->setpassword($_POST['password']);
    $user_object->setEmail($_SESSION['user_email']);

    $update_password_result = $user_object->update_password_by_email();
    if ($update_password_result) {
    unset($_SESSION['user_email']);
    $success = "Your Password Has Been Successfully Updated";
    header('Refresh:3; url=sign.php');
    }
    } else {
    $errors['wronge'] = "Somthing went wronge";
    }
    }
    ?>

<div class="login-register-area ptb-100">
<style>
h1 {
    text-align: center;
    }
</style>

<h1>Reset Password</h1>
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4></h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                <?php
                                if(isset($success)){
                                echo "<div class='alert alert-success'>$success</div>";
                                }
                                ?>
                                    <form method="post">
                                        <input type="password" name="password" placeholder=" Enter Your New Password">
                                        <?php if(isset($errors['password'])): ?>
                                        <div class="invalid-feedback d-block">
                                            <?php echo $errors['password']; ?>
                                        </div>
                                        <?php endif; ?>
                                        <input type="password" name="confirm_password"
                                            placeholder="Confirm Password">
                                            <?php if(isset($errors['confirm_password'])): ?>
    <div class="alert alert-danger">
        <?php echo $errors['confirm_password']; ?>
    </div>
<?php endif; ?>
                                        <div class="button-box">
                                            <button type="submit" name="login"><span></span>Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
.login-register-area {
  background-color: #f7f7f7;
  padding: 100px 0;
}

.login-register-wrapper {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
  padding: 30px;
  width: 70%;
    margin: auto;
}

.login-register-tab-list {
  display: flex;
  margin-bottom: 30px;
}

.login-register-tab-list a {
  border: none;
  color: #333;
  font-size: 16px;
  font-weight: 600;
  margin-right: 30px;
  padding-bottom: 10px;
  text-transform: uppercase;
}

.login-register-tab-list a.active,
.login-register-tab-list a:hover {
  border-bottom: 2px solid #333;
  color: #333;
}

.login-form-container input[type="password"] {
  background-color: #f2f2f2;
  border: none;
  border-radius: 3px;
  color: #333;
  font-size: 16px;
  margin-bottom: 20px;
  padding: 15px;
  width: 100%;
}

.login-form-container .button-box {
  margin-top: 30px;
  text-align: center;
}

.login-form-container button[type="submit"] {
  background-color: #333;
  border: none;
  border-radius: 3px;
  color: #fff;
  cursor: pointer;
  font-size: 16px;
  padding: 15px 30px;
  text-transform: uppercase;
  transition: background-color 0.3s ease;
}

.login-form-container button[type="submit"]:hover {
  background-color: #222;
}

</style>