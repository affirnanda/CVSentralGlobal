describe('BF-4: Kelola FAQ', () => {
    it('TC-BF-4F: Admin menambah FAQ dengan jawaban FAQ (>300 karakter)', () => {
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

        // Mengisi pertanyaan dengan data valid
        cy.get('input[name="question"]').type('Bagaimana cara menghubungi customer service?');

        // 2. Admin mengisi jawaban melebihi 300 karakter (contoh: 305 karakter)
        const jawabanLebih = 'C'.repeat(305);

        // Menghapus atribut maxlength pada textarea agar bisa mengetik >300 karakter
        cy.get('textarea[name="answer"]')
            .invoke('removeAttr', 'maxlength')
            .type(jawabanLebih);

        // 3. Admin klik Simpan
        cy.get('button[type="submit"]')
            .invoke('removeAttr', 'disabled')
            .click({ force: true });

        // Expected Result: Muncul error message "Jawaban terlalu panjang"
        cy.url().should('include', '/faqs/create');

        // Memastikan pesan error dari FaqController benar-benar muncul di layar
        cy.contains('Jawaban terlalu panjang').should('be.visible');
    });
});