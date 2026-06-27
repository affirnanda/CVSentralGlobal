describe("TC-BF-7: Mengelola Keranjang", () => {
    beforeEach(() => {
        cy.visit("http://127.0.0.1:8000/testing/clear-cart");
        cy.visit("http://127.0.0.1:8000/katalog-produk");
        cy.contains("Katalog Produk Kami").should("exist");
    });

    it("TC-BF-7A: User mengubah jumlah produk di keranjang dengan data tidak melebihi stok", () => {
        cy.get('form[action*="/keranjang/add"]').first().as("formKeranjang");

        cy.get("@formKeranjang").find('input[name="qty"]').clear().type("1");
        cy.get("@formKeranjang").find('button[type="submit"]').click();

        cy.get("#cartButton").click();
        cy.get("#cartSidebar").should("have.class", "right-0");
        cy.wait(500);

        cy.get("#cartSidebar").contains("button", "+").click({ force: true });
        cy.wait(500);
        cy.get("#cartSidebar").contains("button", "+").click({ force: true });
        cy.wait(500);

        cy.get("#cartSidebar")
            .find('span[id^="qty-"]')
            .should("have.text", "3");
    });

    it("TC-BF-7B: User mengubah jumlah produk di keranjang dengan data melebihi stok", () => {
        cy.get('form[action*="/keranjang/add"]').first().as("formKeranjang");

        cy.get("@formKeranjang")
            .find('input[name="qty"]')
            .invoke("attr", "max")
            .then((maxStock) => {
                cy.get("@formKeranjang")
                    .find('input[name="qty"]')
                    .clear()
                    .type(maxStock);
                cy.get("@formKeranjang").find('button[type="submit"]').click();

                cy.get("#cartButton").click();
                cy.get("#cartSidebar").should("have.class", "right-0");
                cy.wait(500);

                cy.get("#cartSidebar")
                    .contains("button", "+")
                    .click({ force: true });
                cy.wait(500);

                cy.get("#cartSidebar")
                    .find('span[id^="qty-"]')
                    .should("have.text", maxStock);
            });
    });

    it("TC-BF-7C: User mengubah jumlah produk di keranjang dengan data stok 0", () => {
        cy.get('form[action*="/keranjang/add"]').first().as("formKeranjang");

        cy.get("@formKeranjang").find('input[name="qty"]').clear().type("1");
        cy.get("@formKeranjang").find('button[type="submit"]').click();

        cy.get("#cartButton").click();
        cy.get("#cartSidebar").should("have.class", "right-0");
        cy.wait(500);

        cy.get("#cartSidebar").contains("button", "-").click({ force: true });
        cy.wait(500);

        cy.reload();
        cy.get("#cartButton").click();
        cy.get("#cartSidebar").contains("Keranjang kosong").should("exist");
    });
});
