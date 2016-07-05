
getBookList(bookName){
$.get("makebooklist?t=" + bookName,
                  document.getElementById('booklist').innerHTML = data;
                });

    return  jQuery.get("/makebooklist?t=" + bookName,
        function(r){
	    jQuery("#books").html(t1+r+t2); 
	} )
}