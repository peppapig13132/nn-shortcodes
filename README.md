# NN Shortcodes

WordPress plugin providing custom shortcodes and section blocks for the [NN Partners](https://nn.partners) website.

## Installation

1. Copy the `nn-shortcodes` folder to `wp-content/plugins/`.
2. Activate **NN Shortcodes** in the WordPress admin.
3. Use shortcodes in pages, posts, or block Shortcode widget.

## Documentation

See [CONVENTIONS.md](CONVENTIONS.md) for folder structure, BEM/`nn-` CSS rules, and how to add new shortcodes.

## Shortcodes

All tags use the **`nn-`** prefix and **kebab-case** (e.g. `[nn-preheading]`, `[nn-hero]`).

### Preheading

Use this above a heading to render a short preheading line with a leading dash/line.

```text
[nn-preheading text="PPC Management + Data Intelligence"]
```

### Hero orbit

Animated hero with a center chart and platform icons orbiting clockwise on top of the chart. Pass **Media Library attachment IDs** or image URLs.

```text
[nn-hero chart="4434" hero-guy="4432" icons="4417,4418,4419,4420,4421,4422,4423,4437,4439,4440"]
```

| Attribute  | Description |
|-----------|-------------|
| `chart`   | Center chart image (attachment ID or URL) |
| `hero-guy`| Foreground person image (attachment ID or URL); slides up on load |
| `icons`   | Comma-separated list of orbiting icon IDs or URLs (60px / 3.75rem each) |
| `duration`| Orbit speed in seconds (default `28`) |
| `class`   | Extra `nn-*` utility classes |

To find attachment IDs: open an image in **Media → Library**, check the URL (`post=123`) or use a plugin that shows IDs in the list.

**Responsive / Elementor:** The section `.nn-hero` uses a **566×630** aspect ratio (`--nn-hero-ratio-w` / `--nn-hero-ratio-h`), `overflow: hidden`, and container queries so chart, icons, and hero guy scale together in any column width. Override the ratio or `max-width` in custom CSS if a page needs a different box size.

## Requirements

- WordPress 6.0+
- PHP 7.4+
