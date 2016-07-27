
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};


function changeUrl(url){
    window.history.pushState(url, url, url);
    return false;
}

function setGetParametr(){
    if ($('#search').val()){
        changeUrl("?s=" + $('#search').val());
    }
}

function setGet(arg){
    if (arg){
        changeUrl(arg);
    }
}


function setSearchString(){
    if (getUrlParameter('s')){
	$('#search').val(getUrlParameter('s'));
	getBookList(getUrlParameter('s'));
    }
}

function addTd(item){
    var td = '<td>';
    var tde = '</td>'
     
    return td + item + tde;
}

function getBookList(bookName){
    setGetParametr();
    $("#booktable").html(""); //clear table
    document.title = bookName;
    $('#loading').addClass("loading");
    $(".search_out").css("height", "1%"); //move up search
    $.get("php/GetBooks.php?t=" + bookName, function(data, status){
        $('#loading').removeClass("loading");
	$(".search_out").css("position", "static");
	$("#search").css("border", "none");
	generateBookList(JSON.parse(data));
    });
}

function generateBookList(books){
	for(var i=0;i < books.length;i++){
	     var current = '<tr></tr>';
	     var authorName = (books[i].FirstName + ' ' + books[i].MiddleName + ' ' + books[i].LastName).replace(/ +(?= )/g,'');
	     var title = '<a class="pure-menu-heading pure-menu-link" style="height:100%;width:96%" href="/b/'+ books[i].BookId + '/read">' + books[i].Title + '</a>';
	     //var title = '<a class="pure-menu-heading pure-menu-link" style="height:100%;width:96%" onclick="readBook(' + books[i].BookId +')">' + books[i].Title + '</a>';
	     var author = '<a href="?s=' + authorName +'" class="pure-menu-link">' + authorName + '</a>';
	     var epub =  '<a href="/b/' + books[i].BookId + '/epub" class="pure-menu-link">epub</a>';
	     var mobi =  '<a href="/b/' + books[i].BookId + '/mobi" class="pure-menu-link">mobi</a>';
	     var fb2 =  '<a href="/b/' + books[i].BookId + '/fb2" class="pure-menu-link">fb2</a>';
	     var list = '<ul class="pure-menu-list">' + '</ul>';
	     var current_book = addTd(title) + addTd(author) + addTd(fb2) + addTd(epub) + addTd(mobi);
             $(current).appendTo('#booktable').append(current_book);
	}
}

function readBook(id){
    var addres = "b/" + id + "/read";
    $("#booktable").html(""); //clear table
    $("#search_div").html(""); //clear table
    $('#loading').addClass("loading");
    $.get(addres, function(data, status){
	setGet(addres);
    	$('#loading').removeClass("loading");
	document.getElementById('book').innerHTML = data;	
    });
}
