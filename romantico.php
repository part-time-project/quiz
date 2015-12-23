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
<div id="innamorato" class="center-block text-center">
    <div id="romantico-text">
        Sei una persona che ama condivide le proprie esperienze e non riesci ad
        immaginare la tua vita da single. Per te tutto ha più colore a stare in due,
        ma per il 2016 prova anche a ricavarti un pò di tempo solo per te, ti aiuterà ad
        essere ancora più romantico :)
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
            link: "<?php echo PROJECT_URL; ?>" + "innamorato",
            picture: "<?php echo PROJECT_URL; ?>" + 'images/backgrounds/innamorato.png',
            name: "Innamorato",
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