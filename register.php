<?php

require PROJECT_PATH . 'src/User.php';
require PROJECT_PATH . 'src/Session.php';

// user model
$user = new \Model\User();
// session model
$sessUser = new \Src\Session();

// redirect to questions if logged in user
if ($sessUser->getIsLoggedIn()) {
    header('location: quiz');
    exit(0);
}

$provinces = array(
    '0' => 'SELEZIONA PROVINCIA',
    'agrigento' => 'Agrigento',
    'alessandria' => 'Alessandria',
    'ancona' => 'Ancona',
    'aosta' => 'Aosta',
    'arezzo' => 'Arezzo',
    'ascoli_piceno' => 'Ascoli Piceno',
    'asti' => 'Asti',
    'avellino' => 'Avellino',
    'bari' => 'Bari',
    'barletta_andria_trani' => 'Barletta-Andria-Trani',
    'belluno' => 'Belluno',
    'benevento' => 'Benevento',
    'bergamo' => 'Bergamo',
    'biella' => 'Biella',
    'bologna' => 'Bologna',
    'bolzano' => 'Bolzano',
    'brescia' => 'Brescia',
    'brindisi' => 'Brindisi',
    'cagliari' => 'Cagliari',
    'caltanissetta' => 'Caltanissetta',
    'campobasso' => 'Campobasso',
    'carbonia_iglesias' => 'Carbonia-Iglesias',
    'caserta' => 'Caserta',
    'catania' => 'Catania',
    'catanzaro' => 'Catanzaro',
    'chieti' => 'Chieti',
    'como' => 'Como',
    'cosenza' => 'Cosenza',
    'cremona' => 'Cremona',
    'crotone' => 'Crotone',
    'cuneo' => 'Cuneo',
    'enna' => 'Enna',
    'ferrara' => 'Ferrara',
    'firenze' => 'Firenze',
    'foggia' => 'Foggia',
    'forlì_cesena' => 'Forlì-Cesena',
    'frosinone' => 'Frosinone',
    'genova' => 'Genova',
    'gorizia' => 'Gorizia',
    'grosseto' => 'Grosseto',
    'imperia' => 'Imperia',
    'isernia' => 'Isernia',
    'l_aquila' => 'L\'Aquila',
    'la_spezia' => 'La Spezia',
    'latina' => 'Latina',
    'lecce' => 'Lecce',
    'lecco' => 'Lecco',
    'livorno' => 'Livorno',
    'lodi' => 'Lodi',
    'lucca' => 'Lucca',
    'macerata' => 'Macerata',
    'mantova' => 'Mantova',
    'massa_carrara' => 'Massa-Carrara',
    'matera' => 'Matera',
    'medio_campidano' => 'Medio Campidano',
    'messina' => 'Messina',
    'milano' => 'Milano',
    'modena' => 'Modena',
    'monza_brianza' => 'Monza-Brianza',
    'napoli' => 'Napoli',
    'novara' => 'Novara',
    'nuoro' => 'Nuoro',
    'ogliastra' => 'Ogliastra',
    'olbia_tempio' => 'Olbia-Tempio',
    'oristano' => 'Oristano',
    'padova' => 'Padova',
    'palermo' => 'Palermo',
    'parma' => 'Parma',
    'pavia' => 'Pavia',
    'perugia' => 'Perugia',
    'pesaro_e_urbino' => 'Pesaro e Urbino',
    'pescara' => 'Pescara',
    'piacenza' => 'Piacenza',
    'pisa' => 'Pisa',
    'pistoia' => 'Pistoia',
    'pordenone' => 'Pordenone',
    'potenza' => 'Potenza',
    'prato' => 'Prato',
    'ragusa' => 'Ragusa',
    'ravenna' => 'Ravenna',
    'reggio_calabria' => 'Reggio Calabria',
    'reggio_emilia' => 'Reggio Emilia',
    'rieti' => 'Rieti',
    'rimini' => 'Rimini',
    'roma' => 'Roma',
    'rovigo' => 'Rovigo',
    'salerno' => 'Salerno',
    'sassari' => 'Sassari',
    'savona' => 'Savona',
    'siena' => 'Siena',
    'siracusa' => 'Siracusa',
    'sondrio' => 'Sondrio',
    'taranto' => 'Taranto',
    'teramo' => 'Teramo',
    'terni' => 'Terni',
    'torino' => 'Torino',
    'trapani' => 'Trapani',
    'trento' => 'Trento',
    'treviso' => 'Treviso',
    'trieste' => 'Trieste',
    'udine' => 'Udine',
    'varese' => 'Varese',
    'venezia' => 'Venezia',
    'verbano_cusio_ossola' => 'Verbano-Cusio-Ossola',
    'vercelli' => 'Vercelli',
    'verona' => 'Verona',
    'vibo_valentia' => 'Vibo Valentia',
    'vicenza' => 'Vicenza',
    'viterbo' => 'Viterbo'
);
$professions = array(
    '0' => 'SELEZIONA PROFESSIONE',
    'pubblico' => 'Pubblico',
    'statale' => 'Statale',
    'pensionato' => 'Pensionato',
    'privato' => 'Privato',
    'altro' => 'Altro'
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
        <form action="" method="POST">
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
                <label class="text-left" style="font-size: 70%; margin-bottom: 0;">
                    <input type="checkbox" name="legal" value="1"<?php echo $legal; ?>>
                    (*) Dichiaro di essere in possesso dei requisiti per partecipare al concorso e di
                    accettare il regolamento. Autorizzo al trattamento dei datipersonali per
                    tutte le finalità come descritto nell`informativa sulla privacy. Per visualizzare
                    le condizioni clicca qui
                </label>
            </div>
            <input type="hidden" name="fb_id" value="<?php echo $fbId; ?>">
            <button type="submit" id="register-button"></button>
        </form>
    </div>
</div>
