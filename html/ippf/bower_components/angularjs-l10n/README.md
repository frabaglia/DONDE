# L10n module for Angular.js
==============

Simple and fast module for localization your angular applications.

## Installation

bower install angularjs-l10n

## Usage
```javascript
angular.module('myApp', ['l10n']);
```

You can use either external json files with translations or just add translations from your main.js

For external JSON files you have to create directory with json files inside. Each file for each localization. For example en.json.

## Configure
```javascript
angular.module('myApp', ['l10n']).config(['l10nProvider', function(l10n) {
  l10n.setLocale('en'); // first of all you must set locale. You can take it from anywhere, for instance navigator.language
  
  l10n.pathToFile('translations/'); // if you set pathToFile, your JSON file with translations from that directory will be loaded
  
  // you can just add any translations like this
  l10n.add('en', {
    'Hello World!': 'Hello World',
  });
});
```

After configuration you can use l10n as a service:

Just add l10n as dependency in your controller or directive or whatever:

```javascript
angular.module('myApp', ['l10n']).controller('myController', ['$scope', 'l10n', function($scope, l10n) {
  console.log(l10n.trans('Hello World!'));
}]);
```

Or as a filter. In your templates write:

```html  
  <span>{{ 'Hello World!' | trans }}</span>
```

