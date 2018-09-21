<?php
	include_once "dbconnection.php";

	/*if($_POST["request"] == "addNewBook")
	{
		insertNewBook();
	}
	else if($_POST["request"] == "bookList")
	{
		Book::getBookList();
	}
	else
	{

	}*/
	if($_GET["request"] == "test")
	{
		$myJSON = '{ "response":"good"}';
		echo "myFunc(".$myJSON.");";
	}
	else
	{
		$myJSON = '{ "response":"invalid request"}';
		echo "myFunc(".$myJSON.");";
	}

	function insertNewBook()
	{
		$JSONString = json_decode($_POST["JSONString"]);
		$book = Book::createBookUsingFields($JSONString->BookName, $JSONString->BookPrice,$JSONString->BookStock);

		$book->addNewBook();
	}
?>