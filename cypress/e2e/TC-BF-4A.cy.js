describe('BF-4: Kelola FAQ', () => {
    it('TC-BF-4A: Admin menambah FAQ, lalu tampil di Landing Page', () => {
        cy.visit('/login');

        cy.get('input[name="email"]').type('super@admin.com');
        cy.get('input[name="password"]').type('admin123');
        cy.get('button[type="submit"]').click();

        // Tunggu proses login selesai sampai masuk dashboard
        cy.url().should('include', '/dashboard');

        // Setelah dipastikan login berhasil dan sesi aktif, baru buka FAQ
        cy.visit('/faqs');
        cy.url().should('include', '/faqs');

        // 1. Admin klik tombol Tambah FAQ
        cy.get('a[href$="/faqs/create"]').click();
        cy.url().should('include', '/faqs/create');

        // 2. Admin mengisi pertanyaan dan jawaban
        cy.get('input[name="question"]').type('Bagaimana cara melakukan pemesanan?');
        cy.get('textarea[name="answer"]').type('Pilih produk lalu checkout');

        // 3. Admin klik Simpan
        cy.get('button[type="submit"]').click();

        // Verifikasi di sisi Admin
        cy.url().should('include', '/faqs');
        cy.contains('FAQ berhasil ditambahkan!').should('be.visible');
        cy.contains('Bagaimana cara melakukan pemesanan?').should('be.visible');

        //logout sesi selesai admin
        cy.clearAllCookies();
        cy.clearAllSessionStorage();
        cy.clearAllLocalStorage();

        //cek landing page
        cy.visit('/');

        // [Verifikasi di sisi Landing Page]
        // A. Scroll layar menuju letak pertanyaan agar animasi AOS berjalan (opacity menjadi 1)
        cy.contains('Bagaimana cara melakukan pemesanan?').scrollIntoView();

        // B. Verifikasi pertanyaan sudah terlihat
        cy.contains('Bagaimana cara melakukan pemesanan?').should('be.visible');

        // C. Klik pertanyaan untuk membuka tag <details> (accordion FAQ)
        cy.contains('Bagaimana cara melakukan pemesanan?').click();

        // D. Verifikasi jawaban di dalam accordion sudah terlihat
        cy.contains('Pilih produk lalu checkout').should('be.visible');
    });
});