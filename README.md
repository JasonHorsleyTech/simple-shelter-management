# Simple shelter management

A dummy project, for the purposes of developing and demoing [Larry](https://github.com/JasonHorsleyTech/Larry), the laravel virtual assistant.

## Setup
You need GPT_ENABLED=true and a key (.env.example)

You need to get queues up and running

## Notes
Need to pull out logic from Converse.vue. Nova has JS in composer package, why not just "require vue" and keep it all together?

## Notes to user
While prompts can be run without an Auth::user(), it is highly recommended you only run variable prompts from behind middleware('auth') protected routes. This is because, if an end user says something that violates OpenAI's policy, you want that userID to be associated with the request so that you're *entire* account doesn't get the flag.
