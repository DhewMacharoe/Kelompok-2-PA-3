# Design System Proposal

## Tujuan
Menyatukan language visual publik, auth, dan admin agar seluruh komponen utama memakai token warna, typography, radius, spacing, dan shadow yang sama.

## Arah Visual
Arah visual yang diusulkan adalah "warm editorial barbershop": gelap, hangat, rapi, dan modern. Identitas ini tetap cocok untuk brand barbershop/kafe, tetapi cukup netral untuk dipakai di publik, login, dan admin.

## Token Dasar
### Warna utama
- `--color-primary`: `#1C1C1C`
- `--color-primary-strong`: `#111111`

### Warna aksen
- `--color-accent`: `#C8A24A`
- `--color-accent-soft`: `#F4E7C1`

### Warna pendukung
- `--color-surface`: `#FFFFFF`
- `--color-surface-2`: `#F8F5EF`
- `--color-background`: `#F3EFE7`
- `--color-border`: `#E5DCCB`
- `--color-text`: `#1F1F1F`
- `--color-text-muted`: `#66615A`
- `--color-success`: `#1F7A4D`
- `--color-warning`: `#A86A00`
- `--color-danger`: `#C83F3F`
- `--color-info`: `#2B6CB0`

### Typography
- Body: `Manrope`, sans-serif
- Heading: `Sora`, sans-serif
- Display: `Fraunces`, serif

### Border Radius
- `--radius-sm`: `8px`
- `--radius-md`: `12px`
- `--radius-lg`: `16px`
- `--radius-xl`: `24px`
- `--radius-pill`: `999px`

### Spacing Scale
- `--space-1`: `4px`
- `--space-2`: `8px`
- `--space-3`: `12px`
- `--space-4`: `16px`
- `--space-5`: `20px`
- `--space-6`: `24px`
- `--space-8`: `32px`
- `--space-10`: `40px`
- `--space-12`: `48px`

### Shadow Scale
- `--shadow-xs`: `0 1px 2px rgba(15, 15, 15, 0.05)`
- `--shadow-sm`: `0 4px 12px rgba(15, 15, 15, 0.08)`
- `--shadow-md`: `0 12px 24px rgba(15, 15, 15, 0.12)`
- `--shadow-lg`: `0 20px 40px rgba(15, 15, 15, 0.16)`
- `--shadow-inset`: `inset 0 1px 0 rgba(255, 255, 255, 0.5)`

## Komponen Inti
### Button
- Primary: background primary, text white, radius pill, shadow-sm.
- Secondary: white background, border border-color, text primary.
- Accent: background accent, text primary strong.
- Danger: background danger, text white.
- Semua button memakai padding dan font-weight yang sama.

### Card
- Background surface, border 1px solid border, radius lg.
- Hover memakai shadow-md dan transform ringan.
- Padding standar 20-24px.

### Modal
- Background surface, radius xl, shadow-lg.
- Header memakai border-bottom lembut.
- Footer menggunakan gap konsisten dan alignment end.

### Form
- Input, select, textarea memakai radius md, border border-color, background surface.
- Focus state memakai border accent dan ring lembut.
- Label memakai font-weight 600 dan warna text-muted.

### Badge
- Menggunakan radius pill.
- Warna badge dibedakan hanya lewat status token: success, warning, danger, info, neutral.

## Prinsip Implementasi
- Tidak ada lagi hardcoded radius kecil yang berbeda-beda tanpa alasan.
- Tidak ada warna tombol, badge, atau modal yang berdiri sendiri di tiap halaman jika bisa memakai token.
- Komponen publik, auth, dan admin boleh berbeda rasa, tetapi harus memakai token yang sama.
- Mobile first: spacing dan ukuran komponen harus tetap nyaman pada layar kecil.

## Langkah Implementasi
1. Buat file token global `resources/css/design-tokens.css`.
2. Import token ke stylesheet utama.
3. Refactor shared classes untuk button, card, modal, form, dan badge.
4. Sesuaikan auth, public, dan admin agar memanfaatkan token baru.
5. Audit ulang seluruh halaman dengan pencarian istilah warna, radius, dan class komponen lama.
