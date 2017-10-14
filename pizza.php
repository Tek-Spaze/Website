<!DOCTYPE html>
<html ng-app="pizzaApp">
<head>
	<title><?php echo "Pizza";?></title>
</head>
<body ng-controller="PizzaListController">
	Search: <input ng-model="query1" /><br>
	Search: <input ng-model="query2" /><br>
	Search: <input ng-model="query3" /><br>

    <div ng-repeat="pizza in pizzas | filter:query1 | filter:query2 | filter:query3">
      	{{pizza.number}} {{pizza.name}} <br>
      	<span ng-repeat="top in pizza.topping">{{top}}, </span><br>
      	<span ng-repeat="s in pizza.size">{{s.name + " " + s.price}}, </span>
    </div>



	<!--<script type="text/javascript" src="/file/js/jq"></script>-->
	<script type="text/javascript" src="code/js/angular.js"></script>
	<script type="text/javascript">
	// Define the `pizzaApp` module
	var pizzaApp = angular.module('pizzaApp', []);

	// Define the `PhoneListController` controller on the `pizzaApp` module
	pizzaApp.controller('PizzaListController', function PizzaListController($scope, $http) {
		$http.get("code/pizza.json").then(function(response) {
	        $scope.pizzas = response.data;
	    });		
	});

	</script>
	<style type="text/css">
		div{
			background: #eee;
			margin-bottom: 1em;
		}	

	</style>
</body>
</html>