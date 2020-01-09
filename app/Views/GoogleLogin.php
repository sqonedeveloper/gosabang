<html>
<head>
<meta name="google-signin-client_id" content="441371402033-fm8vp26qi4sss3kqei83od1oj62nopic.apps.googleusercontent.com">
</head>
<body>
  <div style="left: 50%; top: 50%; position: relative;">
    <div id="my-signin2"></div>
  </div>
  <script>
    function onSuccess(googleUser) {
      console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
    }
    function onFailure(error) {
      console.log(error);
    }
    function renderButton() {
      gapi.signin2.render('my-signin2', {
        'scope': 'profile email',
        'width': 240,
        'height': 50,
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSuccess,
        'onfailure': onFailure
      });
    }
  </script>
  
  <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
</body>
</html>