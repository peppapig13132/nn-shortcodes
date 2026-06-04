# NN Shortcodes — Conventions

Plugin for [nn.partners](https://nn.partners). All front-end class names use the **`nn-`** prefix.

## Directory layout

```
nn-shortcodes/
├── nn-shortcodes.php          # Plugin bootstrap
├── includes/
│   ├── class-nn-shortcodes-plugin.php
│   ├── class-nn-shortcode-registry.php
│   ├── abstract-class-nn-shortcode.php
│   ├── class-nn-assets.php
│   └── helpers.php
├── shortcodes/                # One class per shortcode
│   └── class-nn-shortcode-{name}.php
├── templates/
│   └── shortcodes/            # Markup only (no business logic)
│       └── {name}.php
├── assets/
│   ├── css/
│   │   ├── nn-shortcodes.css       # Shared base + utilities
│   │   └── nn-shortcodes-{name}.css
│   └── js/
│       └── nn-shortcodes.js
├── languages/                 # .pot / translations
└── CONVENTIONS.md
```

## Adding a new shortcode

1. Create `shortcodes/class-nn-shortcode-{name}.php` extending `NN_Shortcode`.
2. Create `templates/shortcodes/{name}.php`.
3. Optionally add `assets/css/nn-shortcodes-{name}.css` and register the handle in `assets()`.
4. Use in content: `[nn-{name} attr="value"]`.

The registry auto-loads every `class-nn-shortcode-*.php` file on `init`.

## Shortcode naming

| Layer        | Pattern              | Example        |
|-------------|----------------------|----------------|
| PHP class   | `NN_Shortcode_{Name}`| `NN_Shortcode_Hero` |
| File        | `class-nn-shortcode-{name}.php` | `class-nn-shortcode-hero.php` |
| Tag         | `nn-{name}`          | `[nn-hero]`    |
| CSS block   | `nn-{name}`          | `.nn-hero`     |

Use **kebab-case** with the **`nn-`** prefix for shortcode tags (same as CSS blocks). Tags and BEM blocks align: `[nn-hero]` → `.nn-hero`.

## CSS class naming (BEM + `nn-` prefix)

Follow [BEM](http://getbem.com/) with a mandatory `nn-` block prefix.

| Type      | Pattern                    | Example              |
|-----------|----------------------------|----------------------|
| Block     | `nn-{component}`           | `.nn-hero`           |
| Element   | `nn-{component}__{part}`   | `.nn-hero__title`    |
| Modifier  | `nn-{component}--{variant}`| `.nn-hero--dark`     |
| Element modifier | `nn-{component}__{part}--{variant}` | `.nn-hero__title--large` |

### Shared utilities (cross-shortcode)

Reusable layout/spacing classes live in `nn-shortcodes.css`:

- `.nn-container` — max-width wrapper
- `.nn-section` — vertical section spacing
- `.nn-grid`, `.nn-flex` — add as needed

Utility modifiers: `.nn-text-center`, `.nn-hidden` (only if used in multiple shortcodes).

### Rules

1. **Every** plugin class starts with `nn-`.
2. **Never** target theme classes from plugin CSS (`.entry-content`, `.wp-block-*`, etc.).
3. **Never** use generic names: `.button`, `.card`, `.title` without the prefix.
4. Shortcode-specific CSS goes in `nn-shortcodes-{name}.css`, not the global file (unless it is a shared utility).
5. The `class` shortcode attribute accepts **only** valid `nn-*` classes (sanitized in the base class).
6. Prefer CSS custom properties for theme alignment: `--nn-container-max`, `--nn-color-primary`.

### PHP helper

```php
nn_class( 'nn-hero', 'title' );           // nn-hero__title
nn_class( 'nn-hero', '', 'dark' );        // nn-hero--dark
nn_class( 'nn-hero', 'title', 'large' ); // nn-hero__title--large
nn_block_classes( 'nn-hero', 'nn-section' );
```

## Asset loading

- Shared: `nn-shortcodes.css` / `nn-shortcodes.js` enqueue only when at least one NN shortcode renders on the page.
- Per-shortcode styles: register in `NN_Assets::register_shared()` when you add new CSS files, list handle in `assets()` on the shortcode class.

## Security

- Escape output in templates: `esc_html`, `esc_attr`, `esc_url`.
- Sanitize attributes in `prepare()` or `defaults()` validation.
- `index.php` silence in every folder prevents directory listing.

## Text domain

All user-facing strings: `__( '...', 'nn-shortcodes' )`.
