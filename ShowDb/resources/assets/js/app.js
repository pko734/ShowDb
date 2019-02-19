
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

// app.js
 
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js')
}
require('./bootstrap');
