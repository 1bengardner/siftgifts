# Siftgifts

Siftgifts is a platform to share wishlists and reserve gifts, where only the wishlist owner needs to register an account.

<img src="https://github.com/1bengardner/siftgifts/assets/6226898/9abb6fd2-6529-472d-8cc9-02827e90f147" alt="Wishlist" width="270" />
<img src="https://github.com/1bengardner/siftgifts/assets/6226898/5208f40b-0c21-4018-a4b0-3fb9c5f22c0c" alt="Profile" width="270" />
<img src="https://github.com/1bengardner/siftgifts/assets/6226898/0b5361ef-4c9c-4576-ad87-f6f627b2a08c" alt="Logout" width="270" />

## Getting started

To get Siftgifts up and running, you will need to serve the [source](/project/source) on a PHP server running MySQL.

This usually means uploading the contents of /source to your web hosting's public directory through FTP with a client like [FileZilla](https://filezilla-project.org/).

You can run Siftgifts locally with [XAMPP](https://www.apachefriends.org/download.html). You will need to install and run XAMPP and point Apache to the Siftgifts source directory.

### Database setup and config

You will need to populate the database with the correct structure. Import the .sql file found in [/project/sql](/project/sql).

You will also need the following:

- Two e-mail addresses: one for account verification and one for password reset. They are configured in [email_config.php](/project/source/util/email_config.php).
- A MySQL database and a database user account with proper privileges for creating the database/tables/procedures. The database connection is configured in [db_config.php](/project/source/util/db_config.php).
  - It is recommended to create a separate account for operations performed within the site, also configured in db_config.php.
