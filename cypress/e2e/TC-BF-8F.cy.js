describe('TC-BF-8F', () => {

    beforeEach(() => {
        cy.visit('/testing/fill-cart');
    });

    it('Berhasil membuat invoice nomor 13 character', () => {

        cy.isiCheckoutValid();

        cy.get('input[name="phone"]')
            .clear()
            .type('1234567890123');

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