
# LenderHomePage Code Challenge

This is an application for the LenderHomePage take home code challenge/assignment.

I attempted to demonstrate various different skillsets for this challenge, but there are many things I would have done if this was not code challenge. My overall goal was to show my familiarity with Laravel and Vue.js.

## Setup

 1. Install [Docker](https://www.docker.com/)
 2. Install [PHP](https://formulae.brew.sh/formula/php)
 3. Install [Composer](https://getcomposer.org/)
 4. Clone this repo
 5. Run `composer install && ./vendor/bin/sail install`
 6. Copy the `.env.example` to a new file called `.env`
 7. Run `./vendor/bin/sail up -d && ./vendor/bin/sail artisan key:generate && ./vendor/bin/sail artisan migrate && ./vendor/bin/sail artisan db:seed`
 8. Install [Node](https://nodejs.org/en/)
 9. Run `npm i -g yarn && yarn && yarn dev`
 10. Go to http:://localhost on your browser 
 11. Login with username as **test@test.com** and **password** as the password

What would I have expanded upon or added to:

 - Additional tests
	 - I believe in TDD, but I wanted to show you my overall skills in a timely manor.
	 - Jest testing
 - Use only actions in the TaskController
 - On adding or editing a task, emit an event which would reload all the tasks; right now, you have to reload the page for updates.
 - Add ability to see parent - child task hierarchy. I did not have time for this with the way I decided to use swim lanes.
 - Cleanup the codebase to remove boilerplate code from Inertia
 - Run a prettier to standardize JS formatting
