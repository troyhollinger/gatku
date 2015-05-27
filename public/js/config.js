var app = angular.module('gatku', ['angularFileUpload', 'ngCookies', 'ipCookie', 'ngAnimate', 'angular-stripe', 'ngTouch', 'credit-cards']);

app.config(function(stripeProvider) {

    stripeProvider.setPublishableKey('pk_live_5MrQVqT1OSrL1lyeYe54NWgs');
    
});