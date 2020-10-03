# Events Service Skeleton

This is a skeleton service that can record domain events to an event store database. It is
intended to be used with the [data service](https://github.com/somnambulist-tech/data-service-skeleton) project.
This project is pre-configured to start an app container and an event queue listener. Both
will send logs to the data-service syslog service.

## Usage / Installation

Create a new repository using this as a base and then update / modify / do what you need
to for your use case. The GitHub repository is labelled as a "template" making this a one
click action from GitHub.

Once cloned, you should update the site URL that is defined in:

 * docker-compose.yml
 * .env

Optionally: re-namespace the `App` namespace to one that reflects your needs.

Add a database to data-services:

```yaml
services:
  db-events:
    build:
      context: .
      dockerfile: config/docker/postgres/Dockerfile
    environment:
      POSTGRES_DB: events
      POSTGRES_USER: mycompany
      POSTGRES_PASSWORD: secret
    volumes:
      - events_db:/var/lib/postgresql/data
    ports:
      - "54322:5432"
    networks:
      - backend

volumes:
  events_db:
    name: mycompany_volumes_events-db
```

For the external port, select the next available port number; or use 54321 if there are no
other database servers defined.

Finally: start the service `docker-compose up` and check it builds and the services connect
successfully.

## Exposed Services

The following URI will be bound to the main Traefik instance provided via data-service:

 * http://events.example.dev/
 * event container running a queue listener

## Sync'ing Changes to Containers

The main app container is pre-configured with mutagen.io tasks via a syncit config file. See
documentation on [syncit](https://github.com/somnambulist-tech/sync-it). There are no configured
tasks for the queue listener as this does not support hot-reloading of classes.

## Debugging Information

The following are only available when running in debug mode:

 * X-Debug-Token - Symfony Profiler debug token for the request
 * X-Debug-Token-Link - a link to access the profiler data 

## Troubleshooting

Docker can be difficult to troubleshoot. The first step is to check `docker-compose ps`. If the
containers have stopped try re-starting them. Next try `docker-compose logs <container_name>` to see
if there was any output.

For the application, there may be information in: `var/logs/<env>.log`. Tail this file for errors,
for example: `tail -f var/logs/dev.log`. Note: that this should be done in the container process;
provided that the app / job container is running.

Sometimes the build process does not work correctly. In this instance, the containers may need
building again:

 * `docker-compose down`
 * `docker system prune` - this step removes any redundant containers / networks, it can be skipped
 * `docker-compose up -d --build --force-recreate`

__Note:__ `--force-recreate` does not always forcibly recreate the containers. It may be necessary
to use: `docker-compose build --no-cache --pull` instead. `--pull` will ensure the source image is
updated before building.

## Tests

The basic hooks for tests are bundled in this skeleton including various helper functions / traits.
A wrapper script is included in `bin/` to run tests in the current docker container. Note that this
requires the app container to be running.

Tests may be run locally outside of Docker, however you will need to define a `.env.test.local` and
add URLs for the database, redis, syslog and rabbitmq.
