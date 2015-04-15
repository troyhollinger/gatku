var app = angular.module('gatku', ['angularFileUpload', 'ngCookies', 'ipCookie', 'ngAnimate', 'angular-stripe']);

app.config(function(stripeProvider) {

    stripeProvider.setPublishableKey('pk_test_ridkQh4sxzTmvXFqSMtpzCcm');
    
});