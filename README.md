# CSRF Token Manager 

[![Build Status](https://travis-ci.org/svil4ok/csrf-manager.svg?branch=master)](https://travis-ci.org/svil4ok/csrf-manager)

The Security CSRF (Cross-Site Request Forgery) component provides a class `Token` 
for generating and validating CSRF tokens.

## Usage

````php
<?php

$token = new \svil4ok\Csrf\Token(
    new \svil4ok\Csrf\TokenStorage,
    new \svil4ok\Csrf\TokenGenerator
);

// Generate new token
$generatedToken = $token->get();

// Validate token
var_dump($token->isValid($generatedToken)); // true
var_dump($token->isValid('invalid')); // false
````
