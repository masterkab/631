function addToCart(isbn,element){
	// This calls the addtocart.php function to add the selected item to the cart.
	var xhtml=new XMLHttpRequest();
	xhtml.open("POST","addtocart.php",true);
	xhtml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhtml.onreadystatechange = function() {
		// The AJAX call has been returned.  Check the return info.
		if(xhtml.readyState==4 && xhtml.status == 200) {
			var myResponse=(xhtml.responseText).split(':');
			if(myResponse[0]=='true') {
				// TODO: this code doesn't work.  Fix it.
				myelement=Document.getElementById(element);
				myelement.disabled=true;
			} 
			// Display the result.  This is a kludge.  Fix.
			alert(myResponse[1]);
			myCartN=document.getElementById("cart");
			// Update the current count of items in the shopping basket
			myCartN.value=myResponse[2];
		}
	}
	xhtml.send("add="+isbn);
}

