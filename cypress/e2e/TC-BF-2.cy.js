describe("Admin Login E2E Tests", () => {
    beforeEach(() => {
        cy.visit("/login");
    });

    it("TC-01: Berhasil Login sebagai Admin", () => {
        cy.get("input#email").type("super@admin.com");
        cy.get("input#password").type("admin123");

        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/dashboard");
    });

    it("TC-02: Gagal Login karena Format Email Tidak Valid", () => {
        cy.get("input#email").type("superadmin");
        cy.get("input#password").type("admin123");

        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/login");

        cy.get(".text-red-500").should("be.visible").and("contain", "email");
    });

    it("TC-03: Gagal Login karena Email Tidak Terdaftar", () => {
        cy.get("input#email").type("tidakada@admin.com");
        cy.get("input#password").type("admin123");

        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/login");

        cy.get(".text-red-500").should("be.visible");
    });

    it("TC-04: Gagal Login karena Password Salah", () => {
        cy.get("input#email").type("super@admin.com");
        cy.get("input#password").type("salahpassword");

        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/login");

        cy.get(".text-red-500").should("be.visible");
    });

    it("TC-05: Gagal Login karena Form Kosong", () => {
        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/login");

        cy.get(".text-red-500").should("be.visible");
    });
});
