# JML Shopping list
A simple shopping list to play with JS frameworks - React branch

## Development

##### Setup

You can start the application from scratch with the following command:

```
make setup
```

You will then have to set your GOOGLE_CLIENT_ID and GOOGLE_SECRET env vars in a `.env.local` file
for Google authentication. 

https://developers.google.com/identity/protocols/oauth2#1.-obtain-oauth-2.0-credentials-from-the-dynamic_data.setvar.console_name-.


##### Launch tests:

```
make tests
```

With coverage available in `var/coverage`:

```
make coverage
```
