'use strict';

/**
 * @ngdoc function
 * @name houstonDiversityMap:controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the houstonDiversityMap
 */
angular.module('dondeDataVizApp').controller('mapCtrl', function ($routeParams,$scope,$timeout,$document,$http) {



	var information = [];

	information['FBC'] = {
		id: 'FBC',
		name: 'Fort Bend County'
	};

	information['HC'] = {
		id: 'HC',
		name: 'Harris County'
	};
	

	$scope.currentCounty = information[$routeParams.id.toUpperCase()];

	var sources = [];
	sources.push({
		link:"https://github.com/b-w-a/tx_precinct",
		name: "Pedraza & Wilcox-Archuleta MC"
	});
	
	sources.push({
		link:"https://www.washingtonpost.com/news/monkey-cage/wp/2016/12/02/donald-trump-did-not-win-34-of-latino-vote-in-texas-he-won-much-less/?utm_term=.42c2e48a0cca",
		name: "The Washington Post - Donald Trump did not win 34% of Latino vote in Texas. He won much less."
	});
	sources.push({
		link:"http://www.tlc.state.tx.us/redist/data/data.html",
		name: "Data for 2011 Redistricting in Texas"
	});

	$scope.sources = sources;
	$scope.activateDiversity = false;
    
    $scope.$watch('activateDiversity', function(activateDiversity) {
    	 if (activateDiversity){
  				$('.map svg').addClass('diversity');
  			}
  		else {
  			
  			$('.map svg').removeClass('diversity');
  		}
	});  
	
	$scope.diversitychart = {};

	$scope.mapReady = false;
	$scope.$on('mapReady', function () { 
		$scope.mapReady = true;
	});
	$scope.$on('diversityChartReady', function (n,data) { 
		$scope.diversitychart = data;
	});
	$scope.$on('votesChartReady', function (n,data) { 
		$scope.voteschart = data;
	});
	
	$scope.$on('updateCurrentItem', function (n,data) { 
		$scope.currentitem =  data;
		$scope.voteschart.load({
        columns: [
                        ['clinton', data.PCT_CLINTO *100],
                        ['trump', data.PCT_TRUMP *100]
                    ],
	    });
	    $scope.diversitychart.load({
    		    columns: [['diversity', data.DIV_INDEX * 100]]
	    });
	});
  

});
