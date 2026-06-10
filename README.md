# NN Shortcodes

WordPress plugin providing custom shortcodes and section blocks for the [NN Partners](https://nn.partners) website.

## Installation

1. Copy the `nn-shortcodes` folder to `wp-content/plugins/`.
2. Activate **NN Shortcodes** in the WordPress admin.
3. Use shortcodes in pages, posts, or block Shortcode widget.

## Documentation

See [CONVENTIONS.md](CONVENTIONS.md) for folder structure, BEM/`nn-` CSS rules, and how to add new shortcodes.

## Shortcodes

All tags use the **`nn-`** prefix and **kebab-case** (e.g. `[nn-preheading]`, `[nn-hero-full-funnel]`).

### Preheading

Use this above a heading to render a short preheading line with a leading dash/line.

```text
[nn-preheading text="PPC Management + Data Intelligence"]
```

### Home hero chart

Green circle (470px) with four growth bars (56px wide, 14px corner radius) and **11 static platform icons** on a ring around the chart. Bars grow up from the bottom with the same staggered animation as the `.dash-chart` mock on nn.partners (`grow-bar`: 0.7s, `cubic-bezier(.2,.7,.2,1)`, delays 0.05s–0.26s).

```text
[nn-home-hero icons="4417,4418,4419,4420,4421,4422,4423,4437,4439,4440,4441"]
```

| Attribute    | Description |
|-------------|-------------|
| `icons`     | Comma-separated Media Library attachment IDs (or image URLs) — evenly spaced around the chart, static (no orbit) |
| `grow-delay`| Extra seconds to wait after the page finishes loading before bars animate (default `0.8`) |
| `class`     | Extra `nn-*` utility classes |

To find attachment IDs: open an image in **Media → Library** and check the URL (`post=123`).

### Hero full-funnel dashboard

Self-contained cross-channel dashboard mock with GSAP count-up animation. Drop into Elementor via Shortcode widget.

**Safest (one line — spaces in quotes are fine):**

```text
[nn-hero-full-funnel heading="One dashboard · every channel, measured the same way" rows="Google|44|2.8,Meta|39|3.4,Microsoft|27|4.6|win|↑ scale" duration="2"]
```

**Recommended for the block editor (put long text in the body, not split across attribute lines):**

```text
[nn-hero-full-funnel rows="Google|44|2.8,Meta|39|3.4,Microsoft|27|4.6|win|↑ scale" duration="2"]
One dashboard · every channel, measured the same way
---
Illustrative — your real cross-channel dashboard
[/nn-hero-full-funnel]
```

**Important:**
- Spaces **do** work inside quoted attributes, but **multi-line shortcode tags** often break in the block editor. Prefer **one line** or use **inner content** (above).
- Do **not** put `[` or `]` inside attributes.
- Use straight quotes `"` or `'`, not curly `“ ”`.
- You can use `+` instead of spaces in attributes: `heading="One+dashboard+every+channel"`.

| Attribute  | Description |
|-----------|-------------|
| `heading` | Title above the table |
| `caption` | Footer note under the table |
| `rows`    | Comma-separated rows: `Channel\|cost\|roas\|win\|note` — `win` or `1` highlights a row; optional `note` (e.g. `↑ scale`) |
| `duration`| Count-up animation length in seconds (default `2`) |
| `class`   | Extra `nn-*` utility classes |

**Rows format:** each row is `Channel|cost|roas` with optional `|win|` and optional note:

```text
Google|44|2.8
Meta|39|3.4
Microsoft|27|4.6|win|↑ scale
```

Numbers count from 0 when the block scrolls into view. Cost shows as `$44`, ROAS as `2.8x`.

### Hero conversion-tracking data flow

Illustrative server-side tracking diagram: source → GTM hub → destination platforms. Drop into Elementor via Shortcode widget.

```text
[nn-hero-conversion-tracking]
```

Custom labels (use `|` for line breaks inside a node; preserves `+`):

```text
[nn-hero-conversion-tracking source="Your Site|& App" hub="GTM +|Server-Side" destinations="GA4,Google Ads,Meta,Microsoft,BigQuery"]
```

| Attribute      | Description |
|----------------|-------------|
| `source`       | Left node label; `|` splits lines (default `Your Site|& App`) |
| `hub`          | Center hub label; `|` splits lines (default `GTM +|Server-Side`) |
| `destinations` | Comma-separated destination labels (default `GA4,Google Ads,Meta,Microsoft,BigQuery`) |
| `caption`      | Footer note (default illustrative caption, auto-bracketed) |
| `class`        | Extra `nn-*` utility classes |

## Requirements

- WordPress 6.0+
- PHP 7.4+
