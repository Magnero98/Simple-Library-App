<?php
	include_once "dbconnection.php";

	class Book
	{
		private $name = "";
		private $price = 0;
		private $stock = 0;

		public function getName(){ return $this->name; }
		public function getPrice(){ return $this->price; }
		public function getStock(){ return $this->stock; }

		public function setName($value){ $this->name = $value; }
		public function setPrice($value){ $this->price = $value; }
		public function setStock($value){ $this->stock = $value; }

		public static function createBookUsingFields($name, $price, $stock)
		{
			$book = new Book();
			$book->setName($name);
			$book->setPrice($price);
			$book->setStock($stock);

			return $book;
		}

		public function addNewBook()
		{
			$table = "Book";

			$colums = array();
			$colums[] = "BookName";
			$colums[] = "BookPrice";
			$colums[] = "BookStock";

			if(dbconnection::insertData($table, $colums, $this))
				echo "Insert Success";
		}

		public static function getBookList()
		{
			$tables = array();
			$tables[] = "Book";

			$queryResult = dbconnection::retriveData(NULL, $tables);
			echo dbconnection::fromQueryResultToJSON($queryResult);
		}
	}
?>