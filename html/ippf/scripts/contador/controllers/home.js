'use strict';

/**
 * @ngdoc function
 * @name houstonDiversityMap:controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the houstonDiversityMap
 */
angular.module('dondeDataVizApp').controller('HomeCtrl', function (moment, $interval, $scope,$timeout,$document,$http) {

		$scope.active = {
			name: 'Mendoza',
			active: 100,
			pending: 1000,
			percentage: 5
		};

   	   $scope.stats = {
   	   	active:100,
   	   	total: 10000
   	   }

	   var displayTime = function(){

   			$scope.diffDays = moment.utc([2017, 6, 18, 0, 0, 0, 0]);
   			//Solo hoy
   			var m = moment().utcOffset(-60*1);
   			$scope.diffHours = moment.utc([2017, m.month(),m.date()+1, m.hour(), 59, 59, 0]);	
   			$scope.diffMinutes = moment.utc([2017, m.month(), m.date(), m.hour()+1, 59, 59, 0]);	
   			$scope.diffSeconds=  moment.utc([2017, m.month(), m.date(), m.hour()+1,  m.minute(), 59, 0]);	
   		};


   		$interval(displayTime,1 * 1000);

   		var getStats = function(){
   			$scope.stats.active += 5;
   			$scope.stats.percentage += 5;
   			$scope.active.percentage +=5;
   			$scope.active.active +=5;
   			
   		};
   		$interval(getStats,5 * 1000);
	

});
