<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="ajax.js"></script>
</head>
<body onload="hideAllInterfaces();toggleInterface('mainMenu', 'show');">
	<div id="mainMenu" class="interface">
		<p>
			Welcome to Nanny's Bookrental<br>
			=============================<br>
			1.Add a book<br>
			2.View all rent books<br>
			3.Exit and delete all rent books<br><br>
			Choice:
		</p>
		<input type="text" name="menuInput">
		<button onclick="menuRequest()">Send</button>
	</div>

	<div id="addBookForm" class="interface">
		<form>
			<fieldset>
				<legend>Book's Name</legend>
				<label>Input Book's Name</label>
				<input type="text" name="bookName">
			</fieldset>
			<fieldset>
				<legend>Book's Price</legend>
				<label>Input Book's Price</label>
				<input type="text" name="bookPrice">
			</fieldset>
			<fieldset>
				<legend>Book's Stock</legend>
				<label>Input Book's Stock</label>
				<input type="text" name="bookStock">
			</fieldset>
			<br>
			<button onclick="sendFormInputToServer()">Add New Book</button>
			<br><br>
			<button onclick="backToMainMenu()">Back</button>
		</form>
	</div>

	<div id="bookListView" class="interface">
		<div id="bookListBox"></div>
		<label id="totalPriceLabel"></label>
		<br><br>
		<button onclick="backToMainMenu()">Back</button>
	</div>
</body>
</html>