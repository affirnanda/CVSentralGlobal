describe('BF-4: Kelola FAQ', () => {
    it('TC-BF-4B: Admin menambah FAQ dengan data pertanyaan (≤100 karakter)', () => {
        // ==========================================
        // PRE-CONDITION: ADMIN LOGIN & MASUK KELOLA FAQ
        // ==========================================
        cy.visit('/login');

        // Login Admin
        cy.get('input[name="email"]').type('super@admin.com');
        cy.get('input[name="password"]').type('admin123');
        cy.get('button[type="submit"]').click();

        // Tunggu proses login selesai
        cy.url().should('include', '/dashboard');

        // Buka halaman kelola FAQ
        cy.visit('/faqs');
        cy.url().should('include', '/faqs');

        // ==========================================
        // SKENARIO PENGUJIAN
        // ==========================================
        // 1. Admin klik Tambah FAQ
        cy.get('a[href$="/faqs/create"]').click();
        cy.url().should('include', '/faqs/create');

        // 2. Admin mengisi pertanyaan dengan 100 karakter
        const pertanyaanMaksimal = 'A'.repeat(100);
        cy.get('input[name="question"]').type(pertanyaanMaksimal);

        // Verifikasi: Pertanyaan diterima form (disimpan sementara di input field)
        cy.get('input[name="question"]').should('have.value', pertanyaanMaksimal);

        // *Catatan Tambahan: 
        cy.get('textarea[name="answer"]').type('Ini adalah jawaban untuk memastikan form bisa disubmit.');

        cy.get('button[type="submit"]').click();

        // Expected Result: Sistem menerima dan menyimpan data tanpa error validasi kepanjangan
        cy.url().should('include', '/faqs');
        cy.contains('FAQ berhasil ditambahkan!').should('be.visible');

        // Memastikan pertanyaan 100 karakter tersebut masuk ke dalam tabel
        cy.contains(pertanyaanMaksimal).should('be.visible');
    });
});