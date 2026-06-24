describe("Admin Login E2E Tests (TC-BF-2)", () => {
    beforeEach(() => {
        cy.visit("/login");
    });

    it("TC-BF-2A: Admin login dengan email dan password yang benar", () => {
        cy.get("input#email").type("Super@admin.com");
        cy.get("input#password").type("admin123");

        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/dashboard");
    });

    it("TC-BF-2B: Admin login dengan email yang tidak terdaftar", () => {
        cy.get("input#email").type("unknown@test.com");
        cy.get("input#password").type("admin123");

        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/login");
        cy.get(".text-red-500")
            .should("be.visible")
            .and("contain", "Email yang dimasukkan tidak terdaftar");
    });

    it("TC-BF-2C: Admin login dengan format email salah", () => {
        cy.get("input#email").type("superadmin");
        cy.get("input#password").type("admin123");

        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/login");
        cy.get(".text-red-500")
            .should("be.visible")
            .and("contain", "Format email harus menggunakan @domain.***");
    });

    it("TC-BF-2D: Admin login dengan email kosong", () => {
        cy.get("input#password").type("admin123");

        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/login");
        cy.get(".text-red-500")
            .should("be.visible")
            .and("contain", "Silahkan isi email anda");
    });

    it("TC-BF-2E: Admin login dengan password yang salah", () => {
        cy.get("input#email").type("Super@admin.com");
        cy.get("input#password").type("salah123");

        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/login");
        cy.get(".text-red-500")
            .should("be.visible")
            .and("contain", "Password yang dimasukkan tidak sesuai");
    });

    it("TC-BF-2F: Admin login dengan password kosong", () => {
        cy.get("input#email").type("Super@admin.com");

        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/login");
        cy.get(".text-red-500")
            .should("be.visible")
            .and("contain", "Silahkan isi password anda");
    });
});
