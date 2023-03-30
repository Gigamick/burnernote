## Burnernote App

**[Burnernote](https://burnernote.com)** Send secure and encrypted notes that self destruct once they've been read. It is designed to be:

* **Ad Free and simple.** No clutter, no bloat, no complex dependencies. Burnernote is built with PHP so it’s quick and easy to deploy.

* **Open-source and Beautiful.** [Burnernote](https://github.com/Gigamick/burnernote) is open source and available on github.

* **Set password.** Set an optional password for the self-destructing messages.

* **Auto self destruct.** The note will expire after a set number of days, **default to 7 days**


### :zap: Installation

- Clone the repository.
```bash
git clone https://github.com/Gigamick/burnernote.git
```

- Change current working directory
```bash
cd burnernote
```

- Make sure `php is ^7.0`
```bash
php -v
```

- Install composer dependencies
```bash
composer update
```

- Copy .env file 
```bash
cp .env.example .env
```

- Edit database credentials in `.env file`

- Edit app url to 'https://burnernote.test' since assets are served through secure url

- Generate app key and migrate database
```bash
php artisan key:generate
php artisan migrate
```

- Serve site through valet
```bash
valet link
valet secure
```

- visit `https://burnernote.test` in the browser


## Security Vulnerabilities

If you discover a security vulnerability within Burnernote, create an issue.


## License

Burnernote is open-source software licensed under the [GNU License](https://github.com/Gigamick/burnernote/blob/main/LICENSE).
