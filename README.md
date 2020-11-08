# JML Shopping list
A simple shopping list to play with JS frameworks - React hooks version

## Development

### Setup

You can start the application from scratch with the following command:

```
make setup
```

### Setup

To authenticate yourself for development, you will need to add your user to the database:

```
docker-compose exec fpm bin/console jmlshopping:user:add yourself@gmail.com
```

You will then have to set your GOOGLE_CLIENT_ID and GOOGLE_SECRET env vars in a `.env.local` file
for Google authentication. 

https://developers.google.com/identity/protocols/oauth2#1.-obtain-oauth-2.0-credentials-from-the-dynamic_data.setvar.console_name-.

You might also want to remove the default user (myself :) ):

```
docker-compose exec fpm bin/console jmlshopping:user:del jmleroux.pro@gmail.com
```

### Tests:

```
make tests
```

With coverage available in `var/coverage`:

```
make coverage
```
