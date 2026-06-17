describe('BF-4: Kelola FAQ', () => {
    it('TC-BF-4D: Admin menambah FAQ dengan pertanyaan kosong', () => {
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

        // 2. Admin tidak mengisi pertanyaan
        // Kita memastikan input question dikosongkan dan menghapus atribut HTML5 'required'
        // agar browser tidak memblokir proses klik Simpan sebelum mencapai backend Laravel
        cy.get('input[name="question"]')
            .clear()
            .invoke('removeAttr', 'required');

        // Tetap isi jawaban agar fokus error hanya pada validasi 'pertanyaan'
        cy.get('textarea[name="answer"]').type('Ini adalah jawaban standar');

        // 3. Admin klik Simpan
        // Menghapus 'disabled' dan melakukan 'force click' untuk menghindari validasi JS di frontend
        cy.get('button[type="submit"]')
            .invoke('removeAttr', 'disabled')
            .click({ force: true });

        // Expected Result: Muncul error message "Silahkan isi pertanyaan"
        cy.url().should('include', '/faqs/create');
        cy.contains('Silahkan isi pertanyaan').should('be.visible');
    });
});