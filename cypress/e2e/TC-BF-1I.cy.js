describe("TC-BF-1I: Admin menyimpan paragraf profile section yang kosong", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/login");
        cy.get("input#email").type("super@admin.com");
        cy.get("input#password").type("admin123");
        cy.get('button[type="submit"]').click();
        cy.url().should("include", "/dashboard");
        cy.visit("http://127.0.0.1:8000/admin/kelola-hero-section");
    });

    it("Admin menyimpan paragraf kosong", () => {
        cy.get('input[name="hero_title"]').clear().type("Solusi Terbaik");
        cy.get('input[name="profile_title"]').clear().type("Profil Kami");
        cy.get('textarea[name="section_text"]').clear();

        cy.get('button[type="submit"]').click({ force: true });

        cy.contains("Paragraf profile tidak boleh kosong").should("exist");
    });
});
