describe('BF-4: Kelola FAQ', () => {
    it('TC-BF-4G: Admin menambah FAQ dengan jawaban kosong', () => {
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

        // 2. Admin tidak mengisi jawaban
        cy.get('input[name="question"]').type('Bagaimana cara melacak pesanan saya?');

        cy.get('textarea[name="answer"]')
            .clear()
            .invoke('removeAttr', 'required');

        // 3. Admin klik Simpan
        cy.get('button[type="submit"]')
            .invoke('removeAttr', 'disabled')
            .click({ force: true });

        // ==========================================
        // EXPECTED RESULT
        // ==========================================
        cy.url().should('include', '/faqs/create');

        // Memastikan pesan error dari FaqController benar-benar muncul di layar
        cy.contains('Silahkan isi jawaban').should('be.visible');
    });
});