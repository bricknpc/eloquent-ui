---
sidebar_position: 4
title: Tabbed cards
description: Tabbed cards in Eloquent UI
---

# Tabbed cards

The tabbed card component provides a card with navigation tabs. In its simplest form, the component takes a list 
of tabs.

```html
<x-eloquent-ui::card.tabs>
    <x-eloquent-ui::card.tab title="First tab">Tab content</x-eloquent-ui::card.tab>
    <x-eloquent-ui::card.tab title="Second tab">Tab content</x-eloquent-ui::card.tab>
</x-eloquent-ui::card.tabs>
```

## Usage

The tab card combines two Bootstrap components: the card and the tabs. Its customisation is therefore limited, but 
you can still use the card's classes and attributes.

```html
<x-eloquent-ui::card.tabs class="mb-4">
    <x-eloquent-ui::card.tab title="First tab">Tab content</x-eloquent-ui::card.tab>
    <x-eloquent-ui::card.tab title="Second tab">Tab content</x-eloquent-ui::card.tab>
</x-eloquent-ui::card.tabs>
```

### Title

The `tab` component requires a `title` attribute. This attribute is used to display the text and the navigation part 
of the tab.

```html
<x-eloquent-ui::card.tabs>
    <x-eloquent-ui::card.tab title="First tab">Tab content</x-eloquent-ui::card.tab>
    <x-eloquent-ui::card.tab title="Second tab">Tab content</x-eloquent-ui::card.tab>
</x-eloquent-ui::card.tabs>
```

## Backend

The card tab component does not add any backend components.

## Advanced usage

Using the `card.tab` component outside a `card.tabs` component or inside a different component will trigger an error.