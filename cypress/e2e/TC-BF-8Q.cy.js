describe('TC-BF-8Q', () => {

    beforeEach(() => {
        cy.visit('/testing/fill-cart');
    });

    it('Berhasil membuat invoice', () => {

        cy.isiCheckoutValid();

        cy.get('#province').select('JAWA TIMUR');

        cy.wait(2000);

        cy.get('input[name="payment_method_id"]')
            .first()
            .check({ force: true });

        cy.get('button[type="submit"]')
            .click();

        cy.contains('Silahkan pilih kota anda')
            .should('exist');
    });

});