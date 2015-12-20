<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '1710186109195271',
			xfbml      : true,
			version    : 'v2.5',
			cookie     : true
		});
	};

	// Load the SDK asynchronously
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	function fb_login(){
		FB.login(function(response) {

			if (response.authResponse) {
				console.log('Welcome!  Fetching your information.... ');
				//console.log(response); // dump complete info
				access_token = response.authResponse.accessToken; //get access token
				user_id = response.authResponse.userID; //get FB UID

				FB.api('/me', function(response) {
					var names = response.name.split(" ");
					var lastNameParam = (names.length > 1) ? "&lname=" + names[1] : "";
					var emailParam = (typeof response.email !== "undefined") ? "&email=" + response.email : "";
					var fbIdParam = response.id;

					// ajax check by fb id
					// jquery ajax call

					// not existing fb id
					if (true) {
						window.location.href = "/register?fname=" + names[0] + lastNameParam + emailParam + "&fb_id=" + fbIdParam;
					} else {
						window.location.href = "/login?fb_id=" + fbIdParam;
					}
				});

			} else {
				//user hit cancel button
				console.log('User cancelled login or did not fully authorize.');

			}
		}, {
			scope: 'public_profile,email'
		});
	}
</script>

<div id="homepage" class="center-block text-center">
	<div id="homepage-text">
		Lorem Ipsum è un testo segnaposto<br />
		utilizzato nel settore della tiapografia<br />
		e della stampa. Lorem Ipsum è<br />
		considerato il testo segnaposto<br />
		standard sin dal sedicesimo secolo,<br />
		quando un anonimo tipografo.
	</div>
	<a href="javascript:void(0)" onclick="fb_login();" id="homepage-button"></a>
</div>