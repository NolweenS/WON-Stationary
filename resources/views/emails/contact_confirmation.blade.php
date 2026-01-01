<!DOCTYPE html>
<html>
<head><title>Bevestiging</title></head>
<body>
<h2>Beste {{ $data['name'] }},</h2>
<p>Bedankt voor je bericht! We hebben het goed ontvangen en nemen snel contact op.</p>
<br>
<p><strong>Jouw bericht:</strong></p>
<p>{!! nl2br(e($data['message'])) !!}</p>
<br>
<p>Met vriendelijke groet,<br>WON-Stationary</p>
</body>
</html>

