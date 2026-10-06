# QRCard — کارت دیجیتال کسب‌وکار

سیستم فارسی و RTL برای ساخت پروفایل دیجیتال کسب‌وکار و QR Code اختصاصی.

## امکانات نسخه MVP
- ثبت‌نام و ورود
- ایجاد چند کسب‌وکار برای هر کاربر
- دسته‌بندی کسب‌وکار
- شماره موبایل و تلفن
- Telegram / Instagram / Rubika / Website
- آدرس و مختصات جغرافیایی
- صفحه عمومی موبایل‌فرندلی
- QR Code اختصاصی و دانلود PNG
- ثبت آمار اسکن QR
- Bootstrap RTL + Vazirmatn

## نصب در XAMPP / Windows
```cmd
cd C:\xampp\htdocs
unzip qr-business-card.zip
cd qr-business-card
composer install
copy .env.example .env
php artisan key:generate
```

در MySQL یک دیتابیس با نام `qr_business_card` بسازید، سپس `.env` را تنظیم کنید:

```env
DB_DATABASE=qr_business_card
DB_USERNAME=root
DB_PASSWORD=
```

سپس:

```cmd
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

آدرس: `http://127.0.0.1:8000`

> برای تولید QR، پکیج `endroid/qr-code` استفاده شده است. نمایش سریع QR در صفحه مدیریت نیز با QuickChart انجام می‌شود؛ برای محیط production بهتر است همان PNG سمت سرور را در صفحه مدیریت نمایش دهید.

## توسعه‌دهنده
علیرضا فقیریان
