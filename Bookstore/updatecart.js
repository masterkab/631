function updateCart(isbn,id){
	// This calls the addtocart.php function to add the selected item to the cart.
	var quantity=document.getElementById(id).value;
	var xhtml=new XMLHttpRequest();
	if(!(isNaN(quantity))&&quantity>=0) {
		xhtml.open("POST","updatecart.php",true);
		xhtml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhtml.onreadystatechange = function() {
			// The AJAX call has been returned.  Check the return info.
			if(xhtml.readyState==4 && xhtml.status == 200) {
				var myResponse=(xhtml.responseText).split(':');
				if(myResponse[0]=='true') {
					element.disabled=true;
				} 
				// Display the result.  This is a kludge.  Fix.
				alert(myResponse[1]);
			}
		}
		xhtml.send("isbn="+isbn+"&quantity="+quantity);
	}
}

