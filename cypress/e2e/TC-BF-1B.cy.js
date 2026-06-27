describe("TC-BF-1B: Admin mengunggah gambar dengan format salah", () => {
    it("Admin mengunggah gambar dengan format pdf", () => {
        cy.visit("/login");
        cy.get("input#email").type("super@admin.com");
        cy.get("input#password").type("admin123");
        cy.get('button[type="submit"]').click({ force: true });
        cy.url().should("include", "/dashboard");
        cy.visit("/admin/kelola-hero-section");
        cy.get('input[name="hero_title"]')
            .clear({ force: true })
            .type("Solusi Terbaik");
        cy.get('textarea[name="section_text"], input[name="section_text"]')
            .clear({ force: true })
            .type("Deskripsi Hero", { force: true });
        cy.get('input[type="file"][name="hero_image"]').selectFile({
            contents: Cypress.Buffer.from("dummy pdf"),
            fileName: "file.pdf",
            mimeType: "application/pdf",
        });
        cy.get('button[type="submit"]').click({ force: true });
        cy.screenshot("TC-BF-1B");
    });
});
