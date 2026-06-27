describe("TC-BF-1A: Admin mengunggah gambar hero section", () => {
    it("Admin mengunggah gambar hero section", () => {
        cy.visit("/login");
        cy.get("input#email").type("super@admin.com");
        cy.get("input#password").type("admin123");
        cy.get('button[type="submit"]').click();
        cy.url().should("include", "/dashboard");
        cy.visit("/admin/kelola-hero-section");
        cy.get('input[name="hero_title"]').clear().type("Solusi Terbaik");
        cy.get('textarea[name="section_text"], input[name="section_text"]')
            .clear()
            .type("Deskripsi Hero");
        cy.get('input[type="file"][name="hero_image"]').selectFile({
            contents: Cypress.Buffer.from("dummy image"),
            fileName: "hero.png",
            mimeType: "image/png",
        });
        cy.get('button[type="submit"]').click();
        cy.screenshot("TC-BF-1A");
    });
});
