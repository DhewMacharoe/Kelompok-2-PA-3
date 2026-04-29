 <style>
     /* CSS untuk membuat antrian bisa di-scroll */
     .queue-list-container {
         max-height: 400px;
         overflow-y: auto;
         overflow-x: hidden;
         padding-right: 10px;
     }

     .queue-list-container::-webkit-scrollbar {
         width: 6px;
     }

     .queue-list-container::-webkit-scrollbar-track {
         background: #f1f1f1;
         border-radius: 10px;
     }

     .queue-list-container::-webkit-scrollbar-thumb {
         background: #c1c1c1;
         border-radius: 10px;
     }

     .queue-list-container::-webkit-scrollbar-thumb:hover {
         background: #a8a8a8;
     }

     /* Modifikasi sedikit untuk tombol di offcanvas agar sesuai tema */
     .btn-submit-bottom {
         background-color: #0d6efd;
         /* Sesuaikan warna dengan tema Anda */
         color: white;
         padding: 10px;
         font-weight: bold;
         border-radius: 8px;
     }

     .my-queue-card {
         margin: 20px 30px 0;
         background: linear-gradient(135deg, #fffdf6 0%, #fff8e8 100%);
         border: 1px solid #e8d7ad;
         border-radius: 14px;
         box-shadow: 0 8px 20px rgba(112, 86, 35, 0.12);
         padding: 16px 18px;
     }

     .my-queue-header {
         display: flex;
         justify-content: space-between;
         align-items: center;
         gap: 10px;
         margin-bottom: 12px;
     }

     .my-queue-title {
         font-size: 1.05rem;
         font-weight: 800;
         color: #2e2a1f;
         margin: 0;
     }

     .my-queue-number {
         background: #1b1b1b;
         color: #ffffff;
         border-radius: 10px;
         min-width: 58px;
         text-align: center;
         padding: 6px 12px;
         font-size: 1.25rem;
         font-weight: 800;
     }

     .my-queue-meta {
         border-top: 1px solid #e7dcc2;
         padding-top: 10px;
         margin-bottom: 12px;
     }

     .my-queue-meta-row {
         display: flex;
         justify-content: space-between;
         align-items: center;
         margin-bottom: 6px;
         gap: 14px;
     }

     .my-queue-meta-label {
         color: #777067;
         font-weight: 600;
     }

     .my-queue-meta-value {
         color: #2e2a1f;
         font-weight: 700;
         text-align: right;
     }

     .my-queue-status-chip {
         display: inline-flex;
         align-items: center;
         gap: 6px;
         font-size: 0.75rem;
         font-weight: 700;
         letter-spacing: 0.4px;
         padding: 4px 10px;
         border-radius: 999px;
         text-transform: uppercase;
         border: 1px solid #d3c4a0;
         color: #7a5b1c;
         background: #fff6dd;
     }

     .btn-cancel-my-queue {
         border: 1px solid #d9534f;
         background: #d9534f;
         color: #ffffff;
         width: 100%;
         border-radius: 10px;
         font-weight: 700;
         padding: 9px 12px;
     }

     .btn-cancel-my-queue:hover {
         background: #c6423e;
         border-color: #c6423e;
         color: #ffffff;
     }

     .btn-cancel-my-queue:disabled,
     .btn-cancel-my-queue.disabled {
         background: #b7b7b7;
         border-color: #b7b7b7;
         color: #f5f5f5;
         cursor: not-allowed;
         opacity: 0.8;
     }

     .btn-cancel-my-queue:disabled:hover,
     .btn-cancel-my-queue.disabled:hover {
         background: #b7b7b7;
         border-color: #b7b7b7;
         color: #f5f5f5;
     }

     .queue-card.my-queue-highlight {
         border: 1px solid #d8bd79;
         box-shadow: 0 4px 14px rgba(201, 156, 62, 0.2);
         background: #fffaf0;
     }

     .badge-mine {
         border: 1px solid #1f6f43;
         color: #1f6f43;
         background-color: #e8f7ef;
         font-size: 0.68rem;
         padding: 5px 10px;
         border-radius: 20px;
         font-weight: 700;
         letter-spacing: 0.4px;
         margin-right: 6px;
     }

     .guest-queue-hint {
         border: 1px dashed #d8bd79;
         background: linear-gradient(135deg, #fffdf7 0%, #fff6e4 100%);
         border-radius: 12px;
         padding: 14px 16px;
         text-align: center;
     }

     .guest-queue-hint p {
         margin: 0;
         color: #4a3f2b;
         font-weight: 600;
         line-height: 1.45;
     }

     @media (max-width: 991.98px) {
         .app-card {
             margin: 24px auto;
         }

         .header-section {
             padding: 42px 20px;
             min-height: 280px;
         }

         .active-number {
             font-size: 4rem;
         }

         .queue-section {
             padding: 24px;
         }

         .footer-section {
             padding: 16px 24px 24px;
         }

         .my-queue-card {
             margin: 16px 24px 0;
         }
     }

     @media (max-width: 767.98px) {
         .app-card {
             margin: 16px auto;
             border-radius: 12px;
         }

         .header-section {
             padding: 28px 16px;
             min-height: auto;
         }

         .text-gold {
             margin-bottom: 12px;
         }

         .active-number-box {
             padding: 10px 28px;
             margin: 12px 0;
         }

         .active-number {
             font-size: 3rem;
         }

         .active-name {
             font-size: 0.95rem;
             letter-spacing: 1px;
             margin-top: 12px;
             word-break: break-word;
         }

         .queue-section {
             padding: 16px;
         }

         .section-title {
             margin-bottom: 16px;
         }

         .queue-list-container {
             max-height: 320px;
             padding-right: 6px;
         }

         .queue-card {
             flex-wrap: wrap;
             gap: 10px;
             align-items: flex-start;
         }

         .queue-number-box {
             width: 44px;
             height: 44px;
             font-size: 1rem;
         }

         .queue-info {
             margin-left: 10px;
             min-width: 0;
             flex: 1 1 auto;
         }

         .queue-name {
             font-size: 0.95rem;
             overflow-wrap: anywhere;
         }

         .queue-time {
             font-size: 0.75rem;
         }

         .badge-waiting,
         .badge-mine {
             font-size: 0.65rem;
             padding: 4px 8px;
         }

         .footer-section {
             padding: 12px 16px 16px;
         }

         .my-queue-card {
             margin: 12px 16px 0;
             padding: 14px;
         }

         .my-queue-header {
             align-items: flex-start;
         }

         .my-queue-number {
             font-size: 1.1rem;
             min-width: 52px;
             padding: 6px 10px;
         }

         .my-queue-meta-row {
             align-items: flex-start;
             flex-direction: column;
             gap: 4px;
         }

         .my-queue-meta-value {
             text-align: left;
             overflow-wrap: anywhere;
         }

         .offcanvas.offcanvas-bottom {
             max-height: 88vh;
         }

         .offcanvas .offcanvas-body {
             overflow-y: auto;
         }
     }

     @media (max-width: 420px) {
         .active-number {
             font-size: 2.6rem;
         }

         .my-queue-title {
             font-size: 0.95rem;
         }
     }
 </style>
 <style>
     /* HAPUS CSS 'body' dari sini agar tidak bertabrakan dengan layout utama dan Navbar */

     /* Container aplikasi utama */
     .app-card {
         max-width: 900px;
         /* Lebar maksimal untuk desktop */
         width: 100%;
         margin: 40px auto;
         /* Margin atas-bawah diperbesar sedikit agar berjarak dari Navbar */
         background-color: #ffffff;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
         border-radius: 16px;
         overflow: hidden;
     }

     /* Bagian Header (Sedang Dilayani) */
     .header-section {
         background-color: #1a1a1a;
         padding: 60px 20px;
         text-align: center;
         height: 100%;
         display: flex;
         flex-direction: column;
         justify-content: center;
         align-items: center;
     }

     .text-gold {
         color: #c99c3e;
         letter-spacing: 2px;
         font-size: 0.85rem;
         font-weight: 700;
         margin-bottom: 20px;
     }

     .active-number-box {
         border: 2px solid #c99c3e;
         padding: 15px 60px;
         margin: 20px 0;
         border-radius: 8px;
     }

     .active-number {
         font-size: 5rem;
         font-weight: 800;
         color: #ffffff;
         line-height: 1;
         margin: 0;
     }

     .active-name {
         color: #a0a0a0;
         font-family: monospace;
         font-size: 1.1rem;
         letter-spacing: 2px;
         margin-top: 20px;
     }

     /* Bagian Daftar Antrean (Kanan/Bawah) */
     .right-panel {
         display: flex;
         flex-direction: column;
         height: 100%;
     }

     .queue-section {
         padding: 30px;
         flex-grow: 1;
     }

     .section-title {
         display: flex;
         align-items: center;
         font-size: 0.8rem;
         font-weight: 700;
         color: #6c757d;
         margin-bottom: 25px;
         letter-spacing: 1px;
     }

     .section-title::after {
         content: "";
         flex: 1;
         margin-left: 15px;
         height: 1px;
         background-color: #e0e0e0;
     }

     .queue-card {
         border: 1px solid #e0e0e0;
         border-radius: 8px;
         margin-bottom: 12px;
         padding: 10px;
         display: flex;
         align-items: center;
         transition: transform 0.2s, box-shadow 0.2s;
     }

     .queue-card:hover {
         transform: translateY(-2px);
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
     }

     .queue-number-box {
         background-color: #1a1a1a;
         color: white;
         width: 50px;
         height: 50px;
         display: flex;
         align-items: center;
         justify-content: center;
         font-weight: bold;
         font-size: 1.2rem;
         border-radius: 6px;
         flex-shrink: 0;
     }

     .queue-info {
         margin-left: 15px;
         flex-grow: 1;
     }

     .queue-name {
         font-weight: 700;
         font-size: 1rem;
         margin: 0;
         color: #212529;
     }

     .queue-time {
         font-size: 0.8rem;
         color: #888;
         margin: 0;
         font-weight: 600;
     }

     .badge-waiting {
         border: 1px solid #c99c3e;
         color: #c99c3e;
         background-color: transparent;
         font-size: 0.7rem;
         padding: 5px 12px;
         border-radius: 20px;
         font-weight: 700;
         letter-spacing: 0.5px;
     }

     /* Bagian Tombol */
     .footer-section {
         padding: 20px 30px 30px 30px;
         margin-top: auto;
     }

     .btn-add-queue {
         background-color: #c49a45;
         color: #1a1a1a;
         font-weight: 700;
         border: none;
         width: 100%;
         padding: 14px;
         border-radius: 8px;
         font-size: 1rem;
         transition: background-color 0.3s;
     }

     .btn-add-queue:hover {
         background-color: #b0893a;
         color: #1a1a1a;
     }
 </style>
