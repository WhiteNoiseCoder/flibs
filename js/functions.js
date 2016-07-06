

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
	    if (getUrlParameter('s')){
		$('#search').val(getUrlParameter('s'));
		getBookList(getUrlParameter('s'));
	    }
}

	function getBookList(bookName){
		if ($('#search').val()){
		    changeUrl("?s=" + $('#search').val());
		}
		$body = $('#booklist');
		$.get("php/GetBooks.php?t=" + $('#search').val(), function(data, status){
	                $body.addClass("modal");
			books = JSON.parse(data);
			$("#booklist").html("");
			for(var i=0;i < books.length;i++){
			     var current_book_title = '<div class="pure-menu pure-menu-horizontal"><a class="pure-menu-heading pure-menu-link" href="/b/424017">' + books[i].Title + '</a></div>';
			     var author = '<li class="pure-menu-item"><a href="/a/' + books[i].AvtorId +'" class="pure-menu-link">' + books[i].FirstName + ' ' + books[i].LastName + '</a></li>';
			     var read =  '<li class="pure-menu-item"><a href="/b/' + books[i].BookId + '/read" class="pure-menu-link">читать</a></li>';
			     var epub =  '<li class="pure-menu-item"><a href="/b/' + books[i].BookId + '/epub" class="pure-menu-link">epub</a></li>';
			     var mobi =  '<li class="pure-menu-item"><a href="/b/' + books[i].BookId + '/mobi" class="pure-menu-link">mobi</a></li>';
			     var fb2 =  '<li class="pure-menu-item"><a href="/b/' + books[i].BookId + '/fb2" class="pure-menu-link">fb2</a></li>';
			     var current_book = '<ul class="pure-menu-list">' + author + fb2 + epub + mobi + '</ul>';

		             $(current_book_title).appendTo('#booklist').append(current_book);
			}
	                $body.removeClass("modal");
        	});
        }