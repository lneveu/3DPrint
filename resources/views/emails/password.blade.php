<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Changer votre mot de passe</h2>

<p>Cliquez ici pour changer votre mot de passe :</p>

<p><a href="{{ url('password/reset/'.$token) }}">{{ url('password/reset/'.$token) }}</a></p>


</body>
</html>
