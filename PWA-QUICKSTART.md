# ⚡ PWA Quick Start - Testing Guide

## 🚀 Langkah Cepat (5 Menit)

### 1. **Clear Everything**
```bash
php artisan cache:clear
php artisan config:clear  
php artisan view:clear
```

### 2. **Start Server**
```bash
php artisan serve
```

Akan menampilkan:
```
INFO  Server running on [http://127.0.0.1:8000]
```

### 3. **Clear Browser Cache**
- **Chrome/Edge**: Ctrl+Shift+Del (Cached images and files → All time → Clear data)
- **Firefox**: Ctrl+Shift+Del (Everything → Last Hour atau All Time)
- **Safari**: Preferences → Privacy → Manage Website Data → Remove All

### 4. **Test PWA di Browser**

#### **Option A: Desktop Testing (Recommended)**
1. Buka: `http://localhost:8000`
2. Tunggu 3-5 detik
3. Lihat di navbar - harus ada tombol biru "Install App"
4. Klik tombol tersebut
5. Dialog akan muncul untuk install
6. Klik "Install"

#### **Option B: Debug Mode**
Jika tombol tidak muncul:
1. Buka: `http://localhost:8000/pwa-debug.html`
2. Lihat status di halaman
3. Klik tombol untuk debug

#### **Option C: Developer Tools**
```javascript
// Buka DevTools (F12), Tab Console, paste:

navigator.serviceWorker.getRegistrations()
  .then(regs => {
    console.log('Service Workers:', regs);
    regs.forEach(r => console.log('Scope:', r.scope));
  });

// Check manifest:
fetch('manifest.json').then(r => r.json()).then(console.log);
```

## 🎯 Expected Results

### ✅ Service Worker Registered
```
[PWA] Service Worker registered successfully
```

### ✅ Manifest Loaded
```json
{
  "name": "Arga Barbershop",
  "display": "standalone",
  // ...
}
```

### ✅ Install Button Visible
- Tombol "Install App" muncul di navbar (warna biru)
- Atau icon install di address bar (Chrome/Edge)

### ✅ Can Install App
- Klik tombol → Dialog install muncul
- Klik "Install" → App ter-install
- Shortcut di desktop/home screen

## ❌ Jika Tidak Berhasil

### Problem: Button tidak muncul

**Quick Fix:**
```bash
# 1
php artisan cache:clear

# 2 - Hard refresh di browser
Ctrl+Shift+R (atau Cmd+Shift+R di Mac)

# 3 - Tunggu 5 detik

# 4 - Buka DevTools → F12 → Console → cari [PWA]
```

**Deep Dive:**
1. Buka `http://localhost:8000/pwa-debug.html`
2. Lihat error message
3. Klik "Unregister Service Worker"
4. Klik "Clear All Caches"
5. Klik "Register Service Worker"
6. Reload halaman utama

### Problem: Manifest error

Di DevTools → Network → cari `manifest.json`:
- Status harus **200**
- Content-Type harus **application/manifest+json**
- Preview harus valid JSON

### Problem: Service Worker failed

Di DevTools → Application → Service Workers:
- Status harus **activated and running** (hijau)
- Jika tidak: klik "Unregister" lalu reload

## 📱 Mobile Testing

### Android Chrome:
1. Akses dari mobile: `http://your-desktop-ip:8000`
2. Tunggu 5 detik
3. Tap menu (⋮) → "Install app"
   ATAU cari tombol "Install App" di top

### iPhone (Safari):
1. Akses: `http://your-desktop-ip:8000`
2. Tap Share (↗️ icon)
3. Scroll ke "Add to Home Screen"
4. Tap "Add"

## 🔍 File-File Penting Check

| File | Status | Catatan |
|------|--------|---------|
| public/manifest.json | ✅ Ada | Main PWA config |
| public/sw.js | ✅ Ada | Service worker |
| public/pwa-install.js | ✅ Ada | Install logic |
| public/offline.html | ✅ Ada | Offline fallback |
| public/pwa-debug.html | ✅ Ada | Debug page |
| resources/js/app.js | ✅ Ada | SW registration |
| bootstrap/providers.php | ✅ PWAServiceProvider | Provider registration |

## 🎬 Quick Actions

Dalam DevTools Console, paste untuk testing:

```javascript
// Check if can install
window.laravelPwaInstall?.canInstall()

// Try to install manually
window.laravelPwaInstall?.showPrompt()

// Check if standalone (already installed)
window.laravelPwaInstall?.isStandalone()

// Get all service workers
navigator.serviceWorker.getRegistrations().then(r => console.log(r))

// Clear cache
caches.keys().then(names => 
  Promise.all(names.map(n => caches.delete(n)))
).then(() => console.log('Cache cleared'))
```

## 📚 Resources

- **Debug Page**: http://localhost:8000/pwa-debug.html
- **Full Guide**: Lihat `PWA-GUIDE.md` di root project
- **Offline Test**: Matikan WiFi → reload halaman → harus jalan offline

---

**Catatan**: Jika masih tidak bisa, lihat console (F12 → Console) untuk detailed error messages dengan prefix `[PWA]`
