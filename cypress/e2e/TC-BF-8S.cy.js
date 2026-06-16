describe('TC-BF-8S', () => {

    beforeEach(() => {
        cy.visit('/testing/fill-cart');
    });

    it('Gagal membuat invoice', () => {

        cy.isiCheckoutValid();

        cy.get('input[name="postal_code"]').clear();

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

        cy.contains('Silahkan input kode pos anda')
            .should('exist');
    });

});