<?php
ob_start();


include_once __DIR__."\app/database/config.php";
include_once __DIR__."\app/database/operations.php";
include_once __DIR__."\app/models/user.php";
include_once __DIR__."\app/middleware/auth.php";
include_once "app/services/email.php";



if($_POST){

$errors = [];

$user = new User();


        // Validate email
        if (empty($_POST['email'])) {
            $errors['email'] = "Please enter an email address";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Please enter a valid email address";
        } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST['email'])) {
            $errors['email'] = "Please enter a valid email address in the correct format";
        }

        if(empty($errors)){
            $user_object = new User();
            $user_object->setEmail($_POST['email']);
            $result = $user_object->get_user_by_email();
            if($result){
                $user = $result->fetch_object();
                $code = rand(10000, 99999);
                $user_object->setCode($code);
                $result_update = $user_object->update_code_by_email();
                if($result_update){
                    $subject = "Forget Password Code";
                    $body = "Hello {$user->first_name} {$user->last_name} . Your Forget Password Code is:<br>$code<br>
                    Thank you.";
                    $email = new mail($_POST['email'], $subject, $body);
                    $mail_result = $email->send();
                    if($mail_result){
                        $_SESSION['user_email'] = $_POST['email'];
                        header('location:check_code.php?page=forget_password');
                    }else{
                        $errors['mail_error'] = "Try again later";
                    }
                }else{
                    $errors['some_wrong'] = "Somthing wrong";
                }
            }else{
                $errors['wrong_email'] = "This Email Not Exists";
            }
        }

}
?>
<div class="login-register-area ptb-100">
<div class="container">
<style>
h1 {
    text-align: center;
    }
</style>

<h1>Verifcation Code</h1>
<div class="row">
    <div class="col-lg-7 col-md-12 ml-auto mr-auto">
        <div class="login-register-wrapper">
            <div class="login-register-tab-list nav">
                <a class="active" data-toggle="tab" href="#lg1">
                    <h4> </h4>
                </a>
            </div>
            <div class="tab-content">
                <div id="lg1" class="tab-pane active">
                    <div class="login-form-container">
                        <div class="login-register-form">
                            <form method="post">
                            <?php if(isset($errors['wrong_email'])): ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo $errors['wrong_email']; ?>
                                    </div>
                                    <?php endif; ?>
                                <input name="email" type="email" name="email" placeholder="Enter Your Email Address"
                                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                                <?php if(isset($errors['email'])): ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo $errors['email']; ?>
                                    </div>
                                    <?php endif; ?>
                                <div class="button-box">
                                    <button type="submit"><span>Verify Email Address</span></button>
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
/* Style for login-register-area */
.login-register-area {
  background-color: #f7f7f7;
  padding-top: 150px;
}

/* Style for login-register-wrapper */
.login-register-wrapper {
  background-color: #fff;
  padding: 40px;
  border-radius: 5px;
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
  margin: auto;
    width: 60%;
}

/* Style for login-register-tab-list */
.login-register-tab-list {
  border-bottom: 1px solid #eee;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Style for active login-register-tab-list */
.login-register-tab-list a.active {
  color: #333;
  border-bottom: 2px solid #333;
}

/* Style for login-register-form */
.login-register-form {
  margin-top: 30px;
}

/* Style for input fields */
.login-register-form input[type="email"] {
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 16px;
  margin-bottom: 20px;
}

/* Style for button-box */
.button-box {
  text-align: center;
}

/* Style for button */
.button-box button[type="submit"] {
  background-color: #333;
  color: #fff;
  padding: 10px 20px;
  border-radius: 5px;
  border: none;
  font-size: 16px;
  cursor: pointer;
}

/* Style for button hover */
.button-box button[type="submit"]:hover {
  background-color: #555;
}

</style>

<?php
ob_end_flush();
?>