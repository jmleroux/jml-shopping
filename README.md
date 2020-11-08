# JML Shopping list
A simple shopping list to play with JS frameworks - React hooks version

![Shopping Meme](https://memegenerator.net/img/instances/400x/65716889/happy-shopping.jpg)

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

You might also want to remove the default user (myself :smile:):

```
docker-compose exec fpm bin/console jmlshopping:user:del jmleroux.pro@gmail.com
```

### Tests:

![Testing is doubting](https://pbs.twimg.com/media/Cvmxg8PXEAA5bcL.jpg)

```
make tests
```

_Note: tests are based on the database content from setup. If you modified the database content, you must reset it with:_

```
make database
```

With coverage available in `var/coverage`:

```
make coverage
```
