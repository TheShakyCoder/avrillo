# Avrillo Conveyancing Technical Test

## TL;DR
There wasn't enough information provided to safely assume exactly what was 
required due to the random nature of the `kanye.rest` API.

Therefore, what I have done is my interpretation of the specification.

## Assumptions

The biggest assumption was working out how to create order from chaos. 
As the kanye site only provided 1 random result, 
it can never be known if we have all the quotes (assuming we can't see their source code). 
So trying to provide a paginated result will never be perfect.

## Installation

Download and expand the zip file or `git clone git@github.com:TheShakyCoder/avrillo.git`

`cd avrillo`

`composer install` or `sail composer install` in Docker

`npm install`

`npm run build`

I created this within a Docker environment so I would do something like

`sail up -d --build`

and pointed `avrillo.test` to `127.0.0.1` in my `/etc/hosts` file but you could use `localhost`. Just be sure to amend the .wnv file accordingly.

`sail artisan migrate:fresh`

## Usage

* go to localhost (or whatever is being used)
* register a user. This will return a token that is stored in localStorage
* fetch quotes
* fetch more quotes (although the quotes are cached, a single called is made to `kanye.rest` on each request to try and populate the local cache with more unique quotes)
* logout (removes the token)
* login (generates a new token)

## Manager Pattern
I have very little experience of this so I decided to do Service/Provider instead

## Tests

`sail pest`

I am not convinced Unit Tests are that import on request/response frameworks such as the traditional web. IMO mocking is over-rated.

Feature tests use Pest and check for authentication
