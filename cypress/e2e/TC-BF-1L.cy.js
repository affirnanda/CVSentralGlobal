describe("TC-BF-1L: Admin tidak mengunggah gambar profile section", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/login");
        cy.get("input#email").type("super@admin.com");
        cy.get("input#password").type("admin123");
        cy.get('button[type="submit"]').click();
        cy.url().should("include", "/dashboard");
        cy.visit("http://127.0.0.1:8000/admin/kelola-hero-section");
    });

    it("Admin tidak mengunggah gambar profil", () => {
        cy.get('input[name="hero_title"]').clear().type("Solusi Terbaik");
        cy.get('input[name="profile_title"]').clear().type("Profil Kami");
        cy.get('textarea[name="section_text"]').clear().type("Deskripsi Hero");

        cy.get('button[type="submit"]').click({ force: true });

        cy.contains("Konten Berhasil Diubah").should("exist");
    });
});
