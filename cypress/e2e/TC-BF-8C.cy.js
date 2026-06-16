describe('TC-BF-8C', () => {

    beforeEach(() => {
        cy.visit('/testing/fill-cart');
    });

    it('Gagal membuat invoice nama lebih dari 101 character', () => {

        cy.isiCheckoutValid();

        cy.get('input[name="full_name"]')
            .clear()
            .type('A'.repeat(101));

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

        cy.contains('input nama terlalu panjang')
            .should('exist');
    });

});