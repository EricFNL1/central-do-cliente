import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY || process.env.VITE_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER || process.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});


// Exemplo: ouvindo o canal 'test-channel' para evento 'my-event'
window.Echo.channel('test-channel')
  .listen('.my-event', (e) => {
    console.log('Evento recebido:', e);
  });
