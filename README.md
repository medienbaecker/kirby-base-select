# Kirby Select

A drop-in replacement for the [Kirby](https://getkirby.com/) select field. Every option can show an icon or image, a second line of info, its own font and a colour theme, in the field, in its dropdown and in structure and object tables.

## Installation

```bash
composer require medienbaecker/kirby-select
```

Requires Kirby 6+ and PHP 8.3+. Without Composer, download this repository and copy it to `site/plugins/kirby-select`.

## Usage

Use `type: select` as usual. Options take these keys on top of `value` and `text`:

```yaml
status:
  type: select
  options:
    - value: draft
      text: Draft
      info: Not visible yet
      icon: circle-filled
      theme: negative
    - value: cover
      text: Cover image
      image: page.image("cover.jpg")
    - value: serif
      text: Georgia
      font: Georgia, serif
```

- `info`: dimmed text after the label
- `icon`: any Panel icon
- `image`: a query for a page or file, or image settings like `back` and `icon`
- `font`: a CSS font family; `mono` and `sans-serif` use the Panel fonts
- `theme`: a Panel theme like `positive`, `negative` or `blue`, which colours the icon

`placeholderIcon` sets an icon next to the placeholder.

Options from `type: query` and `type: api` accept the same keys as templates, e.g. `icon: "{{ item.icon }}"`.

## Browser support

The dropdown uses the customizable select (`appearance: base-select`) on devices with a mouse in browsers that support it. Everywhere else the field falls back to the native select, which shows the text and info but no icons, images or fonts.

## License

MIT
