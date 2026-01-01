<!DOCTYPE html>
<html>
<head><title>Nieuw Bericht</title></head>
<body>
<h2>Nieuw bericht via WON-Stationary</h2>
<p><strong>Naam:</strong> {{ $data['name'] }}</p>
<p><strong>E-mail:</strong> {{ $data['email'] }}</p>
<p><strong>Onderwerp:</strong> {{ $data['subject'] }}</p>
<br>
<p><strong>Bericht:</strong></p>
<p>{!! nl2br(e($data['message'])) !!}</p>
</body>
</html>
