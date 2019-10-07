importScripts("/service-worker/precache-manifest.66e8d4b99c82c65c7711ffa30ecc8cc8.js", "https://storage.googleapis.com/workbox-cdn/releases/3.6.3/workbox-sw.js");

//workbox.googleAnalytics.initialize();

workbox.routing.registerRoute(
  // Cache CSS files
  /\.(?:js|css)$/,
  // Use cache but update in the background ASAP
  workbox.strategies.staleWhileRevalidate({
    // Use a custom cache name
    cacheName: 'static-resources',
  })
);

workbox.routing.registerRoute(
  // Cache image files
  /.*\.(?:png|jpg|jpeg|svg|gif)/,
  // Use the cache if it's available
  workbox.strategies.cacheFirst({
    // Use a custom cache name
    cacheName: 'image-cache',
    plugins: [
      new workbox.expiration.Plugin({
        // Cache only 20 images
        maxEntries: 20,
        // Cache for a maximum of a week
        maxAgeSeconds: 7 * 24 * 60 * 60,
      })
    ],
  })
);

// pre-cache pages
workbox.precaching.precacheAndRoute([
  {
     url: 'offline', 
     revision: Date.now()
  }
])
 
/**
* save pages to cache on visit & serve when offline
* or if not cached then serve the "offline view"
*/
const customHandler = async (args) => {
    try {
        return await workbox.strategies.networkFirst({
            cacheName: 'pages',
            plugins: [
                new workbox.expiration.Plugin({
                    maxEntries: 20,
                    purgeOnQuotaError: true
                })
            ]
        }).handle(args) || caches.match('offline')
    } catch (error) {
        return caches.match('offline')
    }
}
 
const navigationRoute = new workbox.routing.NavigationRoute(customHandler, {
    // dont cache this urls
    blacklist: [
        new RegExp('/(login|register|password|auth)'),
        new RegExp('/admin')
    ]
})
 
workbox.routing.registerRoute(navigationRoute)

