describe('BF-4: Kelola FAQ', () => {
    it('TC-BF-4E: Admin menambah FAQ dengan jawaban FAQ (≤300 karakter)', () => {
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

        // Mengisi pertanyaan dengan data valid agar fokus pengujian hanya pada jawaban
        cy.get('input[name="question"]').type('Bagaimana kebijakan pengembalian barang?');

        // 2. Admin mengisi jawaban dengan ≤300 karakter (Persis 300 karakter)
        // Menggunakan huruf 'B' sebanyak 300 kali
        const jawabanMaksimal = 'B'.repeat(300);
        cy.get('textarea[name="answer"]').type(jawabanMaksimal);

        // Verifikasi: Jawaban diterima sistem dan disimpan sementara di dalam form textarea
        cy.get('textarea[name="answer"]').should('have.value', jawabanMaksimal);

        // 3. Admin klik Simpan
        // Mengklik submit untuk memastikan backend Laravel juga menerima 300 karakter tersebut
        cy.get('button[type="submit"]').click();

        // Expected Result: Sistem menerima data tanpa error validasi dan kembali ke halaman kelola FAQ
        cy.url().should('include', '/faqs');
        cy.contains('FAQ berhasil ditambahkan!').should('be.visible');

        // Memastikan jawaban yang sangat panjang (300 karakter) tersebut masuk ke tabel/dashboard admin
        // Karena di index menggunakan Str::limit($faq->answer, 100), kita cek 100 karakter pertamanya saja
        const potonganJawaban = 'B'.repeat(100);
        cy.contains(potonganJawaban).should('be.visible');
    });
});