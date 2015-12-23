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
<div id="saggio" class="center-block text-center">
    <div id="share-text">
        Sei una persona che riflette prima di agire. Per il prossimo anno, ti suggeriamo di metterti alla prova cercando
        di fare qualcosa d'istinto, vedrai che sarà un'esperienza da non dimenticare. Non fare follie però, usa sempre
        la testa :)
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
            link: "<?php echo PROJECT_URL; ?>" + "saggio",
            picture: "<?php echo PROJECT_URL; ?>" + 'images/backgrounds/saggio.png',
            name: "Saggio",
            description: "Sei una persona che riflette prima di agire. Per il prossimo anno, ti suggeriamo di metterti alla prova cercando di fare qualcosa d'istinto, vedrai che sarà un'esperienza da non dimenticare. Non fare follie però, usa sempre la testa :)"
        };

        FB.ui(obj, function (res) {
            console.log(res);
        });
    }

    $('#share-button').click(function () {
        postToFeed();
    });
</script>