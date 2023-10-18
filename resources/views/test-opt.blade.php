@extends('layouts.app')

@section('content')
<form id="test-auth">
    Phone: <input type="text" name="phone" id="phone">
    <div id="recaptcha-container"></div>
    <input type="submit" value="Submit">
</form>

<div class="mb-5 mt-5">
            <h3>Add verification code</h3>
            <div class="alert alert-success" id="successOtpAuth" style="display: none;"></div>
            <form>
                <input type="text" id="verification" class="form-control" placeholder="Verification code">
                <button type="button" class="btn btn-danger mt-3" onclick="verify()">Verify code</button>
            </form>
        </div>
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

<script type="module">
    var coderesult = 'scjksSS';
     const firebaseConfig = {
                apiKey: "AIzaSyBDtZHS4070uzcAgKfjGV7NTZDSpPGxWN4",
                authDomain: "studentregistartionch.firebaseapp.com",
                projectId: "studentregistartionch",
                storageBucket: "studentregistartionch.appspot.com",
                messagingSenderId: "828733803560",
                appId: "1:828733803560:web:2d0090e6b301ac7a0f791d",
                measurementId: "G-QJB7JYVC17"
            };
            firebase.initializeApp(firebaseConfig);

            window.onload = function () {
            render();
        };
        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }
    $('#test-auth').validate({
        submitHandler: function(form) {
            var number = $("#phone").val();
            firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
                console.log(confirmationResult);
                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                console.log(coderesult);
                $("#successAuth").text("Message sent");
                $("#successAuth").show();
            }).catch(function (error) {
                $("#error").text(error.message);
                $("#error").show();
            });
            
        }
    })

   
</script>
<script type="text/javascript">
  function verify() {
            var code = $("#verification").val();
            console.log(window.confirmationResult)
            window.confirmationResult.confirm(code).then(function (result) {
                var user = result.user;
                console.log(user);
                $("#successOtpAuth").text("Auth is successful");
                $("#successOtpAuth").show();
            }).catch(function (error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }
</script>
@stop