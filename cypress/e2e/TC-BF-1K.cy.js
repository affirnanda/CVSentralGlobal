describe("TC-BF-1K: Admin mengunggah gambar profile section dengan format salah", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/login");
        cy.get("input#email").type("super@admin.com");
        cy.get("input#password").type("admin123");
        cy.get('button[type="submit"]').click();
        cy.url().should("include", "/dashboard");
        cy.visit("http://127.0.0.1:8000/admin/kelola-hero-section");
    });

    it("Admin mengunggah gambar profil format salah", () => {
        cy.get('input[name="hero_title"]').clear().type("Solusi Terbaik");
        cy.get('input[name="profile_title"]').clear().type("Profil Kami");
        cy.get('textarea[name="section_text"]').clear().type("Deskripsi Hero");

        cy.get('input[type="file"][name="profile_image"]').selectFile(
            {
                contents: Cypress.Buffer.from("dummy pdf"),
                fileName: "file.pdf",
                mimeType: "application/pdf",
            },
            { force: true },
        );
        cy.contains("Format gambar yang diunggah tidak sesuai").should("exist");
    });
});
