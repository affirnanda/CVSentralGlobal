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
        // Isi pertanyaan dengan data yang valid agar fokus validasi hanya pada jawaban
        cy.get('input[name="question"]').type('Bagaimana cara melacak pesanan saya?');

        // Memastikan kolom jawaban dikosongkan dan menghapus atribut HTML5 'required' 
        // agar browser tidak memblokir form sebelum mencapai backend
        cy.get('textarea[name="answer"]')
            .clear()
            .invoke('removeAttr', 'required');

        // 3. Admin klik Simpan
        // Menghapus 'disabled' dan melakukan 'force click' untuk menghindari blokir validasi JS di frontend
        cy.get('button[type="submit"]')
            .invoke('removeAttr', 'disabled')   
            .click({ force: true });

        // ==========================================
        // EXPECTED RESULT
        // ==========================================
        // Expected Result: Muncul error message "Silahkan isi jawaban"
        // Memastikan Laravel memantulkan kembali (redirect back) user ke halaman create form
        cy.url().should('include', '/faqs/create');

        // Memastikan pesan error dari FaqController benar-benar muncul di layar
        cy.contains('Silahkan isi jawaban').should('be.visible');
    });
});