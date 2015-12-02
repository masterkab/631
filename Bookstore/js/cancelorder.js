function cancelOrder(orderNo){
	// This calls the cancel_order.php function to cancel an order.
	var xhtml=new XMLHttpRequest();
	xhtml.open("POST","cancel_order.php",true);
	xhtml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhtml.onreadystatechange = function() {
		// The AJAX call has been returned.  Check the return info.
		if(xhtml.readyState==4 && xhtml.status == 200) {
			var myResponse=(xhtml.responseText).split(':');
			if(myResponse[0]=='true') {
			} 
			// Display the result.  
			alert(myResponse[1]);
			location.reload(true);
		}
	}
	xhtml.send("orderno="+orderNo);
}

