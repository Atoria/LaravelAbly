To install dependencies run:

`composer install`
`npm install`

Run migrations:
`php artisan migrate`

To run application run:
`php artisan serve`
`npm run dev`

Setting up Ably:

Go to `https://ably.com/` and create an account. There you should generate new API KEY which should
be set in .env `ABLY_API_KEY`

To set up webhook and testing on local machine you should install `ngrok`


After installing run `ngrok http 8000`

On Ably dashboard navigate to `Webhook` and create new HTTP webhook. For event select `Message` 
on endpoint enter `{ngrokUrl}/api/webhooks/ably` and you are ready to chat.

Project consist by one page. For initial page you will see default Laravel page, where you can
register or login which will then redirects you to chat page. To test locally you can authorize
from incognito mode or different browsers.

Features:

1. When another persons starts typing you get indication that someone is writing. Currently it supports for one user since it's only mvp
2. Displaying messages from another user
3. Storing messages in external database in our case `Message` table


To understand better project check following files:

For Frontend:

`resources/js/components/ChatComponent.vue`

for Backend:

`app/Providers/AblyServiceProvider.php`
`app/Services/AblyService.php`
`app/Http/Controllers/ChatController.php`
`app/Http/Controllers/WebhookController.php`

