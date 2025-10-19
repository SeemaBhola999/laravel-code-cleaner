# Laravel Code Cleaner 🧹

[![Latest Version](https://img.shields.io/packagist/v/laravel/code-cleaner.svg)](https://packagist.org/packages/laravel/code-cleaner)
[![License](https://img.shields.io/packagist/l/laravel/code-cleaner.svg)](https://packagist.org/packages/laravel/code-cleaner)
[![PHP Version](https://img.shields.io/packagist/php-v/laravel/code-cleaner.svg)](https://packagist.org/packages/laravel/code-cleaner)

A Laravel package to easily remove debug statements like `dump()`, `dd()`, `console.log()` from your code before deployment.

**🚀 Compatible with Laravel 7.x to 12.x+ and PHP 7.4 to 8.3+**

## ✨ Features

- 🔍 Scans multiple file types (PHP, JS, TS, Vue, React)
- 🛡️ Production-safe with dry-run mode
- 💾 Backup option before cleaning
- ⚡ Fast and efficient regex patterns
- 🎯 Excludes vendor, node_modules, storage directories
- 📦 Zero configuration required

## 📦 Installation

```bash
composer require laravel/code-cleaner
```

The package will be auto-discovered by Laravel.

## 🎯 Usage

### Quick Start
```bash
# Preview what will be cleaned (recommended first step)
php artisan clean:debug --dry

# Clean app directory
php artisan clean:debug

# Clean entire project
php artisan clean:debug --path=.
```

### Advanced Usage
```bash
# Clean specific directory
php artisan clean:debug --path=app/Http/Controllers

# Clean with backup
php artisan clean:debug --backup

# Clean specific file
php artisan clean:debug --path=app/Models/User.php
```

## 🧹 What Gets Removed

### PHP Debug Statements
- `dump($variable);`
- `dd($data);`
- `var_dump($array);`
- `print_r($object);`
- `error_log('message');`

### JavaScript Debug Statements
- `console.log('debug');`
- `console.error('error');`
- `console.warn('warning');`
- `console.debug('debug');`
- `console.info('info');`
- `debugger;`

## 📁 Supported File Types

- **PHP**: `*.php`
- **JavaScript**: `*.js`
- **TypeScript**: `*.ts`
- **Vue**: `*.vue`
- **React**: `*.jsx`, `*.tsx`

## 🔧 Laravel Compatibility

| Laravel | PHP | Status |
|---------|-----|---------|
| 7.x | 7.4+ | ✅ |
| 8.x | 7.4+, 8.0+ | ✅ |
| 9.x | 8.0+ | ✅ |
| 10.x | 8.1+ | ✅ |
| 11.x | 8.2+ | ✅ |
| 12.x+ | 8.2+ | ✅ |

## ⚠️ Safety First

**Always run with `--dry` flag first!**

```bash
# See what would be changed
php artisan clean:debug --dry --path=.

# Create backups before cleaning
php artisan clean:debug --backup --path=.
```

## 🚀 Deployment Workflow

```bash
# 1. Preview changes
php artisan clean:debug --dry

# 2. Create backup and clean
php artisan clean:debug --backup

# 3. Test your application
php artisan test

# 4. Deploy with confidence! 🎉
```

## 📝 License

MIT License. See [LICENSE](LICENSE) for details.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📞 Support

If you find this package helpful, please ⭐ star it on GitHub!