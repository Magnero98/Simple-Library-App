<?php
	include_once "Book.php";

	class dbConnection
	{
		public static $DBSERVER = "fdb19.awardspace.net";
		public static $DBNAME = "2590143_mydbase";
		public static $USERNAME = "2590143_mydbase";
		public static $PASS = "yansen12";

		public static function buildConnection()
		{
			$con = mysqli_connect(self::$DBSERVER, self::$USERNAME, self::$PASS, self::$DBNAME);

			if(!$con)
			{
				die("Could not connect: ".mysql_error());
			}

			mysqli_select_db($con, self::$DBNAME);

			return $con;
		}

		public static function fromQueryResultToJSON($queryResult)
		{
			$books = array();

			while($row = mysqli_fetch_assoc($queryResult))
			{
				$books[] = $row;
			}

			return json_encode($books);
		}

		public static function fromArrayToBookObject($array)
		{
			$book = new Book();

			$book->setName($array["BookName"]);
			$book->setPrice($array["BookPrice"]);
			$book->setStock($array["BookStock"]);

			return $book;
		}

		public static function buildSQLStringFromArray(&$query, $array)
		{
			foreach($array as $element)
			{
				$query .= $element;
				if($element != end($array))
					$query .= ", ";
				else
					$query .= " ";
			}
		}

		/*====================================================================*/

		public static function retriveData($colums = NULL, $tables = NULL, $conditions = NULL, $values = NULL)
		{
			$connection = self::buildConnection();
			$query = self::buildSelectString($colums, $tables, $conditions, $values);

			$queryResult = mysqli_query($connection, $query);

			if(!$queryResult)
				echo mysqli_error($connection);
			else
				return $queryResult;
		}

		public static function buildSelectString($colums = NULL, $tables = NULL, $conditions = NULL, $values = NULL)
		{
			//SELECT
			$query = "SELECT ";

			//COLUMS
			if(!is_null($colums))
				self::buildSQLStringFromArray($query, $colums);
			else
				$query .= "* ";

			//FROM
			$query .= "FROM ";

			//TABLES
			self::buildSQLStringFromArray($query, $tables);

			//WHERE
			$query .= "WHERE ";

			//CONDITIONS
			if(!is_null($conditions))
				self::buildConditionStatements($query, $conditions, $values);
			else
				$query .= "1";

			return $query;
		}

		public static function buildConditionStatements(&$query, $conditions, $values)
		{
			if(!is_null($conditions))
			{
				for($i = 0; $i < sizeof($conditions); $i++)
				{
					$query .= $conditions[$i];
					$query .= " = '";
					$query .= $values[$i] . "' ";

					if($i != sizeof($conditions) - 1)
						$query .= "&& ";
				}
			}
		}

		/*====================================================================*/

		public static function insertData($table, $colums, $object)
		{
			$connection = self::buildConnection();
			$query = self::buildInsertString($table, $colums, $object);

			$queryResult = mysqli_query($connection, $query);
			print_r($queryResult);

			if(!$queryResult)
				echo mysqli_error($connection);
			else
				return $queryResult;
		}

		public static function buildInsertString($table, $colums, $object)
		{
			$query = "INSERT INTO ";
			$query .= $table . "(";
			self::buildSQLStringFromArray($query, $colums);
			$query .= ") VALUES ";
			self::fromBookObjectToQuery($query, $object);
			$query .= ";";

			return $query;
		}

		public static function fromBookObjectToQuery(&$query, $object)
		{
			$query .= "(";
			$query .= "'" . $object->getName() . "'";
			$query .= ",";
			$query .= $object->getPrice();
			$query .= ",";
			$query .= $object->getStock();
			$query .= ")";
		}
	}
?>