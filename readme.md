# Introduction

You are working on auction platform. The service provides to its user ability to submit and search auctions. Company has to implement some privacy policy, for example, some personal data like emails, Skype usernames or phone numbers must be anonymized. 

# Task definition

Your task is to implement 3 content anonymizers:

* for emails (anonymize whole username, leave domain)
* for Skype username (anonymize whole username, leave HTML around if given)
* for phone numbers (anonymize last X digits, leave the rest and code)

To complete this task you should:

* implement methods marked with `@todo` annotation in *Anonymizer class
* check if all anynomizers are valid in Anonymizer interface context

# Input structure

## Emails

Examples:

* a@a.com
* aa@aa.aa.com
* aa12@aa12.aa.com
* A-A@A-A.com
* A.A@A_A.com

Rules:

* characters: a-z, A-Z, 0-9, ., _, -
* first and last character of username/domain must be a-z, A-Z or 0-9 character

For simplicity, you don't have to implement RFC standards.

## Skype usernames

Examples:

* skype:username
* skype:USERNAME
* <a href="skype:USERNAME?call">call me</a>

Rules:

* characters: a-z, A-Z, 0-9

## Phone numbers

For simplicy, all phone numbers are formatted the same way, you may assume that. There are no different numbers in auction content, like credit card numbers.  

Examples:

* +48 666 666 666
* +234 777 888 999

Rules:

* code is always available
* number contains 9 digits in 3 groups, 3 digits each, separated by spaces

# Hints

Think about invalid inputs that can be passed to the application (and/or database) and protect them.
