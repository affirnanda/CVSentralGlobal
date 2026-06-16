describe('TC-BF-8G', () => {

    beforeEach(() => {
        cy.visit('/testing/fill-cart');
    });

    it('Gagal membuat invoice nomor 14 character', () => {

        cy.isiCheckoutValid();

        cy.get('input[name="phone"]')
            .clear()
            .type('12345678901234');

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

        cy.contains('nomor WA tidak valid')
            .should('exist');
    });

});