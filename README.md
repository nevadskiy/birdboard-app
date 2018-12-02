##### For using Laravel echo server, add the following sections 
```
// to layout.blade.php, before <script src="{{ asset('app.js') }}"></script>

<script>
  window.echoConfig = {
    host: {!! json_encode(env('ECHO_SERVER_HOST')) !!},
    port: {!! json_encode(env('ECHO_SERVER_PORT')) !!}
  };
</script>
```
```
// bootstrap.js

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

window.io = require('socket.io-client');

const host = window.echoConfig.port
  ? `${window.echoConfig.host}:${window.echoConfig.port}`
  : window.echoConfig.host;

window.Echo = new Echo({
  broadcaster: 'socket.io',
  namespace: 'App.Events.Broadcasts',
  host,
});
``` 

### TODO: 
- add aliases bash script
- restructure README.md
- add all laravel required php extensions
- add debuger extension
- figure it out with deployment
- make .sh command to run environment
- figure it out with user rights and artisan:make command
    try: docker-compose run --user "$(id -u):$(id -g)" php-cli
- separate testing environment
