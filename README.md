# ShopKori — Laravel Ecommerce Platform

A complete Laravel-based e-commerce landing page and admin panel system, specially designed for the Bangladeshi market — featuring Cash on Delivery, mobile banking payments, and Bengali UI support.

## ✨ Features

### Public / Customer-Facing

* 🛍️ Modern, mobile-responsive landing page built with Bootstrap 5 and a custom design system
* 🛒 Session-based shopping cart with Add to Cart, quantity update, and multi-item checkout support
* ⚡ Quick Order flow for placing a single-product order directly without using the cart
* 📦 Delivery area selection with separate charges for Dhaka and outside Dhaka
* 💳 Multiple payment methods including Cash on Delivery, bKash, Nagad, Rocket, etc., configurable from the admin panel
* ❓ Searchable FAQ page with accordion-based UI
* 📧 Newsletter subscription with secure unsubscribe tokens
* ⭐ Customer review submission with moderation queue
* 🎯 Support for temporary promotional and campaign landing pages

### Admin Panel

* 🔐 Custom and secure admin authentication with a separate guard, brute-force protection, and session fixation prevention
* 📊 Dashboard with revenue, order, and payment status overview
* 🗂️ Category and product management with image upload support
* 📋 Order management with order status, payment status tracking, and multi-product checkout grouping
* ❓ FAQ management
* 📬 Subscriber management with CSV export
* 📨 Newsletter campaign composer with queued email delivery
* ⭐ Customer review moderation with approve/reject functionality
* ⚙️ Website settings management including logo, address, phone, email, and social media links
* 💳 Payment method management including mobile banking account information and payment instructions

## 🛠️ Tech Stack

| Layer          | Technology                                         |
| -------------- | -------------------------------------------------- |
| Backend        | Laravel 12 (PHP 8.2+)                              |
| Frontend       | Blade + Bootstrap 5 + Vanilla JavaScript           |
| Database       | MySQL                                              |
| Fonts          | Fraunces, Inter, Space Mono (Google Fonts)         |
| Icons          | Bootstrap Icons                                    |
| Hosting Target | Shared cPanel hosting (no Redis/daemon dependency) |

## 📋 Requirements

* PHP >= 8.2
* Composer
* MySQL >= 5.7
* cPanel or any standard shared/VPS hosting environment

## 🚀 Installation

```bash
# 1. Clone the repository
git clone <repository-url>
cd shopkori

# 2. Install dependencies
composer install

# 3. Create the .env file
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shopkori
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# 5. Run migrations
# Migration order is important — see the "Migration Order" section below
php artisan migrate

# 6. Create the storage link
# Required for displaying uploaded images
php artisan storage:link

# 7. Create the first admin account
# CLI-only — there is no public admin registration
php artisan admin:create

# 8. Create the jobs table
# Required for the newsletter queue
php artisan queue:table
php artisan migrate

# 9. Start the development server
php artisan serve
```

## 🗄️ Migration Order

The migrations should follow this order according to their foreign-key dependencies. This will be automatically ensured by migration timestamps if they are created in the correct sequence.

1. `admins`
2. `categories` → `products`
3. `orders` (+ subsequent migrations for `delivery_area`, `delivery_charge`, `order_group_id`, and `transaction_id` columns)
4. `faqs`
5. `subscribers`
6. `newsletter_campaigns`
7. `reviews`
8. `settings`
9. `payment_methods`
10. `jobs` (generated using `queue:table`)

## 🔐 Admin Panel Access

* **Login URL:** `/admin/login`
* **Admin account creation:** Only through `php artisan admin:create`
* **Public admin registration:** Disabled intentionally for security
* **Brute-force protection:** After 5 failed password attempts, the account is locked for 60 seconds using rate limiting

## 📁 Important Folder Structure

```text
app/
├── Console/Commands/
│   └── CreateAdminCommand.php       # php artisan admin:create
├── Http/Controllers/
│   ├── LandingController.php        # Homepage
│   ├── CartController.php           # Session-based cart
│   ├── OrderController.php          # Single-product quick order
│   ├── FaqController.php
│   ├── NewsletterController.php
│   ├── ReviewController.php
│   ├── PromoController.php          # Temporary campaign pages
│   └── Admin/                       # All admin panel controllers
├── Models/
├── Mail/
│   └── NewsletterMail.php
├── Jobs/
│   └── SendNewsletterEmail.php
└── Http/Middleware/
    ├── AdminAuthenticate.php        # admin.auth
    └── AdminGuest.php               # admin.guest

resources/views/
├── landing.blade.php
├── faq.blade.php
├── reviews/create.blade.php
├── promo/                           # Campaign pages
├── emails/newsletter.blade.php
└── admin/
    ├── layout.blade.php
    ├── dashboard.blade.php
    ├── auth/login.blade.php
    └── ...                          # Categories, products, orders, FAQs, etc.

public/
├── css/landing.page.css
└── js/landing.page.js
```

## ⚙️ Additional `.env` Configuration

```env
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="ShopKori"
```

## ⏰ cPanel Cron Job

Since persistent queue workers are generally not available on shared hosting, configure a cron job to process the newsletter queue every minute.

```bash
* * * * * cd /home/yourcpaneluser/public_html && php artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

For detailed instructions, see:

```text
CPANEL-NEWSLETTER-SETUP.txt
```

## 🧭 Main Routes Overview

| Route                             | Method   | Description                                                                                      |
| --------------------------------- | -------- | ------------------------------------------------------------------------------------------------ |
| `/`                               | GET      | Landing page                                                                                     |
| `/faq`                            | GET      | FAQ page                                                                                         |
| `/order`                          | POST     | Submit a single quick order                                                                      |
| `/cart/*`                         | GET/POST | Add, update, remove, and checkout cart items                                                     |
| `/newsletter/subscribe`           | POST     | Subscribe to the newsletter                                                                      |
| `/newsletter/unsubscribe/{token}` | GET      | Unsubscribe from the newsletter                                                                  |
| `/reviews`                        | GET/POST | View and submit customer reviews                                                                 |
| `/admin/login`                    | GET/POST | Admin login                                                                                      |
| `/admin`                          | GET      | Admin dashboard                                                                                  |
| `/admin/{resource}`               | RESTful  | Categories, products, orders, FAQs, subscribers, newsletters, reviews, settings, payment methods |

## 🔒 Security

The application includes several security measures:

* Separate authentication guard for admin and customer sides
* CSRF protection enabled for all forms
* Server-side price and delivery charge calculation
* Client-side values are never trusted for critical calculations
* Admin registration is disabled
* CLI-only admin account creation
* Rate limiting and brute-force protection for admin login
* Session fixation protection
* Separate admin authentication and guest middleware

### Production Checklist

Before deploying to production, make sure to:

```env
APP_ENV=production
APP_DEBUG=false
```

Force HTTPS in `AppServiceProvider::boot()`:

```php
URL::forceScheme('https');
```

Also verify that all `/admin/*` routes are protected by the `admin.auth` middleware.

## 📄 License

This project is private/custom software and does not include an open-source license unless one is explicitly added by the project owner.
