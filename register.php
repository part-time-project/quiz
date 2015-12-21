<?php

require 'src/User.php';
require 'src/Session.php';

// user model
$user = new \Model\User();
// session model
$sessUser = new \Src\Session();

// redirect to questions if logged in user
if ($sessUser->getIsLoggedIn()) {
    header('location: /quiz');
    exit(0);
}

$provinces = array(
    '0' => 'SELEZIONA PROVINCIA',
    'italia' => 'Italia'
);
$professions = array(
    '0' => 'PROFESSIONE',
    'developer' => 'Developer'
);

$fbId = '';
$fName = '';
$lName = '';
$email = '';
$province = '';
$profession = '';
$phone = '';
$legal = '';
$errors = array('fName' => '', 'lName' => '', 'email' => '', 'phone' => '', 'legal' => '');
$valid = true;

if (!empty($_POST)) {
    $fbId = $_POST['fb_id'];
    $fName = $_POST['fname'];
    $lName = $_POST['lname'];
    $email = $_POST['email'];
    $province = $_POST['province'];
    $profession = $_POST['profession'];
    $phone = $_POST['phone'];

    if (empty($fbId)) {
        $valid = false;
    }

    if (!isset($_POST['legal'])) {
        $errors['legal'] = 'false';
        $valid = false;
    } else {
        $legal = 'checked="checked"';
    }

    if (empty($_POST['fname'])) {
        $errors['fName'] = 'empty';
        $valid = false;
    }

    if (empty($_POST['lname'])) {
        $errors['lName'] = 'empty';
        $valid = false;
    }

    if (empty($_POST['email'])) {
        $errors['email'] = 'empty';
        $valid = false;
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'invalid';
            $valid = false;
        }
    }

    if (empty($_POST['phone'])) {
        $errors['phone'] = 'empty';
        $valid = false;
    } else {
        if (!is_numeric($_POST['phone'])) {
            $errors['phone'] = 'invalid';
            $valid = false;
        }
    }

    // email check
    if ($user->findBy('email', $email)) {
        $errors['email'] = 'invalid';
        $valid = false;
    }

    if ($valid) {
        if ($user->save(array(
            'fb_id' => $fbId,
            'email' => $email,
            'f_name' => $fName,
            'l_name' => $lName,
            'province' => $province,
            'phone' => $phone,
            'profession' => $profession
        ))) {
            header("Location: login?fb_id=" . $fbId);
            exit();
        }
    }
} else {
    $fName = isset($_GET['fname']) ? $_GET['fname'] : '';
    $lName = isset($_GET['lname']) ? $_GET['lname'] : '';
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    $fbId = isset($_GET['fb_id']) ? $_GET['fb_id'] : '';
}
?>
<div id="register" class="center-block text-center">
    <div id="register-form">
        <form action="/register" method="POST">
            <div class="form-group <?php echo (!empty($errors['fName'])) ? 'has-error' : ''; ?>">
                <input type="text" class="form-control" name="fname" required placeholder="NOME" value="<?php echo $fName ?>">
            </div>
            <div class="form-group <?php echo (!empty($errors['lName'])) ? 'has-error' : ''; ?>">
                <input type="text" class="form-control" name="lname" required placeholder="COGNAME" value="<?php echo $lName ?>">
            </div>
            <div class="form-group <?php echo (!empty($errors['province'])) ? 'has-error' : ''; ?>">
                <select name="province" class="form-control">
                    <?php foreach ($provinces as $provinceKey => $provinceValue): ?>
                        <option value="<?php echo $provinceKey; ?>" <?php echo ($province == $provinceKey) ? 'checked="checked"' : ''; ?>>
                            <?php echo $provinceValue; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group <?php echo (!empty($errors['phone'])) ? 'has-error' : ''; ?>">
                <input type="number" class="form-control" required name="phone" placeholder="TELEFONO" value="<?php echo $phone ?>">
            </div>
            <div class="form-group <?php echo (!empty($errors['email'])) ? 'has-error' : ''; ?>">
                <input type="email" class="form-control" required name="email" placeholder="EMAIL" value="<?php echo $email ?>">
            </div>
            <div class="form-group <?php echo (!empty($errors['profession'])) ? 'has-error' : ''; ?>">
                <select name="profession" class="form-control">
                    <?php foreach ($professions as $professionKey => $professionValue): ?>
                        <option value="<?php echo $professionKey; ?>" <?php echo ($profession == $professionKey) ? 'checked="checked"' : ''; ?>>
                            <?php echo $professionValue; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="checkbox <?php echo (!empty($errors['legal'])) ? 'has-error' : ''; ?>">
                <label>
                    <input type="checkbox" name="legal" value="1"<?php echo $legal; ?>> I agree with Terms and
                    Conditions
                </label>
            </div>
            <input type="hidden" name="fb_id" value="<?php echo $fbId; ?>">
            <button type="submit" id="register-button"></button>
        </form>
    </div>
</div>