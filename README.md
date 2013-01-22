# cALLOWED

by [Gregory Wilson](http://drakos7.net) and Jeffrey Wilson

cALLOWED is a 2-factor phone based authentication API based upon the [Tropo](http://tropo.com) web API

With the ease and availability of free and anonymous email accounts around
the world, it is becoming harder and harder to tell if that new registration
is a flesh and blood person.

cALLOWED steps into that process by having the person respond to a series
of challenge words, similar to an audio captcha. The benefit to you is
that in the process you also gain marketable information.

The primary purpose of cALLOWED is to increase that chance that the person who is signing up for an account on your
system is a real person.

## How it Works

1. Your potential user goes to your website and is shown N input boxes and a phone number to call.
2. The user calls the number and is given the N passphrases.
3. When the user enters the passphrases they are checked against cALLOWED via the API.
4. If they entered the words correctly you are given their phone information to verify against your own databases.

## Requirements

### Tropo
1. Get a [Tropo](https://www.tropo.com) account
2. Create a New Application
3. Set the "What URL powers voice calls to your app?" to be the url to the server.php file.
4. Register a phone number

### Server
- Edit setup.php and change the settings to however you want them.
- www/tmp, and ERROR_FILE should be writable by your server
- Make sure [Zend_Cache](http://framework.zend.com/downloads/latest#ZF1) in your path
- A customized [words](https://en.wikipedia.org/wiki/Words_(Unix)) from which the input will be derived.

Edit the setup.php file to specify the Tropo phone number you registered and the # of words you wish to have returned.

Navigate to YOURURL/example.php and try it out.

## See it in Action

[cALLOWED](http://dactyl.us/Callowed)