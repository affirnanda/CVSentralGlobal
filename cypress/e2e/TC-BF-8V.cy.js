describe('TC-BF-8V', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('berhasil membuat pesanan sewa', () => {

        cy.isiCheckoutRentValid();

        cy.get('button[type="submit"]')
            .click();

        cy.url()
            .should('include', '/invoice/');
    });

});