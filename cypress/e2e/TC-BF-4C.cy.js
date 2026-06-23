describe('BF-4: Kelola FAQ', () => {
    it('TC-BF-4C: Admin menambah FAQ dengan pertanyaan >100 karakter', () => {
        // ==========================================
        // PRE-CONDITION: ADMIN LOGIN & MASUK KELOLA FAQ
        // ==========================================
        cy.visit('/login');

        cy.get('input[name="email"]').type('super@admin.com');
        cy.get('input[name="password"]').type('admin123');
        cy.get('button[type="submit"]').click();

        cy.url().should('include', '/dashboard');

        cy.visit('/faqs');
        cy.url().should('include', '/faqs');

        // ==========================================
        // SKENARIO PENGUJIAN
        // ==========================================
        // 1. Admin klik Tambah FAQ
        cy.get('a[href$="/faqs/create"]').click();
        cy.url().should('include', '/faqs/create');

        // 2. Admin mengisi pertanyaan melebihi 100 karakter (contoh: 105 karakter)
        const pertanyaanLebih = 'A'.repeat(105);

        // Menghapus atribut maxlength agar bisa mengetik >100 karakter
        cy.get('input[name="question"]')
            .invoke('removeAttr', 'maxlength')
            .type(pertanyaanLebih);

        cy.get('textarea[name="answer"]').type('Ini adalah jawaban standar');

        // 3. Admin klik Simpan
        cy.get('button[type="submit"]')
            .invoke('removeAttr', 'disabled')
            .click({ force: true });

        // Expected Result: Muncul error message "Pertanyaan terlalu panjang" dari backend
        cy.url().should('include', '/faqs/create');
        cy.contains('Pertanyaan terlalu panjang').should('be.visible');
    });
});