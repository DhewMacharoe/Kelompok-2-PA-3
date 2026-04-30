# 🚀 PWA Setup & Troubleshooting Guide

Panduan lengkap untuk memastikan PWA (Progressive Web App) Arga Barbershop dapat diinstall dan berfungsi dengan baik.

## ✅ Langkah-Langkah Setup

### 1. **Clear Cache & Build**

```bash
# Clear Laravel cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Build assets
npm run build
# atau untuk development dengan watch
npm run dev
```

### 2. **Jalankan Development Server**

```bash
php artisan serve
```

**PENTING**: Service worker memerlukan HTTPS di production, tapi di localhost (development) sudah cukup.

### 3. **Verifikasi PWA**

Buka browser ke: `http://localhost:8000/pwa-debug.html`

Halaman ini akan menampilkan status lengkap:
- ✅ Manifest loading
- ✅ Service Worker registration
- ✅ Install prompt availability
- ✅ Standalone mode
- ✅ HTTPS status

## 🔍 Debugging

### **Method 1: Gunakan Halaman Debug** (Recommended)
```
http://localhost:8000/pwa-debug.html
```
Lihat status lengkap dan jalankan action untuk:
- Register Service Worker
- Unregister Service Worker
- Clear semua cache
- Reload page

### **Method 2: Chrome DevTools**

1. Buka DevTools (F12 atau Ctrl+Shift+I)
2. Tab **Application**
3. Lihat:
   - **Manifest** - Pastikan terbaca dengan benar
   - **Service Workers** - Pastikan status "activated" (berwarna hijau)
   - **Cache Storage** - Lihat cache yang tersimpan
   - **Local Storage** - Debug data

### **Method 3: Console Logs**

DevTools → Console, cari messages yang dimulai dengan `[PWA]`:
```javascript
[PWA] Initializing PWA Install module...
[PWA] beforeinstallprompt fired - app is installable
[PWA] Service Worker registered successfully
```

## 📱 Cara Menginstall PWA

### **Di Desktop (Chrome/Edge/Firefox)**

1. Buka aplikasi di browser: `http://localhost:8000`
2. Tunggu 3-5 detik hingga prompt muncul
3. **Opsi A**: Klik tombol "Install App" di navbar biru
4. **Opsi B**: Klik icon install di address bar (ikon rumah + tanda +)
5. Klik "Install"

### **Di Mobile Android**

1. Buka di Chrome: `http://your-ip:8000`
2. Tap menu (⋮) → "Install app" atau lihat "Add to Home Screen"
3. Atau ketuk tombol "Install App" di navbar

### **Di iPhone/iPad**

1. Buka di Safari
2. Tap Share icon
3. Tap "Add to Home Screen"
4. Nama: "Arga" (atau pilih nama lain)
5. Tap "Add"

**Catatan**: iPhone tidak mendukung `beforeinstallprompt` event, jadi hanya tersedia melalui menu Share Safari.

## ⚠️ Troubleshooting

### **Masalah: Tombol "Install App" tidak muncul**

**Penyebab:**
- [ ] Service Worker tidak ter-register
- [ ] Manifest.json tidak dapat di-load
- [ ] App sudah installed
- [ ] Browser cache belum di-clear

**Solusi:**

```bash
# 1. Clear semua cache
php artisan cache:clear

# 2. Clear browser cache dengan hard refresh
# Windows: Ctrl+Shift+R
# Mac: Cmd+Shift+R

# 3. Ke halaman debug untuk diagnostik
# Buka: http://localhost:8000/pwa-debug.html

# 4. Di DevTools → Application → Service Workers
# Unregister semua service workers

# 5. Di DevTools → Application → Cache Storage
# Delete semua cache

# 6. Reload halaman

# 7. Tunggu 3-5 detik
```

### **Masalah: Service Worker tidak ter-register**

**Check:**
1. Buka DevTools → Console
2. Cari error yang dimulai dengan `[PWA]`
3. Lihat `http://localhost:8000/pwa-debug.html` untuk status detail

**Solusi:**
```javascript
// Di browser console, jalankan:
navigator.serviceWorker.getRegistrations()
  .then(registrations => {
    console.log('Registrations:', registrations);
    registrations.forEach(reg => console.log(reg.scope));
  });
```

### **Masalah: Manifest tidak ter-load**

**Check di DevTools:**
1. Tab Network
2. Refresh halaman
3. Cari `manifest.json`
4. Status harus "200 OK"
5. Lihat response preview - harus valid JSON

**Solusi jika 404:**
```bash
# Pastikan file ada di public folder
ls -la public/manifest.json

# Clear cache dan rebuild
php artisan cache:clear
php artisan config:clear
npm run build
```

### **Masalah: "Offline page" terus muncul saat online**

**Penyebab**: Service Worker cache belum ter-clear dengan baik

**Solusi:**
1. Buka `http://localhost:8000/pwa-debug.html`
2. Klik "Clear All Caches"
3. Klik "Unregister Service Worker"
4. Klik "Register Service Worker"
5. Reload halaman utama

## 📋 Checklist Sebelum Deploy ke Production

- [ ] HTTPS enabled
- [ ] manifest.json valid (gunakan https://www.pwabuilder.com/validator)
- [ ] Service worker script tersedia
- [ ] Icons tersedia di semua ukuran (72x72, 96x96, 128x128, 144x144, 152x152, 192x192, 384x384, 512x512)
- [ ] offline.html page terlihat bagus
- [ ] Tested di:
  - [ ] Chrome/Edge desktop
  - [ ] Firefox desktop
  - [ ] Chrome mobile
  - [ ] Safari mobile (iOS)

## 🔧 File-File Penting PWA

```
public/
├── manifest.json          # PWA metadata
├── sw.js                  # Service Worker
├── pwa-install.js         # Install button logic
├── background-sync.js     # Offline sync
├── offline.html           # Offline fallback page
├── pwa-debug.html         # Debug page
├── icon-*.png             # App icons
└── favicon.png            # Favicon

resources/
└── js/
    └── app.js             # Service Worker registration

app/Http/Middleware/
└── PWAHeaders.php         # Middleware untuk PWA headers

bootstrap/
└── providers.php          # Pastikan PWAServiceProvider tercantum
```

## 📚 Useful Links

- [MDN - Web App Manifests](https://developer.mozilla.org/en-US/docs/Web/Manifest)
- [MDN - Service Workers](https://developer.mozilla.org/en-US/docs/Web/API/Service_Worker_API)
- [PWA Builder](https://www.pwabuilder.com/)
- [Google PWA Checklist](https://web.dev/pwa-checklist/)
- [Can I use - Service Workers](https://caniuse.com/serviceworkers)

## ❓ FAQ

**Q: Apakah PWA hanya untuk Chrome?**
A: Tidak, PWA didukung oleh sebagian besar browser modern (Chrome, Edge, Firefox, Opera). Safari (iOS) mendukung beberapa fitur PWA tapi dengan keterbatasan.

**Q: Apakah saya perlu HTTPS di development?**
A: Tidak, localhost dan 127.0.0.1 bisa menggunakan HTTP. Tapi di production wajib HTTPS.

**Q: Bagaimana cara update PWA yang sudah installed?**
A: Service Worker akan auto-check untuk update setiap menit. Jika ada update, user akan diminta untuk reload.

**Q: Bagaimana cara uninstall PWA?**
A: Seperti uninstall aplikasi normal:
- Desktop: Settings → Apps
- Android: Settings → Apps
- iPhone: Tahan icon → Remove App

---

**Terakhir diupdate**: April 30, 2026
**Version**: 1.0
