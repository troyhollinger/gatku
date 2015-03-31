app.filter('money', function () { 

	return function (amount) { 

		return (amount / 100); 
	}

});