describe("TC-BF-1H: Admin menyimpan paragraf profile section (>255 karakter)", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/login");
        cy.get("input#email").type("super@admin.com");
        cy.get("input#password").type("admin123");
        cy.get('button[type="submit"]').click();
        cy.url().should("include", "/dashboard");
        cy.visit("http://127.0.0.1:8000/admin/kelola-hero-section");
    });

    it("Admin menyimpan paragraf profile section >255 karakter", () => {
        cy.get('input[name="hero_title"]').clear().type("Solusi Terbaik");
        cy.get('input[name="profile_title"]').clear().type("Profil Kami");
        cy.get('textarea[name="section_text"]').clear().type("C".repeat(256));

        cy.get('button[type="submit"]').click({ force: true });

        cy.contains("Paragraf profile terlalu panjang").should("exist");
    });
});
