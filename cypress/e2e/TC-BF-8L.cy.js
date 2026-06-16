describe('TC-BF-8L', () => {

    beforeEach(() => {
        cy.visit('/testing/fill-cart');
    });

    it('Berhasil membuat invoice', () => {

        cy.isiCheckoutValid();

        cy.get('input[name="address"]').clear();

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

        cy.contains('Silahkan input alamat pengiriman anda')
            .should('exist');
    });
});