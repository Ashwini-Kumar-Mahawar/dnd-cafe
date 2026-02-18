import './bootstrap';

// ✅ Currently using meta refresh (auto-reload every 10s)
console.log('✅ DND Cafe - Kitchen Dashboard Ready');
console.log('📋 Using auto-refresh for order updates');

// // Import Laravel Echo and Pusher
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// // Make Pusher available globally
// window.Pusher = Pusher;

// // Initialize Echo
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true,
//     encrypted: true,
//     enabledTransports: ['ws', 'wss'],
// });

// // Debug logging
// console.log('🔧 Echo Configuration:', {
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
// });

// // Test connection
// window.Echo.connector.pusher.connection.bind('connected', () => {
//     console.log('✅ Pusher connected successfully!');
// });

// window.Echo.connector.pusher.connection.bind('error', (err) => {
//     console.error('❌ Pusher connection error:', err);
// });