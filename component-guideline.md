# Component Guideline

## Shared Design Tokens
- Use `design-tokens.css` as the single source for colors, typography, radius, spacing, and shadow.
- Prefer semantic token names over page-specific hex values.

## Buttons
- Primary action: dark fill with white text.
- Secondary action: transparent or white fill with border.
- Destructive action: red fill.
- Use the same radius and font weight across public, auth, and admin.

## Cards
- Use one surface color, one border color, and one shadow scale.
- Keep card padding consistent.
- Do not mix multiple border radius values on the same page without a clear reason.

## Modals
- Use the same modal radius, header border, and footer spacing everywhere.
- Modal actions should follow the same button hierarchy as the rest of the system.

## Forms
- Inputs, selects, and textareas should share the same border, focus ring, and radius.
- Labels should use the same font weight and muted text color.

## Badges
- Use badge shapes only for status or compact metadata.
- Status colors should be limited to neutral, info, success, warning, and danger.

## Layout Principles
- Public, auth, and admin can have different composition, but not different component language.
- Mobile layouts should keep the same component tokens and only adjust spacing or stacking.
- Avoid page-only component styling when a shared token or shared class is enough.
