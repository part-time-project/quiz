<?php
require PROJECT_PATH . 'src/Session.php';
// session model
$sessUser = new \Src\Session();
// redirect to questions if logged in user
if (!$sessUser->getIsLoggedIn()) {
//    header('location: home-page');
//    exit(0);
}
?>
<script src="js/spin.js"></script>

<div id="questions" class="center-block text-center">
    <div id="question" class="text-uppercase" data-id="1"></div>
    <div class="question-container">
        <button id="question-button-0" data-id="1"></button>
        <div id="question-button-text-0"></div>
    </div>
    <div class="question-container">
        <button id="question-button-1" data-id="2"></button>
        <div id="question-button-text-1"></div>
    </div>
    <div class="question-container">
        <button id="question-button-2" data-id="3"></button>
        <div id="question-button-text-2"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var spinner = new Spinner();

        function loadQuestion(questionId) {
            spinner.spin($("#questions").get(0));
            $.ajax({
                url: "quiz_info.php?question_id=" + questionId,
                dataType: "json",
                success: function (response) {
                    if (response.status === "OK") {
                        $("#question").text(response.data.question);
                        $.each(response.data.answers, function (i, e) {
                            $("#question-button-text-" + i).text(e);
                        });
                    }

                    spinner.stop();
                    $("#question-button-0, #question-button-1, #question-button-2").removeClass("active");
                }
            });
        }

        function storeAnswer(questionId, answerId) {
            $.ajax({
                url: "quiz_answer.php?question_id=" + questionId + "&answer_id=" + answerId,
                dataType: "json",
                success: function (response) {
                    if (response.status === "OK") {
                        if (response.profile !== "") {
                            window.location.href = response.profile;
                        }
                    }
                }
            });
        }

        $("#questions button").click(function () {
            $(this).addClass("active");
            var questionId = $("#question").data("id");
            storeAnswer(questionId, $(this).data("id"));
            questionId++;
            $("#question").data("id", questionId);

            setTimeout(loadQuestion, 300, questionId);
        });

        loadQuestion($("#question").data("id"));
    });
</script>
