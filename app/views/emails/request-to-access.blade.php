<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<h2>Новая заявка на доступ к документам</h2>
		<p>Заявка поступила от: {{ $post['name'] }} в {{ myDateTime::SwapDotDateWithTime(date("Y:m:d H:i:s",time())) }}</p>
		<ul>
			<li>Название организации - {{ $post['organisation'] }}</li>
			<li>Email - {{ $post['email'] }}</li>
			<li>Контактный телефон - {{ $post['phone'] }}</li>
		</ul>
	</div>
</body>
</html>