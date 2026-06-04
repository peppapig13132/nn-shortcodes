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
[nn-hero chart="123" icons="101,102,103,104,105,106,107,108,109,110"]
```

| Attribute  | Description |
|-----------|-------------|
| `chart`   | Center chart image (attachment ID or URL) |
| `icons`   | Comma-separated list of orbiting icon IDs or URLs (60px / 3.75rem each) |
| `duration`| Orbit speed in seconds (default `28`) |
| `class`   | Extra `nn-*` utility classes |

To find attachment IDs: open an image in **Media → Library**, check the URL (`post=123`) or use a plugin that shows IDs in the list.

**Responsive / Elementor:** The hero uses `width: 100%` and scales chart, icons, and orbit together inside the parent column (container queries). Place the shortcode in a column wide enough for the animation; on mobile it shrinks proportionally up to the design maximum (470px chart, 60px icons).

## Requirements

- WordPress 6.0+
- PHP 7.4+
