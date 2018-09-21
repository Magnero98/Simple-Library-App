function Book(name, price, stock)
{
	this.BookName = name;
	this.BookPrice = price;
	this.BookStock = stock;
}

/*=====================================================================*/

function hideAllInterfaces()
{
	var interface = document.getElementsByClassName("interface");

	for (var i = 0; i < interface.length; i++) {
		interface[i].style.display = "none";
	}
}

function toggleInterface(id, command)
{
	var element = document.getElementById(id);
	var displayType = "";

	if(command == "show")
		displayType = "block";
	else if(command == "hide")
		displayType = "none";

	element.style.display = displayType;
}

function backToMainMenu()
{
	hideAllInterfaces();
	toggleInterface("mainMenu", "show");
}

/*=====================================================================*/

function menuRequest()
{
	var input = $("input[name=menuInput]").val();
	menuResult(input, "mainMenu");
}

function menuResult(input, currentInterfaceId)
{
	toggleInterface(currentInterfaceId, "hide");

	switch(parseInt(input))
	{
		case 1:
			toggleInterface("addBookForm", "show");
			break;
		case 2:
			getBookListFromServer();
			break;
		case 3:
			alert("Thank You For Today! Have Fun!");
			break;
	}
}

/*=====================================================================*/

function getAndConvertFormInput()
{
	var bookName = $("input[name=bookName]").val();
	var bookPrice = $("input[name=bookPrice]").val();
	var bookStock = $("input[name=bookStock]").val();

	var book = new Book(bookName, bookPrice, bookStock);

	return JSON.stringify(book);
}

function sendFormInputToServer()
{
	var JSONData = getAndConvertFormInput();

	/*$.post
	(
		"bookApp.php", 
		{
			data: 
			{
				request: "addNewBook",
				JSONString: JSONData
			}
		},
		function(data, status)
		{
			alert("Adding New Book Status : " + status);
		}
	)*/

	$.ajax
	(
		{
			url: "bookApp.php",
			type: "POST",
			processDataBoolean: "false",
			data: 
			{
				request: "addNewBook",
				JSONString: JSONData
			},
			success: function(result)
			{
				alert("Response : " + result);
			},
			error: function(responseData, textStatus, errorThrown) {
                $(document).ajaxError(function(e, xhr, opt, exc){
                    //alert("Error Response : " + JSON.stringify(errorThrown));
                });
            }
		}
	);
}

/*=====================================================================*/

function getBookListFromServer()
{
	$.ajax
	(
		{
			url: "bookApp.php",
			type: "POST",
			processDataBoolean: "false",
			data: 
			{
				request: "bookList"
			},
			success: function(result)
			{
				//alert("Response : " + result);
				return showBookList(result);;
			},
			error: function(responseData, textStatus, errorThrown) {
                $(document).ajaxError(function(e, xhr, opt, exc){
                    //alert(JSON.stringify(exc));
                });
            }
		}
	);
}

function showBookList(JSONResult)
{
	var ArrayOfBook = fromJSONToBookArray(JSONResult);

	var listBox = $("#bookListBox");
	listBox.html(makeABookListHTML(ArrayOfBook));

	toggleInterface("bookListView", "show");
}

function fromJSONToBookArray(JSONData)
{
	var bookList = [];
	var JSONObj = JSON.parse(JSONData);

	for(var i = 0; i < JSONObj.length; i++)
	{
		var book = new Book
		(
			JSONObj[i].BookName,
			JSONObj[i].BookPrice,
			JSONObj[i].BookStock
		);

		//alert(JSON.stringify(book));

		bookList.push(book);
	}

	return bookList;
}

function makeABookListHTML(books)
{
	var listView = "";

	for(element in books)
	{
		listView += "<button>";
		listView += "Title  : " + books[element].BookName;
		listView += "<br>";
		listView += "Price  : " + books[element].BookPrice;
		listView += "<br>";
		listView += "Stock  : " + books[element].BookStock;
		listView += "</button>";
		listView += "<br><br>";
	}

	return listView;
}