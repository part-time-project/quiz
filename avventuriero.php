<?php
require PROJECT_PATH . 'src/Session.php';

// session model
$sessUser = new \Src\Session();

// redirect to questions if logged in user
if (!$sessUser->getIsLoggedIn() || $sessUser->getProfile() == "") {
    header('location: /quiz');
    exit(0);
}
?>
<div id="avventuriero" class="center-block text-center">
    <div id="share-text">
        Sei una persona che vive d'istinto e con l'acceleratore premuto. Ti piace vivere alla giornata e non ami
        programmare troppo la tua vita. I fuori programma sono sempre ben accetti, ma a volte fermare a riflettere può
        avere dei vantaggi: provaci nel 2016.
        <button id="share-button"></button>
    </div>
</div>

<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: '1710186109195271',
            xfbml: true,
            version: 'v2.5',
            cookie: true
        });
    };
    // Load the SDK asynchronously
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function postToFeed() {
        var obj = {
            method: 'feed',
            link: "<?php echo PROJECT_URL; ?>" + "avventuriero",
            picture: "<?php echo PROJECT_URL; ?>" + 'images/backgrounds/avventuriero.png',
            name: "Avventuriero",
            description: "Lorem Ipsum è un testo segnaposto utilizzato nel settore della tiapografia e della stampa."
        };

        FB.ui(obj, function (res) {
            console.log(res);
        });
    }

    $('#share-button').click(function () {
        postToFeed();
    });
</script>