describe('TC-BF-8B', () => {

    beforeEach(() => {
        cy.visit('/testing/fill-cart');
    });

    it('Berhasil membuat invoice', () => {

        cy.isiCheckoutValid();

        cy.get('input[name="full_name"]')
            .clear()
            .type('A'.repeat(100));

        cy.get('#province').select('JAWA TIMUR');

        cy.wait(2000);

        cy.get('#city').select('KAB. SIDOARJO');

        cy.wait(2000);

        cy.get('#district').select('Gedangan');

        cy.get('input[name="payment_method_id"]')
            .first()
            .check({ force: true });

        cy.get('button[type="submit"]')
            .click();

        cy.url().should('include', '/invoice/');
    });

});