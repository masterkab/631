function updateCart(isbn,itemno,eid){
	// This calls the addtocart.php function to add the selected item to the cart.
	var quantity=document.getElementById(eid).value;
	var xhtml=new XMLHttpRequest();
	if(!(isNaN(quantity))&&quantity>=0) {
		xhtml.open("POST","updatecart.php",true);
		xhtml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhtml.onreadystatechange = function() {
			// The AJAX call has been returned.  Check the return info.
			if(xhtml.readyState==4 && xhtml.status == 200) {
				var myResponse=(xhtml.responseText).split(':');
				if(myResponse[0]=='true') {
				} 
				// Display the result.  
				alert(myResponse[1]);
				// in case the attempt failed, we change the value
				document.getElementById(eid).value=myResponse[2];
			}
		}
		xhtml.send("isbn="+isbn+"&itemno="+itemno+"&quantity="+quantity);
	} else {
		alert('Fails to evaluate true');
	}
}

