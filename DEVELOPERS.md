# Developing Hello Elementor

Hello Elementor is a lightweight WordPress theme built to work with the Elementor site
builder. It combines PHP theme code with a React-based admin UI (the `admin-home` module)
built via `@wordpress/scripts`. Text domain: `hello-elementor`. Requires PHP 7.4+ and
WordPress 6.0+.

## Prerequisites

- Node.js 18+ (Playwright E2E uses Node 20)
- PHP 7.4+ and Composer
- Docker (for the local `wp-env` environment and PHPUnit)

## First-time setup

```bash
npm ci             # install JS dependencies
composer install   # install PHP dependencies
```

## Running the theme locally

The repo ships a ready-to-use WordPress environment via `@wordpress/env` (see
`.wp-env.json`), which auto-installs the latest Elementor alongside this theme.

```bash
npm run wp-env:start   # boot WordPress in Docker
npm run wp-env:stop    # shut it down
```

This gives you two sites:
- **Dev:** http://localhost:8888
- **Tests:** http://localhost:8889

Log in at `/wp-admin` with `admin` / `password`. Run WP-CLI against the container with
`npx wp-env run cli wp <command>`.

Notable flags set in `.wp-env.json`:
- `WP_DEBUG: true`, `WP_DEBUG_LOG: true`, `WP_DEBUG_DISPLAY: false` — errors go to the
  debug log, not the screen.
- `SCRIPT_DEBUG: false` — WordPress serves minified core assets.
- `ELEMENTOR_SHOW_HIDDEN_EXPERIMENTS: true` — needed to toggle experiments such as the
  Elementor-based dynamic header/footer.

## Build & watch

The `admin-home` React UI builds from `dev/js/` into `modules/admin-home/assets/js/`;
SCSS in `dev/scss/` compiles into `assets/`. Because `wp-env` maps the theme directory
live, PHP/template edits show on refresh with no rebuild — only JS/SCSS need a build.

- `npm start` — webpack watch mode for dev
- `npm run build:dev` — dev build with watch (runs composer update/install first)
- `npm run build:prod` — production build (runs `composer install --no-dev` then webpack)
- `npm run package:zip` — build a distributable theme zip

## Debugging

**PHP / templates.** Debug logging is already on. Tail the log live:

```bash
npx wp-env logs                                                    # container logs
npx wp-env run wordpress tail -f /var/www/html/wp-content/debug.log
```

Drop `error_log( print_r( $var, true ) );` in PHP and it lands in `debug.log`.

**Admin React UI.** Run `npm start` so edits rebuild, then use browser DevTools on the
wp-admin pages.

**Step-through (Xdebug).** `wp-env` ships Xdebug; start it in debug mode and connect your
editor on port 9003:

```bash
npm run wp-env:stop
npx wp-env start --xdebug=debug
```

In VS Code, add a "Listen for Xdebug" launch config with a `pathMappings` entry mapping
`/var/www/html/wp-content/themes/hello-theme` to this folder. (The repo's
`.vscode/settings.json` only configures PHPCS/PHPCBF, not a debugger.)

## Linting & formatting

Run before committing:

- `npm run lint` — runs all three: `lint:css`, `lint:js`, `lint:php`
- `npm run lint:js` / `npm run lint:js:fix`
- `npm run lint:css` / `npm run lint:css:fix`
- `npm run lint:php` / `npm run lint:php:fix` — PHPCS with WordPress standards (`phpcs.xml`)
- `npm run format` — Prettier via `wp-scripts format`

## Tests

- `composer run test` — PHPUnit directly (testsuite `hello-elementor`). Set up the test
  DB first with `composer run test:install` (wraps `bin/install-wp-tests-local.sh`).
- Single PHP test: `composer run test -- tests/phpunit/hello-elementor/test-<name>.php`
- `npm run test:playwright` — Playwright E2E (`tests/playwright/playwright.config.ts`)
- `npm run test:playwright:headless` / `:debug`
- E2E setup: `npm run wp-env:start`, then `npm run test:setup:playwright` and
  `npm run test:setup:chromium`

> Note: the `npm run test:php` script references `bin/docker-compose.yml`, which is not
> present in the repo. Use `composer run test` for local PHPUnit.

## Architecture

**Bootstrap.** `functions.php` defines constants (`HELLO_ELEMENTOR_VERSION`,
`HELLO_THEME_PATH`, `HELLO_THEME_URL`, `EHP_THEME_SLUG`), registers theme support and
default styles, loads the `includes/*-functions.php` helpers, then requires `theme.php`
and calls `HelloTheme\Theme::instance()`.

**Theme singleton** (`theme.php`, `HelloTheme\Theme`):
- Registers a custom PSR-4-style autoloader (no Composer autoload for theme code).
  CamelCase class → kebab-case path: `HelloTheme\Modules\AdminHome\Module` →
  `modules/admin-home/module.php`. Supports backward-compatible class aliases.
- Initializes modules from a hardcoded list in `init_modules()` (currently only
  `['AdminHome']`). Each module must extend `Module_Base` and pass `is_active()`.

**Modules** (`includes/module-base.php`, `HelloTheme\Includes\Module_Base`):
- Abstract base implementing the singleton + component-registry pattern.
- Convention: `HelloTheme\Modules\{Name}\Module`, components under `...\Components\{Name}`,
  widgets under `...\Widgets\{Name}`.
- `is_active()` is filterable via `hello-plus-theme/modules/{name}/is-active`.
- **To add a module:** create `modules/{name}/module.php` extending `Module_Base`,
  implement `get_name()` + `get_component_ids()`, add components under
  `modules/{name}/components/`, and add the module name to the list in
  `Theme::init_modules()`.

**The `admin-home` module** (`modules/admin-home/`) is the only current module. It powers
the WordPress admin experience (menu, top bar, conversion banner, notifications, finder,
REST + AJAX). React source lives in `dev/js/` and builds to
`modules/admin-home/assets/js/`. Components are accessed via
`Theme::instance()->get_module('AdminHome')->get_component('<Class>')`.

**REST API** (`modules/admin-home/rest/`): controllers extend
`HelloTheme\Modules\AdminHome\Rest\Rest_Base`, namespace `elementor-hello-elementor/v1`,
gated on `current_user_can('manage_options')`. Add an endpoint by extending `Rest_Base`
and implementing `register_routes()`.

**Templates.** `index.php` dispatches by query type, preferring Elementor theme-builder
locations (`elementor_theme_do_location()`) and falling back to `template-parts/*.php`.
`header.php` / `footer.php` load `template-parts/dynamic-{header,footer}.php` when the
Elementor header/footer experiment is active, otherwise the static
`template-parts/{header,footer}.php`.

**Settings** live in three layers: legacy WP options (`Settings_Controller`), the modern
Elementor Kit tabs (`includes/settings/settings-{header,footer}.php`, registered on
`elementor/kit/register_tabs`), and the legacy WP Customizer
(`includes/customizer-functions.php`). Read kit settings via `hello_elementor_get_setting()`
in `includes/elementor-functions.php`.

**Asset enqueueing** (`includes/script.php`, `HelloTheme\Includes\Script`) reads webpack's
generated `.asset.php` files for deps/version and handles script translations. Webpack
entry points and output (`./assets`) are defined in `webpack.config.js`.

## Conventions

- **Namespaces:** `HelloTheme\` for theme code; note Kit settings/customizer classes use
  the older `HelloElementor\Includes\` namespace.
- **Function/hook prefix:** `hello_elementor_`. Constants: `HELLO_ELEMENTOR_*` /
  `HELLO_THEME_*` / `EHP_*`.
- **Text domain:** `hello-elementor` for all i18n. Always escape output: `esc_html__()`,
  `esc_attr()`, `esc_url()`, `wp_kses_post()`.
- Every PHP file starts with `if ( ! defined( 'ABSPATH' ) ) { exit; }`.
- **Prettier:** tabs, single quotes, semicolons, printWidth 80 (`.prettierrc`).
- **Commit messages:** `Category: Description [ED-XXXXX] (#PR)` where Category is one of
  `New` / `Tweak` / `Fix` / `Internal`. A Jira ticket ref (`ED-XXXXX`) is expected.
- **GitHub workflows** (`.cursor/rules/github-workflows.mdc`): assume happy path, keep
  workflows 50–100 lines, extract logic to `.github/scripts/`, no emojis.

## Releases & versioning

The version appears in four places that must stay in sync: `style.css`, `readme.txt`
(`Stable tag` + `Version`), `functions.php` (`HELLO_ELEMENTOR_VERSION`), and
`package.json`. Use `npm run update-version` to sync them. `readme.txt` changelog format:
`= X.Y.Z - YYYY-MM-DD =` with `New` / `Tweak` / `Fix` / `Internal` bullet lines.
