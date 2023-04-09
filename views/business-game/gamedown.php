<style type="text/css">
	.welcome{
		background: #0035ae;
		border-radius: 10px;
		font-family: Century Gothic;
		font-size: 20px;
		color: white;
		padding: 10px;
		margin-bottom: 20px;
	}

	.step_1{
		display: none;
		background: #0035ae;
		border-radius: 10px;
		font-family: Century Gothic;
		font-size: 20px;
		color: white;
		padding: 10px;
		margin-bottom: 20px;
	}

	.step_2{
		display: none;
		background: #0035ae;
		border-radius: 10px;
		font-family: Century Gothic;
		font-size: 20px;
		color: white;
		padding: 10px;
		margin-bottom: 20px;
	}

	.step_3{
		display: none;
		background: #0035ae;
		border-radius: 10px;
		font-family: Century Gothic;
		font-size: 20px;
		color: white;
		padding: 10px;
		margin-bottom: 20px;
	}

	.step_4{
		display: none;
		background: #0035ae;
		border-radius: 10px;
		font-family: Century Gothic;
		font-size: 20px;
		color: white;
		padding: 10px;
	}

	.lv{
		display: none;
		background: #0035ae;
		border-radius: 10px;
		font-family: Century Gothic;
		font-size: 20px;
		color: white;
		padding: 10px;
		margin-bottom: 20px;
	}

	.start_btn{
		background: #00ae79;
		border-radius: 5px;
	}

	.up{
		background: orange;
		border-radius: 5px;
	}

	.leave{
		background: white;
		border-radius: 5px;
	}
</style>

<div class="welcome">
	<b>Добро пожаловать в игру <<?php echo $model->name; ?>></b>
	<br><br>
	<b>Краткое описание игры:</b>
	<br>
	<?php echo $model->description; ?>
	<br><br>
	<button onclick="start()" class="start_btn">Начать игру</button>
</div>

<div id="1" class="step_1">
	<b>Ознакомьтесь с тендером</b>
	<br>
	<?php
	$steps = \app\models\Step::find()->where(['business_game_id' => $model->id])->all();
	echo $steps[0]->description;
	?>
	<br><br>
	<button class="start_btn" onclick="step1()">Перейти к шагу 2</button>
</div>

<div id="2" class="step_2">
	Оппонент понизил сумму!
	<br>Текущая цена: 11.000р
	<br><br>
	<button class="up" onclick="step2()">-2.000р</button>
	<button class="leave" onclick="leave()">Сдаться</button>
</div>

<div id="3" class="step_3">
	Оппонент понизил сумму!
	<br>Текущая цена: 8.000р
	<br><br>
	<button class="up" onclick="step3()">-1.000р</button>
	<button class="leave" onclick="leave()">Сдаться</button>
</div>


<div id="lv" class="lv">
	Тендер завершен. Не в Вашу пользу
	<br><br>
	<button class="start_btn" onclick="end()">Завершить игру</button>
</div>

<div id="sc" class="lv">
	Тендер завершен, Вы победили
	<br><br>
	<button class="start_btn" onclick="end()">Завершить игру</button>
</div>

<div id="4" class="step_4">
	
</div>




<script type="text/javascript">
	var s1 = 0;
	var s2 = 0;

	function start() {
		let elem = document.getElementById('1');
		elem.style.display = "block";
	}

	function step1() {
		let elem = document.getElementById('2');
		elem.style.display = "block";
	}

	function step2() {
		s1 = 1;
		let elem = document.getElementById('3');
		elem.style.display = "block";
	}

	function step3() {
		s2 = 0;
		let elem = document.getElementById('sc');
		elem.style.display = "block";
	}

	function leave() {
		if (s1 == 1) s2 = 1;
		let elem = document.getElementById('lv');
		elem.style.display = "block";
		
	}

	function end() {
		elem = document.getElementById('4');
		elem.style.display = "block";
		if (s1 == 1 && s2 == 1)
			elem.innerHTML = 'Вы приняли верное решение и не снизили сумму ниже средней по рынку!'
		else if (s1 == 0 && s2 == 0)
			elem.innerHTML = 'Вы слишком рано сдались.'
		else
			elem.innerHTML = 'Вы опустили сумму ниже средней по рынку, шанс убыточного контракта'

		setTimeout(() => { document.location.href = 'http://hack/index.php?r=business-game/result2&s1=' + s1 + '&s2=' + s2 }, 3000);
		
	}
</script>