(function() {
    let deferredPrompt;
    let isInstallable = false;

    console.log('[PWA] Initializing PWA Install module...');

    window.addEventListener('beforeinstallprompt', (e) => {
        console.log('[PWA] beforeinstallprompt fired - app is installable');
        // Prevent the mini-infobar from appearing on mobile
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;
        isInstallable = true;

        // Update UI notify the user they can install the PWA
        const installBtn = document.getElementById('pwa-install-btn');
        if (installBtn) {
            installBtn.style.display = 'inline-block';
            console.log('[PWA] Install button shown');
        } else {
            console.warn('[PWA] Install button not found in DOM');
        }

        // Dispatch a custom event for developers to listen to
        window.dispatchEvent(new CustomEvent('pwa-installable', { detail: { prompt: e } }));
    });

    window.addEventListener('appinstalled', (event) => {
        console.log('[PWA] App was installed successfully');
        isInstallable = false;
        deferredPrompt = null;

        const installBtn = document.getElementById('pwa-install-btn');
        if (installBtn) {
            installBtn.style.display = 'none';
        }

        // Dispatch a custom event
        window.dispatchEvent(new CustomEvent('pwa-installed'));
    });

    // Listen for app being uninstalled (some browsers)
    window.addEventListener('beforeuninstall', () => {
        console.log('[PWA] App uninstalled');
        isInstallable = false;
        deferredPrompt = null;
    });

    window.laravelPwaInstall = {
        /**
         * Check if the app is installable (beforeinstallprompt has fired)
         * @returns {boolean}
         */
        canInstall: function() {
            console.log('[PWA] canInstall() called, result:', isInstallable);
            return isInstallable;
        },

        /**
         * Show the install prompt
         * @returns {Promise<string|undefined>} 'accepted', 'dismissed', or undefined if not installable
         */
        showPrompt: async function() {
            if (!deferredPrompt) {
                console.warn('[PWA] Install prompt not available. The app might be:', {
                    isInstallable: isInstallable,
                    standalone: window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true,
                    iOS: /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream
                });
                return;
            }

            console.log('[PWA] Showing install prompt');
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            console.log(`[PWA] User response to the install prompt: ${outcome}`);

            if (outcome === 'accepted') {
                isInstallable = false;
                const installBtn = document.getElementById('pwa-install-btn');
                if (installBtn) {
                    installBtn.style.display = 'none';
                }
            }

            deferredPrompt = null;
            return outcome;
        },

        /**
         * Check if the app is already installed/running in standalone mode
         * @returns {boolean}
         */
        isStandalone: function() {
            const standalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
            console.log('[PWA] isStandalone() result:', standalone);
            return standalone;
        }
    };

    // Initialize default button behavior if it exists
    document.addEventListener('DOMContentLoaded', () => {
        console.log('[PWA] DOMContentLoaded - initializing button behavior');
        const installBtn = document.getElementById('pwa-install-btn');
        if (installBtn) {
            installBtn.addEventListener('click', () => {
                console.log('[PWA] Install button clicked');
                window.laravelPwaInstall.showPrompt();
            });
            console.log('[PWA] Install button listener attached');
        } else {
            console.warn('[PWA] Install button (pwa-install-btn) not found in DOM');
        }
    });

    // Log final status when everything is loaded
    window.addEventListener('load', () => {
        console.log('[PWA] Page fully loaded - Current status:', {
            installable: isInstallable,
            standalone: window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true,
            serviceWorkerReady: 'serviceWorker' in navigator
        });
    });
})();
