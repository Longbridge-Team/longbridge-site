# longbridge-site

Official web page for Windows Longbridge.

## Login credentials

Use **admin** / **longbridge** to access the demo login page. A simple captcha protects the form.

User data is stored in a MariaDB database. Configure the connection using the `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASS` environment variables. A default `admin/longbridge` account is inserted if none exists.

## Data directory security

The `data` folder holds temporary files such as the rate limit cache and must not
be publicly accessible. An `.htaccess` file denying all requests is included so
contents from this folder cannot be served directly by the web server.

