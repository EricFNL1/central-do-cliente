import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY || process.env.VITE_PUSHER_APP_KEY, // depende da versão do Laravel
    cluster: process.env.MIX_PUSHER_APP_CLUSTER || process.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});
