var app = angular.module('gatku', ['angularFileUpload', 'ngCookies', 'ipCookie', 'ngAnimate', 'angular-stripe', 'ngTouch', 'credit-cards']);

app.config(function(stripeProvider) {

    stripeProvider.setPublishableKey('pk_test_iTOIZYCF15Qmpq7CYOqltHCJ');
    
});