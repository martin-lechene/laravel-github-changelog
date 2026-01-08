# Laravel GitHub Changelog

[![Latest Version on Packagist](https://img.shields.io/packagist/v/orlyapps/laravel-github-changelog.svg?style=flat-square)](https://packagist.org/packages/orlyapps/laravel-github-changelog)
[![Total Downloads](https://img.shields.io/packagist/dt/orlyapps/laravel-github-changelog.svg?style=flat-square)](https://packagist.org/packages/orlyapps/laravel-github-changelog)

A Laravel package that automatically generates beautiful, formatted changelogs based on your GitHub commits and releases. Display a professional changelog page in your Laravel application with minimal setup.

## ✨ Features

- 📝 **Automatic Changelog Generation** - Automatically fetches and parses GitHub commits
- 🎯 **Conventional Commits Support** - Follows conventional commit syntax (fix, feat, chore, etc.)
- 🏷️ **Release Notes** - Displays GitHub releases with formatted markdown
- 🎨 **Beautiful UI** - Includes a pre-built, responsive Tailwind CSS interface
- 📅 **Date Grouping** - Organizes commits by date and type for better readability
- 🔧 **Highly Customizable** - Customize views, commit types, and display options
- 🚀 **Easy Integration** - Works out of the box with minimal configuration
- 📚 **History Support** - Optional HISTORY.md file support for legacy changelogs

## 📋 Requirements

- PHP ^8.2, ^8.3, or ^8.4
- Laravel ^9.0 || ^10.0 || ^11.0
- A GitHub repository with commits following conventional commit syntax
- GitHub Personal Access Token


## 🚀 Installation

### Step 1: Install via Composer

```bash
composer require orlyapps/laravel-github-changelog
```

### Step 2: Publish Configuration

```bash
php artisan vendor:publish --provider="Orlyapps\LaravelGithubChangelog\LaravelGithubChangelogServiceProvider" --tag="config"
```

This will create a `config/github-changelog.php` file in your Laravel application.

### Step 3: Configure Your GitHub Settings

Edit the `config/github-changelog.php` file:

```php
return [
    'github' => [
        'user' => 'your-github-username',        // Your GitHub username
        'repo' => 'your-repository-name',        // Repository name
        'token' => 'your-github-token',          // GitHub Personal Access Token
        'since' => '2020-10-13'                  // Only fetch commits from this date
    ],
    'types' => [
        'fix' => 'Fix 🐛',
        'improvement' => 'Improvement ⚡',
        'feat' => 'New 🌟',
        'chore' => 'Chore 🛠',
        'security' => 'Security 🔒',
        'performance' => 'Performance 📈'
    ]
];
```

### Step 4: Get a GitHub Personal Access Token

1. Go to [GitHub Settings > Tokens](https://github.com/settings/tokens)
2. Click "Generate new token (classic)"
3. Give it a descriptive name (e.g., "Laravel Changelog")
4. Select scopes: `repo` (or `public_repo` for public repositories only)
5. Click "Generate token"
6. Copy the token and add it to your config or `.env` file

**Security Tip:** Store your token in your `.env` file:

```env
GITHUB_CHANGELOG_TOKEN=your_github_token_here
```

Then reference it in your config:

```php
'token' => env('GITHUB_CHANGELOG_TOKEN'),
```

## 📖 Usage

### Basic Usage

Once installed and configured, your changelog is automatically available at:

```
https://yourproject.com/changelog
```

The package registers a `/changelog` route that displays your formatted changelog.

### Using the Facade

You can also use the `LaravelGithubChangelog` facade in your own controllers or views:

```php
use LaravelGithubChangelog;

// Get formatted changelog data
$changelog = LaravelGithubChangelog::changelog();

// Get GitHub releases
$releases = LaravelGithubChangelog::releases();
```

### Example Controller Usage

```php
namespace App\Http\Controllers;

use LaravelGithubChangelog;

class CustomChangelogController extends Controller
{
    public function index()
    {
        $changelog = LaravelGithubChangelog::changelog();
        $releases = LaravelGithubChangelog::releases();
        
        return view('custom.changelog', compact('changelog', 'releases'));
    }
}
```

## 🎨 Customization

### Publishing Views

To customize the changelog appearance, publish the views:

```bash
php artisan vendor:publish --provider="Orlyapps\LaravelGithubChangelog\LaravelGithubChangelogServiceProvider" --tag="views"
```

This creates `resources/views/vendor/github-changelog/index.blade.php` that you can customize.

### Customizing Commit Types

Edit the `types` array in `config/github-changelog.php` to customize how commit types are displayed:

```php
'types' => [
    'fix' => 'Bug Fixes 🐛',
    'feat' => 'New Features ✨',
    'improvement' => 'Improvements 🚀',
    'chore' => 'Maintenance 🔧',
    'security' => 'Security Updates 🔒',
    'performance' => 'Performance 📊',
    'docs' => 'Documentation 📚',
    'style' => 'Style Changes 💅',
    'refactor' => 'Refactoring ♻️',
    'test' => 'Tests ✅',
]
```

### Adding Historical Changelog

Create a `HISTORY.md` file in your project root for legacy changelog entries:

```markdown
# Historical Changes

## v1.0.0 - 2020-01-01
- Initial release
- Basic features implemented
```

This content will be displayed below your automated changelog.

## 📝 Commit Syntax

This package uses the **Conventional Commits** specification. Your commits should follow this format:

```
type(scope): subject

Examples:
feat(auth): add two-factor authentication
fix(database): resolve connection timeout issue
improvement(ui): enhance dashboard performance
chore(deps): update Laravel to 10.x
security(api): patch XSS vulnerability
performance(queries): optimize database queries
```

### Supported Commit Types

- `feat` - New features
- `fix` - Bug fixes
- `improvement` - Improvements to existing features
- `chore` - Maintenance tasks
- `security` - Security fixes
- `performance` - Performance improvements

### Breaking Changes

Mark breaking changes with an exclamation mark:

```
feat(api)!: change authentication endpoint structure
```

## 🔧 Advanced Configuration

### Custom Routes

If you want to use a different route, disable the auto-registration in your `AppServiceProvider`:

```php
// In AppServiceProvider::boot()
Route::get('/my-custom-changelog', \Orlyapps\LaravelGithubChangelog\Http\Controllers\ChangelogController::class)
    ->name('my.changelog');
```

### Date Format Customization

The changelog groups commits by date using `d.m.Y` format by default. To customize, extend the `LaravelGithubChangelog` class:

```php
namespace App\Services;

use Orlyapps\LaravelGithubChangelog\LaravelGithubChangelog as BaseChangelog;

class CustomChangelog extends BaseChangelog
{
    public function changelog()
    {
        return parent::changelog()->map(function ($day) {
            // Custom formatting logic
            return $day;
        });
    }
}
```

### Pagination

For repositories with many commits, consider implementing pagination:

```php
// In your controller
$perPage = 50;
$changelog = LaravelGithubChangelog::changelog()->take($perPage);
```

## 🧪 Testing

Run the package tests:

```bash
composer test
```

Run tests with coverage:

```bash
composer test-coverage
```

## 🐛 Troubleshooting

### No Commits Showing

- Verify your GitHub token has the correct permissions
- Check that your commits follow the conventional commit format
- Ensure the `since` date is before your commits
- Verify the `user` and `repo` settings are correct

### API Rate Limiting

GitHub API has rate limits. For authenticated requests (using a token), you get 5,000 requests per hour. If you hit the limit:

- Consider caching the changelog data
- Reduce the number of commits fetched with `per_page` parameter

### 401 Unauthorized Error

- Your GitHub token may be invalid or expired
- Generate a new token and update your configuration

### Commits Not Parsed

- Ensure commits follow the exact format: `type(scope): subject`
- Check that the commit type is listed in your `types` configuration
- The scope is optional but should be in parentheses if used

## 📚 API Reference

### `LaravelGithubChangelog::changelog()`

Returns a collection of commits grouped by date and type.

**Returns:** `Collection`

```php
[
    '15.01.2024' => [
        'Fix 🐛' => [
            [
                'author' => 'John Doe',
                'date' => DateTime,
                'subject' => 'resolve login issue',
                'type' => 'Fix 🐛',
                'scope' => 'auth'
            ]
        ],
        'New 🌟' => [...]
    ]
]
```

### `LaravelGithubChangelog::releases()`

Returns a collection of GitHub releases.

**Returns:** `Collection`

```php
[
    [
        'name' => 'v1.0.0',
        'created_at' => '2 days ago',
        'body' => '<p>Release notes in HTML</p>'
    ]
]
```

## 🤝 Contributing

Contributions are welcome! Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Development Setup

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure
4. Run tests with `composer test`

### Pull Request Guidelines

- Follow PSR-12 coding standards
- Add tests for new features
- Update documentation as needed
- Ensure all tests pass

## 🔒 Security

If you discover any security-related issues, please email **info@orlyapps.de** instead of using the issue tracker.

## 📝 Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## 👥 Credits

- [Florian Strauß](https://github.com/orlyapps) - Creator & Maintainer
- [All Contributors](../../contributors) - Thank you! 🙏

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## 🙏 Acknowledgments

- This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com)
- Icons from emoji
- UI components inspired by Tailwind UI

## 💡 Tips & Best Practices

1. **Use Conventional Commits** - Train your team to use the conventional commit format
2. **Cache Changelog Data** - For production, consider caching the changelog to reduce API calls
3. **Meaningful Scopes** - Use clear scopes like `auth`, `api`, `ui`, `database` for better organization
4. **Regular Updates** - Keep your changelog up to date by running the route regularly
5. **Combine with CI/CD** - Integrate changelog generation into your deployment pipeline

## 🔗 Related Packages

- [conventional-changelog](https://github.com/conventional-changelog/conventional-changelog)
- [semantic-release](https://github.com/semantic-release/semantic-release)
- [Laravel News](https://laravel-news.com)

---

Made with ❤️ by [Orlyapps](https://github.com/orlyapps)
