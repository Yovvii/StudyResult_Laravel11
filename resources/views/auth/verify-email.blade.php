<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verify</title>
</head>
<body>
    <h2>hi, your verification link already sent to your email.</h2><br>
    <form action="/email/verification-notification" method="post">
        @csrf
        <input type="submit" value="Resend Email Verification">
    </form>
</body>
</html>